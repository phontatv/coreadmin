<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class VideoController extends Controller {
	protected $userRepository;
	protected $termRepository;
	protected $postRepository;
	protected $unitService;
	protected $type;
	protected $taxonomy;

	public function __construct(
		UserRepository $userRepository,
		TermRepository $termRepository,
		PostRepository $postRepository,
		UnitServices $unitService
	) {
		$this->userRepository = $userRepository;
		$this->termRepository = $termRepository;
		$this->postRepository = $postRepository;
		$this->unitService = $unitService;
		$this->type = config('option.post_type.video');
		$this->taxonomy = config('option.taxonomy.videogroup');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$user = Auth::user();
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Videos', 'href' => ''],
			]
		);

		try {
			$data = $this->getData($data);
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'video_select');
			if (!isset($data['select']) || $data['select'] == 0) {
				$data['videos'] = $this->postRepository->all()->where('type', 'video');
			} else {
				$data['videos'] = $this->termRepository->getPostsByTermID($data['select']);
			}
			$data['categorys'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['arrayCategoryID'] = [];

			return view('phobrv::video.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	public function updateVideoGroupSelect(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('video_select' => $request->select));
		return redirect()->route('video.index');
	}
	public function setVideoGroupSelect($id) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('video_select' => $id));
		return redirect()->route('video.index');
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
		$user = Auth::user();
		$request->validate([
			'excerpt' => 'required|unique:posts',
		]);
		try {
			$id_video = $request->excerpt;
			$link = 'https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=' . $id_video . '&format=json';
			$file_headers = get_headers($link);
			if (strlen(strstr($file_headers[0], '404'))) {
				return back()->with('alert_danger', 'Không tồn tại ID Video: ' . $id_video);
			} elseif (strlen(strstr($file_headers[0], '401'))) {
				\Session::put('error_message', );
				return back()->with('alert_danger', 'Không lấy được thông tin từ ID Video: ' . $id_video);
			} else {

				$info = file_get_contents('https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=' . $id_video . '&format=json');

				$info = json_decode($info, true);
				$request->request->add(['title' => $info['title']]);

				$slug = $this->unitService->renderSlug($info['title']);

				$slug = $this->postRepository->handleSlugUniquePost($slug);

				$post = $this->postRepository->create([
					'title' => $info['title'],
					'type' => $this->type,
					'slug' => $slug,
					'excerpt' => $id_video,
					'user_id' => $user->id,
					'thumb' => $info['thumbnail_url'],
				]);
				$this->updatePostInfo($post, $request);

				$msg = "Updata video success!";
				if ($request->typeSubmit == 'save') {
					return redirect()->route('video.index')->with('alert_success', $msg);
				} else {
					return redirect()->route('video.edit', ['video' => $post->id])->with('alert_success', $msg);
				}

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
	public function show() {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Videos', 'href' => ''],
				['text' => 'Edit', 'href' => ''],
			]
		);
		try {
			$data = $this->getData($data);
			$data['post'] = $this->postRepository->find($id);
			$data['categorys'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['arrayCategoryID'] = $this->termRepository->getArrayTermIDByTaxonomy($data['post']->terms, 'videogroup');
			$data['meta'] = $this->postRepository->getMeta($data['post']->postMetas);
			return view('phobrv::video.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$data = $request->all();
		$post = $this->postRepository->update($data, $id);
		$this->updatePostInfo($post, $request);
		$msg = __('Update video success!');
		if ($request->typeSubmit == 'save') {
			return redirect()->route('video.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('video.edit', ['video' => $id])->with('alert_success', $msg);
		}

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

	public function delete($post_id) {
		$this->postRepository->destroy($post_id);
		$msg = __("Delete video success!");
		return redirect()->route('video.index')->with('alert_success', $msg);
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
		return redirect()->route('video.index')
			->with('alert_success', __('Change video order success'));
	}

	public function updatePostInfo($post, $request) {
		$this->postRepository->updateTagAndCategory($post, [], $request->category);
		$this->postRepository->handleSeoMeta($post, $request);
	}
	public function getData($data) {
		$user = Auth::user();
		$data['arrayGroup'] = $this->termRepository->getArrayTerms($this->taxonomy);

		$data['select'] = $this->userRepository->getMetaValueByKey($user, 'video_select');
		if (!isset($data['select']) || $data['select'] == 0) {
			$data['videos'] = $this->postRepository->all()->where('type', $this->type);
		} else {
			$data['videos'] = $this->termRepository->getPostsByTermID($data['select']);
		}
		return $data;
	}
}
