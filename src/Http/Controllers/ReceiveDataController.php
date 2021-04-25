<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\ReceiveDataRepository;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class ReceiveDataController extends Controller {
	protected $receiveRepository;
	protected $userRepository;
	protected $unitService;
	protected $arrayReceiveType;
	protected $listReceiveType;

	public function __construct(
		ReceiveDataRepository $receiveRepository,
		UserRepository $userRepository,
		UnitServices $unitService
	) {
		$this->userRepository = $userRepository;
		$this->receiveRepository = $receiveRepository;
		$this->unitService = $unitService;

		$this->listReceiveType = [
			'0' => '-',
			'contact' => 'Liên hệ',
			'poupRegis' => 'Popup đăng ký tư vấn',
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Manager Order', 'href' => ''],
			]
		);
		try {
			$data['listReceiveType'] = $this->listReceiveType;
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'receive_select');
			$data['select_status'] = $this->userRepository->getMetaValueByKey($user, 'select_status');

			$arrayFindWhere = [];
			if ($data['select'] || $data['select_status']) {
				if ($data['select']) {
					$arrayFindWhere['type'] = $data['select'];
				}

				if ($data['select_status']) {
					$arrayFindWhere['status'] = $data['select_status'];
				}

				$data['dataes'] = $this->receiveRepository->orderBy('id', 'desc')->findWhere($arrayFindWhere);
			} else {
				$arrayFindWhere['type'] = array_keys($this->listReceiveType);
				$data['dataes'] = $this->receiveRepository->orderBy('id', 'desc')->findWhereIn('type', $arrayFindWhere['type']);
			}

			return view('admin.receive.index')->with('data', $data);

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	/**
	 * Set default order type select
	 */
	public function setDefaultSelect(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, ['receive_select' => $request->select, 'select_status' => $request->select_status]);
		return redirect()->route('receive.index');
	}
	/**
	 * Update status receive data
	 */

	public function updateStatus($id, $status) {
		$receive = $this->receiveRepository->update(['status' => $status], $id);
		return redirect()->route('receive.index');
	}
}
