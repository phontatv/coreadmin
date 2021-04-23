<?php

namespace Phobrv\CoreAdmin\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PostRepository.
 *
 * @package namespace App\Repositories;
 */
interface PostRepository extends RepositoryInterface {
	public function updateTagAndCategory($post, $arrayTagName, $arrayCategoryID);

	public function insertMeta($post, $arrayMeta);

	public function getMeta($postMetas);

	public function insertMultiMeta($post, $key, $value);

	public function getMultiMetaByKey($postMetas, $key);

	public function destroy($id);

	public function createArrayMenuParent($posts, $expel_id);

	public function findChilds($id);

	public function getArrayPostByType($type);

	public function handleSeoMeta($post, $request);

	public function getConcern($post);

	public function handleSlugUniquePost($slug);

	public function resetOrderPostByTermID($term_id);

	public function removeMeta($meta_id);

	public function renderSiteMap();

}
