<?php
namespace App\Domain\Destination\Contracts;

use App\Domain\Destination\Entities\Destination;

/**
 * Interface DestinationRepositoryContract
 *
 * @package App\Domain\Destination\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface DestinationRepositoryContract{

	/**
	 * @param Destination $destination
	 * @return mixed
	 */
	public function create(Destination $destination);

	/**
	 * @param Destination $destination
	 * @return mixed
	 */
	public function update(Destination $destination, $data);

	/**
	 * @param Destination $destination
	 * @return mixed
	 */
	public function delete(Destination $destination);

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
	 * @param Destination $destination
	 * @return mixed
	 */
	public function toArray(Destination $destination);

	/**
	 * @param $dql
	 * @param $page
	 * @param $limit
	 * @return mixed
	 */
	public function paginate($dql, $page=1, $limit=10);
}