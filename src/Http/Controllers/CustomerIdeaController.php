<?php

namespace Phobrv\CoreAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class CustomerIdeaController extends Controller {
	protected $termRepository;
	protected $postRepository;
	protected $unitService;
	protected $type;

	public function __construct(
		TermRepository $termRepository,
		PostRepository $postRepository,
		UnitServices $unitService
	) {
		$this->termRepository = $termRepository;
		$this->postRepository = $postRepository;
		$this->unitService = $unitService;
		$this->type = config('option.post_type.customeridea');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Customer Ideas', 'href' => ''],
			]
		);

		try {
			$data['ideas'] = $this->postRepository->all()->where('type', $this->type);
			return view('admin.customer.index')->with('data', $data);
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
				['text' => 'Customer Ideas', 'href' => ''],
				['text' => 'Create', 'href' => ''],
			]
		);
		try {
			return view('admin.customer.create')->with('data', $data);
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

		$postdata = $request->all();
		$postdata['user_id'] = Auth::id();
		$postdata['type'] = $this->type;
		if ($request->hasFile('thumb')) {
			$path = $this->unitService->handleUploadImage($request->thumb);
			$postdata['thumb'] = $path;
		}
		$post = $this->postRepository->create($postdata);

		$msg = __('Create idea success!');
		if ($request->typeSubmit == 'save') {
			return redirect()->route('customeridea.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('customeridea.edit', ['customeridea' => $post->id])->with('alert_success', $msg);
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
				['text' => 'Customer Ideas', 'href' => ''],
				['text' => 'Edit', 'href' => ''],
			]
		);

		try {
			$data['post'] = $this->postRepository->find($id);
			$data['metas'] = $this->postRepository->getMeta($data['post']->postMetas);
			return view('admin.customer.create')->with('data', $data);
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

		$postdata = $request->all();
		if ($request->hasFile('thumb')) {
			$path = $this->unitService->handleUploadImage($request->thumb);
			$postdata['thumb'] = $path;
		}
		$post = $this->postRepository->update($postdata, $id);

		$msg = __('Update idea success!');
		if ($request->typeSubmit == 'save') {
			return redirect()->route('customeridea.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('customeridea.edit', ['customeridea' => $post->id])->with('alert_success', $msg);
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
}
