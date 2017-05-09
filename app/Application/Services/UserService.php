<?php
namespace App\Application\Services;

use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\User\Services\UserLoginService;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;

/**
 * Class UserService
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserService
{

	#region properties
	/**
	 * @var UserRepositoryContract
	 */
	private $repository;
	#endregion

	#region Constructor
	/**
	 * UserService constructor.
	 * @param UserRepositoryContract $repository
	 */
	public function __construct(UserRepositoryContract $repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods
	/**
	 * @param $email
	 * @param $password
	 * @return mixed
	 */
	public function login($email, $password)
	{
		$managerLogin = new UserLoginService($this->repository);
		$response = $managerLogin->execute($email,$password);

		return JsonResponseDefault::create(true,$response,'successfully logged in',200);
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function createManager($data)
	{
		$manager = $this->repository->load($data);
		$this->repository->create($manager);

		return JsonResponseDefault::create(true,'manager saved successfully','manager saved successfully',200);
	}

	/**
	 * @param $limit
	 * @return mixed
	 */
	public function getByPage($page,$limit)
	{
		$sql = "SELECT u FROM Domain\Manager\Entities\Manager u ";
		$pagination = $this->repository->paginate($sql,$page,$limit);

		return JsonResponseDefault::create(true,$pagination,'managers retrieved successfully',200);
	}

	/**
	 * @param $criteria
	 * @return mixed
	 */
	public function getByFilter($criteria)
	{
		$filter = $this->repository->findByCriteria($criteria);

		return JsonResponseDefault::create(true,$filter,'managers retrieved successfully',200);
	}
	#endregion

}