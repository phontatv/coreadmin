<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\HandleMenuServices;
use Phobrv\CoreAdmin\Services\UnitServices;

class MenuController extends Controller {

	protected $unitService;
	protected $termRepository;
	protected $postRepository;
	protected $userRepository;
	protected $handleMenuService;
	protected $type;
	protected $taxonomy;

	public function __construct(
		UserRepository $userRepository,
		TermRepository $termRepository,
		PostRepository $postRepository,
		HandleMenuServices $handleMenuService,
		UnitServices $unitService
	) {
		$this->handleMenuService = $handleMenuService;
		$this->userRepository = $userRepository;
		$this->postRepository = $postRepository;
		$this->termRepository = $termRepository;
		$this->unitService = $unitService;
		$this->type = config('option.post_type.menu_item');
		$this->taxonomy = config('option.taxonomy.menugroup');
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
				['text' => 'Manager Menu', 'href' => ''],
				['text' => 'Manager Menu Item', 'href' => ''],
			]
		);
		$data['select'] = $this->userRepository->getMetaValueByKey($user, 'menu_select');

		try {
			$data['term'] = $this->termRepository->findWhere(['id' => $data['select']])->first();
			$data['arrayMenuParent'] = [];
			if ($data['term']) {
				$data['menus'] = $this->handleMenuService->handleMenuItem($data['term']->posts()->orderBy('order')->get());
				$data['arrayMenuParent'] = $this->postRepository->createArrayMenuParent($data['term']->posts, 0);
			}

			$data['submit_label'] = "Create";
			return view('phobrv::menu.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}
	public function setMenuGroupSelect($id) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('menu_select' => $id));
		return redirect()->route('menu.index');
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
		if ($request->subtype == 'link') {
			$request->request->add(['slug' => $this->unitService->renderSlug($request->title) . "-" . rand(0, 9999)]);
		} else {
			$request->request->add(['slug' => $this->unitService->renderSlug($request->title)]);
		}

		$request->validate(
			[
				'slug' => 'required|unique:posts',
				'subtype' => 'required|not_in:0',
			],
			[
				'slug.unique' => 'Name đã tồn tại',
				'slug.required' => 'Name không được phép để rỗng',
			]
		);
		try {
			$data = $request->all();
			$menu = $this->termRepository->find($data['term_id']);
			$data['order'] = ($menu->posts->count() > 0) ? (($menu->posts->sortByDesc('order')->first()['order']) + 1) : 1;
			$data['user_id'] = $user->id;
			$data['status'] = config('option.post_status.publish');
			$data['type'] = $this->type;
			$menu_item = $this->postRepository->create($data);
			$menu_item->terms()->sync($data['term_id']);

			$this->handleSeoMeta($menu_item, $data);

			$msg = __('Create menu success!');
			return redirect()->route('menu.index')->with('alert_success', $msg);

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
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Manager Menu', 'href' => ''],
				['text' => 'Edit Menu Item', 'href' => ''],
			]
		);

		try {
			$data['post'] = $this->postRepository->find($id);
			$data['term'] = $data['post']->terms()->where('taxonomy', $this->taxonomy)->first();

			$data['arrayMenuParent'] = $this->postRepository->createArrayMenuParent($data['term']->posts, $id);
			$data['submit_label'] = "Update";
			$data['meta'] = $this->postRepository->getMeta($data['post']->postMetas);
			$data['meta']['box_sidebars'] = $this->postRepository->getMultiMetaByKey($data['post']->postMetas, 'box_sidebar');
			$data['post']['childs'] = $this->postRepository->findChilds($id);
			return view('phobrv::menu.edit')->with('data', $data);
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
	public function update(Request $request, $item_id) {
		$request->validate(
			[
				'slug' => 'required|unique:posts,slug,' . $item_id,
				'subtype' => 'required|not_in:0',
			],
			[
				'slug.unique' => 'Name đã tồn tại',
				'slug.required' => 'Name không được phép để rỗng',
			]
		);
		try {
			$menuItemData = $request->all();
			$menu_item = $this->postRepository->update($menuItemData, $item_id);

			$this->handleSeoMeta($menu_item, $menuItemData);

			$msg = __('Update menu success!');
			if (isset($request->typeSubmit) && $request->typeSubmit == 'update') {
				return redirect()->route('menu.edit', ['menu' => $item_id])
					->with('alert_success', $msg);
			} else {
				return redirect()->route('menu.index')
					->with('alert_success', $msg);
			}

		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	public function updateContent(Request $request, $item_id) {
		$data = $request->all();
		if ($request->hasFile('thumb')) {
			$path = $this->unitService->handleUploadImage($request->thumb);
			$data['thumb'] = $path;
		}
		$post = $this->postRepository->update($data, $item_id);
		$msg = __('Update menu success!');
		if (isset($request->typeSubmit) && $request->typeSubmit == 'update') {
			return redirect()->route('menu.edit', ['menu' => $item_id])
				->with('alert_success', $msg);
		} else {
			return redirect()->route('menu.index')
				->with('alert_success', $msg);
		}
	}

	public function updateMeta(Request $request, $id) {
		$menu = $this->postRepository->find($id);
		$arrayNotMeta = ['_token'];

		$arrayMeta = array();
		foreach ($request->all() as $key => $value) {
			if (!in_array($key, $arrayNotMeta) && $value) {
				if (strpos($key, "_banner") || strpos($key, "_image") || strpos($key, "_img")) {
					$arrayMeta[$key] = $this->unitService->handleUploadImage($value);
				} else {
					$arrayMeta[$key] = $value;
				}

			}
		}
		if (count($arrayMeta) > 0) {
			$this->postRepository->insertMeta($menu, $arrayMeta);
		}

		$msg = __('Update metas success!');

		return redirect()->route('menu.edit', ['menu' => $id])
			->with('alert_success', $msg);
	}

	public function updateMetaAPI(Request $request) {
		$data = $request->data;
		$menu = $this->postRepository->find($data['menu_id']);
		$arrayMeta = array();
		foreach ($data as $key => $value) {
			$arrayMeta[$key] = $value;
		}
		if (count($arrayMeta) > 0) {
			$this->postRepository->insertMeta($menu, $arrayMeta);
		}

		return response()->json([
			'msg' => 'success',
			'message' => 'Update meta success!',
		]);
	}

	public function uploadFileAPI(Request $request) {
		$data = $request->all();
		if ($request->hasFile('file')) {
			$menu = $this->postRepository->find($data['menu_id']);
			$key = $request->key;
			$path = $this->unitService->handleUploadImage($request->file);
			$arrayMeta[$key] = $path;

			$this->postRepository->insertMeta($menu, $arrayMeta);
			return \Storage::url($path);
		}
		return "";
	}

	public function updateMultiMeta(Request $request, $id) {
		$menu = $this->postRepository->find($id);
		$arrayNotMeta = ['_token'];

		$arrayMeta = array();
		foreach ($request->all() as $key => $value) {
			$this->postRepository->insertMultiMeta($menu, $key, $value);
		}

		$msg = __('Update metas success!');

		return redirect()->route('menu.edit', ['menu' => $id])
			->with('alert_success', $msg);
	}
	public function removeMeta(Request $request) {
		$data = $request->all();
		$this->postRepository->removeMeta($data['meta_id']);
		return $data['meta_id'];
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$menus = $this->postRepository->find($id)->terms;
		$this->postRepository->destroy($id);
		$msg = __('Delete menu item success!');
		return redirect()->route('menu.index', ['menu' => $menus[0]->id])->with('alert_success', $msg);
	}

	public function changeOrder(Request $request, $menu_id, $type) {

		$menu = $this->postRepository->find($menu_id);
		$term = $menu->terms->first();
		$this->postRepository->resetOrderPostByTermID($term->id);
		$parent = $menu->parent;
		$curOrder = $menu->order;
		if ($type == 'plus') {
			if ($parent == 0) {
				$menuReplace = $term->posts()->where('parent', '0')->where('order', '<', $curOrder)->orderBy('order', 'desc')->first();
			} else {
				$menuReplace = $term->posts()->where('parent', $parent)->where('order', '<', $curOrder)->orderBy('order', 'desc')->first();
			}
		} else {
			if ($parent == 0) {
				$menuReplace = $term->posts()->where('parent', '0')->where('order', '>', $curOrder)->orderBy('order')->first();
			} else {
				$menuReplace = $term->posts()->where('parent', $parent)->where('order', '>', $curOrder)->orderBy('order')->first();
			}
		}

		if ($menuReplace) {
			$newOrder = $menuReplace->order;
			$this->postRepository->update(['order' => $newOrder], $menu->id);
			$this->postRepository->update(['order' => $curOrder], $menuReplace->id);
		}

		return redirect()->route('menu.index')->with('alert_success', __('Change menu item order success'));
	}

	public function updateUserSelectMenu(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('menu_select' => $request->select));
		return redirect()->route('menu.index');
	}
	//HAM CHUC NANG
	private function handleSeoMeta($menu_item, $data) {
		$arrayMeta = [
			'meta_thumb' => isset($data['meta_thumb']) ? $data['meta_thumb'] : "",
			'meta_title' => isset($data['meta_title']) ? $data['meta_title'] : $data['title'],
			'meta_description' => isset($data['meta_description']) ? $data['meta_description'] : $data['title'],
			'meta_keywords' => isset($data['meta_keywords']) ? $data['meta_keywords'] : $data['title'],
		];
		$this->postRepository->insertMeta($menu_item, $arrayMeta);
	}
}
