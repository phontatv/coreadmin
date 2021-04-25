<?php

namespace Phobrv\CoreAdmin\Repositories;

use Illuminate\Container\Container as Application;
use Phobrv\CoreAdmin\Models\Option;
use Phobrv\CoreAdmin\Repositories\OptionRepository;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Phobrv\CoreAdmin\Services\UnitServices;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class OptionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OptionRepositoryEloquent extends BaseRepository implements OptionRepository {
	private $unitServices;
	private $postRepository;
	private $termRepository;

	public function __construct(
		Application $app,
		UnitServices $unitServices,
		PostRepository $postRepository,
		TermRepository $termRepository
	) {
		parent::__construct($app);
		$this->unitServices = $unitServices;
		$this->postRepository = $postRepository;
		$this->termRepository = $termRepository;
	}
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Option::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function handleOptionToArray($options) {
		$out = array();
		foreach ($options as $key => $option) {
			if (strpos($option->name, "_post")) {
				$out[$option->name . "_source"] = $this->postRepository->findWhere(['id' => $option->value])->first();
			} elseif (strpos($option->name, '_term')) {
				$posts = $this->termRepository->findWhere(['id' => $option->value])->first()->posts->where('status', '1')->take(20);
				$out[$option->name . "_source"] = $posts;
			}
			$out[$option->name] = $option->value;
		}
		return $out;
	}

	public function updateOption($data) {
		if (isset($data['_token'])) {
			unset($data['_token']);
		}
		if (isset($data['robots_txt'])) {
			$this->unitServices->writeFile(config('option.robots_file'), $data['robots_txt']);
		}
		if (isset($data['customize_css'])) {
			$this->unitServices->writeFile(config('option.customize_css_file'), $data['customize_css']);
		}
		if (isset($data['htaccess'])) {
			$this->unitServices->writeFile(config('option.htaccess_file'), $data['htaccess']);
		}
		foreach ($data as $key => $value) {
			if ($value) {
				$this->model->updateOrCreate(
					['name' => $key],
					['value' => $value]
				);
			}
		}
	}
	public function takeArraySidebarBoxTitle() {
		$out = ['0' => '-'];
		$arraySidebarBox = array('box1_title', 'box2_title', 'box3_title', 'box4_title', 'box5_title', 'box6_title', 'box7_title', 'box8_title', 'box9_title', 'box10_title', 'box11_title', 'box12_title', 'box13_title', 'box14_title', 'box15_title', 'box16_title');

		$boxs = $this->model->whereIn('name', $arraySidebarBox)->get();
		foreach ($boxs as $q) {
			$box = explode("_", $q->name);
			$out[$q->name] = $box[0] . " - " . $q->value;
		}

		return $out;
	}
}
