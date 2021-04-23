<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PostMeta.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class PostMeta extends Model implements Transformable {
	use TransformableTrait;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $table = 'post_meta';

	public $timestamps = false;

	protected $fillable = [
		'post_id', 'key', 'value',
	];

	public function post() {
		return $this->belongsTo('Phobrv\CoreAdmin\Models\Post');
	}

}
