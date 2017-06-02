<?php
namespace App\Application\Services\Tour\Access;

use App\Application\Services\ApplicationService;
use App\Domain\Tour\Entities\Tour;
use App\Domain\Tour\Contracts\TourRepositoryContract;
use Illuminate\Support\Facades\Request;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use App\Application\Exceptions\GetToursServiceException;
use Exception;
use Doctrine\ORM\Tools\Pagination\Paginator;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator as ILengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatorAdapter;


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
//	/** @var ILengthAwarePaginator  */
//	private $pagin;
	#endregion

	#region Constructor
	public function __construct(TourRepositoryContract $tourRepository)
	{
		$this->tourRepository = $tourRepository;
//		$this->pagin = $pagin;
	}
	#endregion

	#region Methods
	/**
	 * @param null $request
	 * @return mixed
	 * @throws GetToursServiceException
	 */
	public function execute($request = null)
	{

		try{

			$allTours = $this->tourRepository->findAll();

			$page = 1;
			$perPage = 5;

//			$path        = Paginator::resolveCurrentPath();

			$r = new LengthAwarePaginator(
				$allTours,
				count($allTours),
				$perPage,
				$page
			);

			return $r;

//			$sql 		= "SELECT u FROM App\Domain\User\Entities\User u ";
//			$pagination = $this->userRepository->paginate($sql, $request->input('page'), $request->input('limit'));
//			return JsonResponseDefault::create(true, $pagination, 'users retrieved successfully', 200);

		}catch (Exception $e){
			throw new GetToursServiceException($e->getMessage());
		}
	}

}