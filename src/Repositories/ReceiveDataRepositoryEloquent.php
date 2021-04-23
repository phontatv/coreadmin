<?php

namespace Phobrv\CoreAdmin\Repositories;

use App\Repositories\ReceiveDataRepository;
use Phobrv\CoreAdmin\Models\ReceiveData;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ReceiveDataRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ReceiveDataRepositoryEloquent extends BaseRepository implements ReceiveDataRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return ReceiveData::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function insertMeta($receive, $arrayMeta) {
		foreach ($arrayMeta as $key => $value) {
			$receive->receiveDataMetas()->updateOrCreate(
				['receive_data_id' => $receive->id, 'key' => $key, 'value' => $value]
			);
		}
	}

	public function destroy($id) {
		$receive = $this->model->find($id);
		$receive->receiveDataMetas()->delete();
		return $this->model::destroy($id);
	}

}
