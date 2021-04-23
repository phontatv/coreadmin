<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TermMeta.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class TermMeta extends Model implements Transformable {
	use TransformableTrait;

	protected $table = 'term_meta';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'term_id', 'key', 'value',
	];

	public function term() {
		return $this->belongsTo('Phobrv\CoreAdmin\Models\Term');
	}

}
