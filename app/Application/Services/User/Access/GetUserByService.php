<?php
namespace App\Application\Services\User\Access;

use App\Application\Services\ApplicationService;
use App\Domain\User\Entities\User;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Application\Services\DataTransformer\User\UserDataTransformer;
use Illuminate\Http\Request;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use App\Application\Exceptions\GetUserByServiceException;
use Exception;

/**
 * Class GetBy
 *
 * @package ${NAMESPACE}
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class GetUserByService implements ApplicationService
{

	#region properties
	/** @var UserRepositoryContract  */
	private $userRepository;
	/** @var UserDataTransformer  */
	private $userDataTransformer;
	#endregion

	#region Constructor
	public function __construct(
		UserRepositoryContract $userRepository,
		UserDataTransformer $userDataTransformer
	) {
		$this->userRepository = $userRepository;
		$this->userDataTransformer = $userDataTransformer;
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 * @return mixed
	 * @throws GetUserByServiceException
	 */
	public function execute(Request $request)
	{

		try{

			if ($request->has('filter'))
			{
				$criteria 	= $request->has('filter');
				$filter 	= $this->userRepository->findByCriteria($criteria);
				return JsonResponseDefault::create(true,$filter,'users retrieved successfully',200);

			}
			else
			{
				$sql 		= "SELECT u FROM App\Domain\User\Entities\User u ";
				$pagination = $this->userRepository->paginate($sql, $request->input('page'), $request->input('limit'));
				return JsonResponseDefault::create(true, $pagination, 'users retrieved successfully', 200);
			}


		}catch (Exception $e){
			throw new GetUserByServiceException($e->getMessage());
		}
	}
	#endregion
}