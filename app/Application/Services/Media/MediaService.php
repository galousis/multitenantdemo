<?php
namespace App\Application\Services\Media;

use App\Domain\Media\Contracts\MediaRepositoryContract;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;


/**
 * Class MediaService
 *
 * @package App\Application\Services\Media
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class MediaService
{
	#region properties
	/**
	 * @var MediaRepositoryContract
	 */
	private $repository;
	#endregion

	#region Constructor
	/**
	 * UserService constructor.
	 * @param MediaRepositoryContract $repository
	 */
	public function __construct(MediaRepositoryContract $repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods
	/**
	 * @return MediaRepositoryContract
	 */
	public function getRepository()
	{
		return $this->repository;
	}
	#endregion

}