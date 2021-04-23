<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Term.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class Term extends Model implements Transformable {
	use TransformableTrait;

	protected $table = 'terms';

	protected $fillable = [
		'name', 'slug', 'description', 'taxonomy', 'parent',
	];

	public function termMetas() {
		return $this->hasMany('Phobrv\CoreAdmin\Models\TermMeta');
	}

	public function posts() {
		return $this->belongsToMany('Phobrv\CoreAdmin\Models\Post', 'term_relationships');
	}

}
