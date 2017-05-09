<?php
namespace App\Domain\User\Contracts;

use App\Domain\User\Entities\User;

/**
 * Interface UserRepositoryContract
 *
 * @package App\Domain\User\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface UserRepositoryContract{

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function create(User $user);

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function update(User $user, $data);

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function delete(User $user);

	/**
	 * @param $data
	 * @return mixed
	 */
	public function load($data);

	/**
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * @return mixed
	 */
	public function findByCriteria(array $criteria);

	/**
	 * @return mixed
	 */
	public function findAll();

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function toArray(User $user);

	/**
	 * @param $email
	 * @return mixed
	 */
	public function findByEmail($email);


	/**
	 * @param $dql
	 * @param $page
	 * @param $limit
	 * @return mixed
	 */
	public function paginate($dql, $page=1, $limit=10);
}