<?php
namespace Phobrv\CoreAdmin\Services;
use Phobrv\CoreAdmin\Repositories\PostRepository;
use Phobrv\CoreAdmin\Repositories\TermRepository;

class HandleMenuServices {
	protected $termRepository;
	protected $postRepository;
	public function __construct(
		PostRepository $postRepository,
		TermRepository $termRepository
	) {
		$this->termRepository = $termRepository;
		$this->postRepository = $postRepository;
	}
	public function getMenus($configs, $menu_key, $disablePrivateMenu = NULL) {
		if (!isset($configs[$menu_key])) {
			return "";
		}
		$posts = $this->termRepository->find($configs[$menu_key])->posts()->orderBy('order')->with('postMetas')->get();
		return $this->handleMenuItem($posts, $disablePrivateMenu);
	}
	public function handleMenuItem($posts, $disablePrivateMenu = NULL) {

		$menus = array();
		$curRequest = str_replace("/", "", $_SERVER['REQUEST_URI']);
		foreach ($posts as $p) {
			if ($disablePrivateMenu == NULL || $p->status == 1) {

				$p->active = $this->handleMenuAcitve($p, $curRequest);
				$p->url = $this->handleUrlMenu($p);
				$icon = $p->postMetas->where('key', 'icon')->first();
				$p->icon = isset($icon->value) ? $icon->value : '';

				if ($p->parent == 0) {
					if ($disablePrivateMenu != NULL) {
						$childs = $this->postRepository->where('parent', $p->id)->where('status', '1')->orderBy('order')->get();
					} else {
						$childs = $this->postRepository->where('parent', $p->id)->orderBy('order')->get();
					}

					if ($childs) {
						if ($childs->where('slug', $curRequest)->first()) {
							$p->active = "active";
						}
						for ($i = 0; $i < count($childs); $i++) {
							$childs[$i]->url = $this->handleUrlMenu($childs[$i]);
						}
						$p->childs = $childs;
					}
					array_push($menus, $p);
				}
			}

		}
		return $menus;
	}
	public function handleMenuAcitve($p, $curRequest) {
		if ($p->subtype == "home" && $curRequest == "") {
			$active = "active";
		} elseif ($curRequest == $p->slug) {
			$active = "active";
		} else {
			$active = "";
		}

		return $active;
	}
	public function handleUrlMenu($p) {
		$url = "";
		if ($p->subtype == "home") {
			$url = route('home');
		} elseif ($p->subtype == "link") {
			$url = $p->excerpt;
		} else {
			$url = route('level1', ['slug' => $p->slug]);
		}
		return $url;
	}
}