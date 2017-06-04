<?php
namespace App\Domain\Tour\Contracts;

use App\Domain\Tour\Entities\Tour;

/**
 * Interface TourRepositoryContract
 *
 * @package App\Domain\Tour\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface TourRepositoryContract{

	/**
	 * @param Tour $tour
	 * @return mixed
	 */
	public function create(Tour $tour);

	/**
	 * @param Tour $tour
	 * @return mixed
	 */
	public function update(Tour $tour, $data);

	/**
	 * @param Tour $tour
	 * @return mixed
	 */
	public function delete(Tour $tour);

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

//	/**
//	 * @param Tour $tour
//	 * @return mixed
//	 */
//	public function toArray(Tour $tour);
//
//	/**
//	 * @param $dql
//	 * @param $page
//	 * @param $limit
//	 * @return mixed
//	 */
//	public function paginate($dql, $page=1, $limit=10);
}