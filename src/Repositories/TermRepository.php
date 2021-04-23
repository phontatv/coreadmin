<?php

namespace Phobrv\CoreAdmin\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface TermRepository.
 *
 * @package namespace App\Repositories;
 */
interface TermRepository extends RepositoryInterface {
	public function getArrayTerms($type);

	public function getArrayTermsParent($type, $id_expel);

	public function getTerms($type);

	public function getTermsOrderByParent($type);

	public function getTermsChild($id);

	public function getTermSuggest($query, $taxonomy);

	public function getPostsByTermID($id);

	public function getArrayTermIDByTaxonomy($terms, $taxonomy);

	public function destroy($id);

}
