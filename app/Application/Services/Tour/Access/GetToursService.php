<?php
namespace App\Application\Services\Tour\Access;

use App\Application\Services\ApplicationService;
use App\Domain\Tour\Entities\Tour;
use App\Domain\Tour\Contracts\TourRepositoryContract;
use Illuminate\Http\Request;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use App\Application\Exceptions\GetToursServiceException;
use Exception;


/**
 * Class GetToursService
 *
 * @package App\Application\Services\Tour\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class GetToursService implements ApplicationService
{

	#region properties
	/** @var TourRepositoryContract  */
	private $tourRepository;
	#endregion

	#region Constructor
	public function __construct(TourRepositoryContract $tourRepository)
	{
		$this->tourRepository = $tourRepository;
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 * @return mixed
	 * @throws GetToursServiceException
	 */
	public function execute(Request $request)
	{

		try{

			$page = 1;
			$perPage = 5;

			$allTours = $this->tourRepository->paginateAll($perPage);

			return $allTours;


		}catch (Exception $e){
			throw new GetToursServiceException($e->getMessage());
		}
	}

}