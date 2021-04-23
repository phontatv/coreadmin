<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Option.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class Option extends Model implements Transformable {
	use TransformableTrait;

	protected $table = 'options';

	protected $fillable = [
		'name', 'value', 'autoload',
	];

	public $timestamps = false;
}
