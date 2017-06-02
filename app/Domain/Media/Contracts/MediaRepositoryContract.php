<?php
namespace App\Domain\Media\Contracts;

use App\Domain\Media\Entities\Media;

/**
 * Interface MediaRepositoryContract
 *
 * @package App\Domain\Media\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface MediaRepositoryContract
{

	/**
	 * @param Media $media
	 * @return mixed
	 */
	public function create(Media $media);

}