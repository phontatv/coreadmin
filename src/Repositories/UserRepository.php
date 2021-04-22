<?php

namespace Phobrv\CoreAdmin\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserRepository extends RepositoryInterface {
	public function insertMeta($user, $arrayMeta);

	public function getMetaValueByKey($user, $key);

	public function getMeta($userMetas);

	public function getArrayMailReport();

}
