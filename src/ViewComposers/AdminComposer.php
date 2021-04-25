<?php
namespace Phobrv\CoreAdmin\ViewComposers;

use Illuminate\View\View;
use Phobrv\CoreAdmin\Repositories\OptionRepository;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;

class AdminComposer {
	public $templateMenu = [];
	public $arrayAlbum = [];
	public $arrayMenu = [];
	public $arrayVideo = [];
	public $arrayVideoItem = [];
	public $arrayCategory = [];
	public $arrayPosts = [];
	public $arrayBoxSidebar = [];
	public $admin_language;
	public $arrayProductGroup = [];
	public $arrayQuestionGroup = [];
	public $arrayCrawlerType = [];
	public $arrayBrand = [];
	/**
	 * Create a movie composer.
	 *
	 * @return void
	 */
	public function __construct(TermRepository $termRepository, PostRepository $postRepository, OptionRepository $optionRepository) {
		$this->templateMenu = [
			'0' => '-',
			'home' => 'Home',
			'link' => 'Link',
			'category' => 'Nhóm bài viết',
			'article' => 'Bài viết',
			'order' => 'Đặt hàng',
			'contact' => 'Liên hệ',
			'product' => 'Nhóm sản phẩm',
		];
		$this->arrayCrawlerType = [
			'rss' => 'RSS',
			'category' => 'Category',
			'post' => 'Post',
		];
		$this->arrayAlbum = $termRepository->getArrayTerms(config('option.taxonomy.albumgroup'));
		$this->arrayVideo = $termRepository->getArrayTerms(config('option.taxonomy.videogroup'));
		$this->arrayVideoItem = $postRepository->getArrayPostByType(config('option.taxonomy.video'));
		$this->arrayPosts = $postRepository->getArrayPostByType(config('option.post_type.post'));
		$this->arrayCategory = $termRepository->getArrayTerms(config('option.taxonomy.category'));
		$this->arrayQuestionGroup = $termRepository->getArrayTerms(config('option.taxonomy.questiongroup'));
		$this->arrayMenu = $termRepository->getArrayTerms(config('option.taxonomy.menugroup'));
		$this->arrayBoxSidebar = $optionRepository->takeArraySidebarBoxTitle();
		$this->arrayBrand = $termRepository->getArrayTerms(config('option.taxonomy.brand'));
		$this->arrayProductGroup = $termRepository->getArrayTerms(config('option.taxonomy.product'));
	}

	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view) {
		$view->with('templateMenu', $this->templateMenu);
		$view->with('arrayAlbum', $this->arrayAlbum);
		$view->with('arrayVideo', $this->arrayVideo);
		$view->with('arrayVideoItem', $this->arrayVideoItem);
		$view->with('arrayPosts', $this->arrayPosts);
		$view->with('arrayCategory', $this->arrayCategory);
		$view->with('arrayMenu', $this->arrayMenu);
		$view->with('arrayBrand', $this->arrayBrand);
		$view->with('arrayBoxSidebar', $this->arrayBoxSidebar);
		$view->with('arrayProductGroup', $this->arrayProductGroup);
		$view->with('arrayCrawlerType', $this->arrayCrawlerType);
		$view->with('arrayQuestionGroup', $this->arrayQuestionGroup);
	}
}