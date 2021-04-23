<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReceiveDataMeta.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class ReceiveDataMeta extends Model implements Transformable {
	use TransformableTrait;

	protected $table = 'receive_data_meta';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'receive_data_id', 'key', 'value',
	];
	public $timestamps = false;

	public function receiveData() {
		return $this->belongsTo('Phobrv\CoreAdmin\Models\ReceiveData');
	}

}
