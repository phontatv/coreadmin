<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class Post extends Model implements Transformable {
	use TransformableTrait;

	protected $table = 'posts';

	protected $fillable = [
		'user_id', 'title', 'slug', 'thumb', 'content', 'excerpt', 'status', 'type', 'subtype', 'parent', 'order', 'view', 'created_at',
	];

	protected $with = ['postMetas'];

	public function postMetas() {
		return $this->hasMany('Phobrv\CoreAdmin\Models\PostMeta');
	}

	public function comments() {
		return $this->hasMany('Phobrv\CoreAdmin\Models\Comment');
	}

	public function terms() {
		return $this->belongsToMany('Phobrv\CoreAdmin\Models\Term', 'term_relationships');
	}

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

}
