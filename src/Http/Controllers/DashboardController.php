<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use Analytics;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\ReceiveDataRepository;
use Phobrv\CoreAdmin\Services\UnitServices;
use Spatie\Analytics\Period;

class DashboardController extends Controller {
	protected $unitService;
	protected $postRepository;
	protected $receiveRepository;
	public function __construct(
		UnitServices $unitService,
		PostRepository $postRepository,
		ReceiveDataRepository $receiveRepository
	) {
		$this->unitService = $unitService;
		$this->postRepository = $postRepository;
		$this->receiveRepository = $receiveRepository;
	}

	public function index() {
		$user = Auth::user();
		// dd(config('app.locale'));
		try {
			//Breadcrumbs
			$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
				[
					['text' => 'Dashboard', 'href' => ''],
				]
			);

			return view('phobrv::dashboard.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}
	public function data() {
		$startDate = Carbon::now()->startOfDay();
		$endDate = Carbon::now()->endOfDay();
		$reportTrafficInDay = Analytics::performQuery(
			Period::create($startDate, $endDate),
			'ga:sessions',
			[
				'metrics' => 'ga:sessions, ga:pageviews',
				'dimensions' => 'ga:hour',
			]
		);
		/**
		 * [$trafficSource description]
		 * @var [type]
		 * ga:sessions: The total number of sessions.
		 * ga:pageviews : Số lần xem trang
		 * ga:sessionDuration : Tổng thời lượng xem trang
		 * ga:exitRate : Tỷ lệ phần trăm thoát
		 * ga:bounceRate : Tỷ lệ thoát
		 * ga:avgSessionDuration : Thời gian trung bình của phiên
		 * ga:percentNewSessions : Tỷ lệ phân trăm phiên mới
		 * ga:newUsers : Người dùng mới
		 * ga:users : Tổng số người xem trang
		 * ga:pageviewsPerSession : Số lượng trang trung bình / phiên
		 */
		$trafficSource = Analytics::performQuery(
			Period::create($startDate, $endDate),
			'ga:sessions',
			[
				'dimensions' => 'ga:source,ga:medium',
				'metrics' => 'ga:sessions,ga:pageviews,ga:sessionDuration,ga:exitRate,ga:bounceRate,ga:avgSessionDuration,ga:percentNewSessions,ga:newUsers,ga:users,ga:pageviewsPerSession',
				'sort' => '-ga:sessions',
			]
		);

		$data['topVisitorAndPageView'] = Analytics::fetchVisitorsAndPageViews(Period::days(360))->sortByDesc('pageViews')->take(10);
		$data['trafficSource'] = $trafficSource['totalsForAllResults'];
		$data['reportTrafficInDay'] = json_encode($reportTrafficInDay['rows']);
		$data['count_blog'] = $this->postRepository->findWhere(['type' => 'post'])->count();
		$orders = $this->receiveRepository->findWhere(['type' => 'order']);
		$data['count_order'] = $orders->count();
		$data['count_order_success'] = $orders->where('status', 'success')->count();
		$data['count_order_pendding'] = $orders->where('status', 'pendding')->count();
		return view('phobrv::dashboard.data')->with('data', $data);
	}
}
