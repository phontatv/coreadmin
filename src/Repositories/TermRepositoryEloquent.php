<?php

namespace Phobrv\CoreAdmin\Repositories;
use Phobrv\CoreAdmin\Models\Term;
use Phobrv\CoreAdmin\Repositories\TermRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TermRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TermRepositoryEloquent extends BaseRepository implements TermRepository {

	public function model() {
		return Term::class;
	}

	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}
	public function getPostsByTermID($termID) {
		if ($this->findWhere(['id' => $termID])->count()) {
			return $this->find($termID)->posts()->orderBy('created_at', 'desc')->with('user')->get();
		} else {
			return null;
		}
	}
	public function getArrayTerms($type) {
		$out = array();
		$out[0] = '-';
		$categorys = $this->model::where('taxonomy', $type)->where('parent', '0')->get();
		foreach ($categorys as $c) {
			$out[$c->id] = $c->name;
			$childs = $this->model::where('parent', $c->id)->get();
			foreach ($childs as $child) {
				$out[$child->id] = "---" . $child->name;
			}
		}
		return $out;
	}
	public function getArrayTermsParent($type, $id_expel) {
		$out = array();
		$out[0] = '-';
		$categorys = $this->model::where('taxonomy', $type)
			->where('parent', 0)
			->where('id', '<>', $id_expel)->get();

		foreach ($categorys as $c) {
			$out[$c->id] = $c->name;
		}
		return $out;
	}
	public function getTerms($type) {
		return $this->model::where('taxonomy', $type)->with('posts')->get();
	}
	public function getTermsOrderByParent($type) {
		$categorys = $this->model::where('taxonomy', $type)->where('parent', '0')->get();
		if ($categorys) {
			foreach ($categorys as $key => $c) {
				$categorys[$key]->child = $this->model::where('taxonomy', $type)
					->where('parent', $c->id)->get();
			}
		}
		return $categorys;
	}
	public function getTermsChild($id) {
		return $this->model::where('parent', $id)->get();
	}
	public function getTermSuggest($query, $taxonomy) {
		return Term::where('taxonomy', $taxonomy)->where('name', 'like', '%' . $query . '%')->get();
	}
	public function getArrayTermIDByTaxonomy($terms, $taxonomy) {
		$out = array();
		foreach ($terms as $t) {
			if ($t->taxonomy == $taxonomy) {
				array_push($out, $t->id);
			}
		}
		return $out;
	}
	public function getArrayTermByTaxonomy($terms, $taxonomy) {
		$out = [];
		foreach ($terms as $t) {
			if ($t->taxonomy == $taxonomy) {
				$out[$t->id] = $t->name;
			}
		}
		return $out;
	}
	public function destroy($id) {
		return $this->model::destroy($id);
	}
}
