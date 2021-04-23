<?php

namespace Phobrv\CoreAdmin\Repositories;

use Phobrv\CoreAdmin\Models\Comment;
use Phobrv\CoreAdmin\Repositories\CommentRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CommentRepositoryEloquent extends BaseRepository implements CommentRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Comment::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

}
