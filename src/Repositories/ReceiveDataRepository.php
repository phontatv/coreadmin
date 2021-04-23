<?php

namespace Phobrv\CoreAdmin\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ReceiveDataRepository.
 *
 * @package namespace App\Repositories;
 */
interface ReceiveDataRepository extends RepositoryInterface {
	public function insertMeta($receive, $arrayMeta);
	public function destroy($id);

}
