<?php

namespace Phobrv\CoreAdmin\Http\Controllers;
use App\Http\Controllers\Controller;
use Auth;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Repositories\UserRepository;
use Phobrv\CoreAdmin\Services\UnitServices;

class QuestionController extends Controller {
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
		$this->type = config('option.post_type.question');
		$this->taxonomy = config('option.taxonomy.questiongroup');
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
				['text' => 'Questions', 'href' => ''],
			]
		);
		try {
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'question_select');
			if (!isset($data['select']) || $data['select'] == 0) {
				$data['questions'] = $this->postRepository->all()->where('type', 'question');
			} else {
				$data['questions'] = $this->termRepository->getPostsByTermID($data['select']);
			}
			$data['arrayGroup'] = $this->termRepository->getArrayTerms($this->taxonomy);
			return view('admin.question.index')->with('data', $data);
		} catch (Exception $e) {
			return back()->with('alert_danger', $e->getMessage());
		}
	}

	public function updateQuestionGroupSelect(Request $request) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('question_select' => $request->select));
		return redirect()->route('question.index');
	}
	public function setQuestionGroupSelect($id) {
		$user = Auth::user();
		$this->userRepository->insertMeta($user, array('question_select' => $id));
		return redirect()->route('question.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$user = Auth::user();
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Questions', 'href' => ''],
				['text' => 'Create', 'href' => ''],
			]
		);

		try {
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'question_select');
			$data['categorys'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['arrayCategoryID'] = [];
			return view('admin.question.create')->with('data', $data);
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
		if ($request->hasFile('thumb')) {
			$path = $this->unitService->handleUploadImage($request->thumb);
			$data['thumb'] = $path;
		}
		$post = $this->postRepository->create($data);
		$this->updatePostInfo($post, $request);

		$msg = __('Create question success!');
		if ($request->typeSubmit == 'save') {
			return redirect()->route('question.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('question.edit', ['question' => $post->id])->with('alert_success', $msg);
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
		$user = Auth::user();
		//Breadcrumb
		$data['breadcrumbs'] = $this->unitService->generateBreadcrumbs(
			[
				['text' => 'Questions', 'href' => ''],
				['text' => 'Edit', 'href' => ''],
			]
		);
		try {
			$data['select'] = $this->userRepository->getMetaValueByKey($user, 'question_select');
			$data['categorys'] = $this->termRepository->getTermsOrderByParent($this->taxonomy);
			$data['post'] = $this->postRepository->find($id);
			$data['arrayCategoryID'] = $this->termRepository->getArrayTermIDByTaxonomy($data['post']->terms, 'questiongroup');
			$data['meta'] = $this->postRepository->getMeta($data['post']->postMetas);
			return view('admin.question.create')->with('data', $data);
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
		$user = Auth::user();
		$request->request->add(['slug' => $this->unitService->renderSlug($request->title)]);
		$request->validate([
			'slug' => 'required|unique:posts,slug,' . $id,
		]);

		$data = $request->all();
		if ($request->hasFile('thumb')) {
			$path = $this->unitService->handleUploadImage($request->thumb);
			$data['thumb'] = $path;
		}
		$post = $this->postRepository->update($data, $id);

		$this->updatePostInfo($post, $request);
		$msg = __('Update question success!');
		if ($request->typeSubmit == 'save') {
			return redirect()->route('question.index')->with('alert_success', $msg);
		} else {
			return redirect()->route('question.edit', ['question' => $post->id])->with('alert_success', $msg);
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
	public function delete($id) {
		$this->postRepository->destroy($id);
		$msg = __("Delete question success!");
		return redirect()->route('question.index')->with('alert_success', $msg);
	}

	public function updatePostInfo($post, $request) {
		$this->postRepository->updateTagAndCategory($post, [], $request->category);
		$this->postRepository->handleSeoMeta($post, $request);
	}

	/**
	 * Create post Demo Question
	 */
	public function autoCreateQuestion(Faker $faker) {
		//Create Group New
		$term = $this->termRepository->updateOrCreate(
			[
				'name' => 'Question Group',
				'slug' => 'question-group',
				'taxonomy' => $this->taxonomy,
			]
		);

		//Create 20 post
		for ($i = 0; $i < 10; $i++) {
			$title = $faker->sentence;
			$slug = $this->unitService->renderSlug($title);
			$post = $this->postRepository->create([
				'user_id' => '1',
				'title' => $title,
				'slug' => $slug,
				'type' => $this->type,
				'excerpt' => $faker->text,
				'content' => $faker->text,
			]);
			$post->terms()->sync([$term->id]);
			$meta['meta_title'] = $faker->sentence;
			$meta['meta_description'] = $faker->sentence;
			$meta['meta_keywords'] = $faker->sentence;
			$this->postRepository->insertMeta($post, $meta);
		}
		dd("ok");
	}
}
