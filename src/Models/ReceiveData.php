<?php

namespace Phobrv\CoreAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReceiveData.
 *
 * @package namespace Phobrv\CoreAdmin\Models;
 */
class ReceiveData extends Model implements Transformable {
	use TransformableTrait;
	protected $table = 'receive_data';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'phone', 'add', 'title', 'description', 'note', 'content', 'type', 'status'];

	public function receiveDataMetas() {
		return $this->hasMany('Phobrv\CoreAdmin\Models\ReceiveDataMeta');
	}

}
