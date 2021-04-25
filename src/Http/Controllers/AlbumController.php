<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class AlbumController extends Controller {
	protected $termRepository;
	protected $postRepository;
	protected $unitService;

	public function __construct(
		TermRepository $termRepository,
		PostRepository $postRepository,
		UnitServices $unitService
	) {
		$this->termRepository = $termRepository;
		$this->postRepository = $postRepository;
		$this->unitService = $unitService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($id) {
		try {
			$data['post'] = $this->termRepository->find($id);
			//Breadcrumb
			$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
				[
					['text' => 'Albums', 'href' => ''],
					['text' => $data['post']->name, 'href' => ''],
				]
			);
			$data['images'] = $data['post']->posts()->orderBy('order')->get();
			return view('phobrv::album.index')->with('data', $data);
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
	public function store(Request $request, $id) {
		$user = Auth::user();

		try {
			$album = $this->termRepository->find($id);
			$data = $request->all();

			if (isset($data['images'])) {
				$images = explode(",", $data['images']);
				$arrayImageID = array();
				if ($images && count($images) > 0) {
					foreach ($images as $key => $img) {
						$arrayImg = explode("/", $img);
						$imgName = end($arrayImg) . "_" . rand(1000, 9999);
						$postImg = $this->postRepository->create(
							[
								'user_id' => $user->id,
								'title' => $imgName,
								'slug' => $imgName,
								'thumb' => $img,
								'excerpt' => '#',
								'type' => 'image',
								'order' => isset($album->posts) ? (count($album->posts) + 1) : 1,
							]
						);
						array_push($arrayImageID, $postImg->id);
					}
					$album->posts()->attach($arrayImageID);

				}
			}

			$msg = "Update album success!";
			if ($data['typeSubmit'] == 'save') {
				return redirect()->route('album.index')->with('alert_success', $msg);
			} else {
				return redirect()->route('album.index', ['id' => $id])->with('alert_success', $msg);
			}

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		try {

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
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

	}

	public function updataImages(Request $request, $id) {
		$data = $request->all();

		$ids = $data['id'];
		foreach ($ids as $key => $_id) {
			$this->postRepository->update(
				[
					'title' => $data['title'][$key],
					'excerpt' => $data['excerpt'][$key],
				],
				$_id
			);
		}
		$msg = __('Update images success!');
		return redirect()->route('album.index', ['id' => $id])->with('alert_success', $msg);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, $img_id) {

	}
	public function delete($group_id, $img_id) {
		$this->postRepository->destroy($img_id);
		$msg = __("Delete video success!");
		return redirect()->route('album.index', ['id' => $group_id])->with('alert_success', $msg);
	}
	public function changeOrder(Request $request, $id, $img_id, $type) {
		$this->postRepository->resetOrderPostByTermID($id);
		$img = $this->postRepository->find($img_id);
		$parent = $img->parent;
		$curOrder = $img->order;
		if ($type == 'plus') {
			$imgReplace = $this->termRepository->find($id)->posts()->where('order', '<', $curOrder)->orderBy('order', 'desc')->first();

		} else {
			$imgReplace = $this->termRepository->find($id)->posts()->where('order', '>', $curOrder)->orderBy('order')->first();
		}

		if ($imgReplace) {
			$newOrder = $imgReplace->order;
			$this->postRepository->update(['order' => $newOrder], $img->id);
			$this->postRepository->update(['order' => $curOrder], $imgReplace->id);
		}
		return redirect()->route('album.index', ['id' => $id])
			->with('alert_success', __('Change image order success'));
	}
}
