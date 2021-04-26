<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class ProductController extends Controller {
	protected $userRepository;
	protected $termRepository;
	protected $postRepository;
	protected $unitService;
	protected $taxonomy;
	protected $type;

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
		$this->taxonomy = config('option.taxonomy.product');
		$this->type = config('option.post_type.product');
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
				['text' => 'Products', 'href' => ''],
			]
		);

		try {

			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'product_select');
			$data['arrayGroup'] = $this->termRepository->getArrayTerms($this->taxonomy);

			if (!isset($data['select']) || $data['select'] == 0) {
				$data['products'] = $this->postRepository->all()->where('type', 'product');
			} else {
				$data['products'] = $this->termRepository->getPostsByTermID($data['select']);

			}
			return view('phobrv::product.index')->with('data', $data);
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
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Products', 'href' => ''],
				['text' => 'Create', 'href' => ''],
			]
		);

		try {
			$data['group'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['arrayGroupID'] = array();
			return view('phobrv::product.create')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$request->request->add(['slug' => $this->unitService->renderSlug($request->title)]);
		$request->validate([
			'slug' => 'required|unique:posts',
		]);

		$data = $request->all();
		$data['user_id'] = Auth::id();
		$data['type'] = $this->type;
		$post = $this->postRepository->create($data);

		$msg = __('Create prodcut success!');

		if ($request->typeSubmit == 'save') {
			return redirect()->route('productitem.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('productitem.edit', ['productitem' => $post->id])->with('alert_success', $msg);
		}

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
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Products', 'href' => ''],
				['text' => 'Edit', 'href' => ''],
			]
		);

		try {
			$data['group'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['post'] = $this->postRepository->find($id);
			$data['arrayGroupID'] = $this->termRepository->getArrayTermIDByTaxonomy($data['post']->terms, $this->taxonomy);
			$data['gallery'] = $this->postRepository->getMultiMetaByKey($data['post']->postMetas, "image");
			$data['meta'] = $this->postRepository->getMeta($data['post']->postMetas);
			return view('phobrv::product.edit')->with('data', $data);
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
		$request->request->add(['slug' => $this->unitService->renderSlug($request->title)]);
		$request->validate([
			'slug' => 'required|unique:posts,slug,' . $id,
		]);
		$data = $request->all();

		$post = $this->postRepository->update($data, $id);

		if (isset($data['group'])) {
			$post->terms()->sync($data['group']);
		}

		$this->postRepository->handleSeoMeta($post, $request);
		$this->handleMeta($post, $request);

		$msg = __('Update  prodcut success!');

		if ($request->typeSubmit == 'save') {
			return redirect()->route('productitem.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('productitem.edit', ['productitem' => $post->id])->with('alert_success', $msg);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$this->postRepository->destroy($id);
		$msg = __("Delete post success!");
		return redirect()->route('productitem.index')->with('alert_success', $msg);
	}

	public function updateUserSelectGroup(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('product_select' => $request->select));
		return redirect()->route('productitem.index');
	}
	/**
	 * Handle Meta Product
	 */
	public function handleMeta($post, $request) {
		$arrayMeta = [];
		$arrayMeta['price'] = isset($request->price) ? $request->price : '';
		// $arrayMeta['code'] = isset($request->code) ? $request->code : '';
		// $arrayMeta['count'] = isset($request->count) ? $request->count : '';
		// $arrayMeta['madein'] = isset($request->madein) ? $request->madein : '';
		// $arrayMeta['price_old'] = isset($request->price_old) ? $request->price_old : '0';
		// $arrayMeta['unit'] = isset($request->unit) ? $request->unit : '';
		// $arrayMeta['brand'] = isset($request->brand) ? $request->brand : '';
		// $arrayMeta['pack'] = isset($request->pack) ? $request->pack : '';
		// $arrayMeta['album_id'] = isset($request->album_id) ? $request->album_id : '';
		$this->postRepository->insertMeta($post, $arrayMeta);

		$data = $request->all();
		if (isset($data['images'])) {
			$this->uploadGallery($post, $data['images']);
		}
	}
	public function uploadGallery($product, $images) {
		$images = explode(",", $images);
		if ($images && count($images) > 0) {
			foreach ($images as $key => $path) {
				$this->postRepository->insertMultiMeta($product, 'image', $path);
			}
		}
	}

	public function deleteMetaAPI(Request $request) {
		$meta_id = $request->meta_id;
		$this->postRepository->removeMeta($meta_id);
		return $meta_id;
	}
}
