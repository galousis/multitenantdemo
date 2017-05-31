<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\Tour\Entities\Tour;
use App\Domain\Tour\Contracts\TourRepositoryContract;
use App\Domain\Tour\Exceptions\TourDoesNotExistException;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use App\Interfaces\Api\Http\Controllers\ApiController;


/**
 * Class TourRepository
 *
 * @package App\Infrastructure\Doctrine\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourRepository implements TourRepositoryContract
{

	/**
	 * @var string
	 */
	private $class = Tour::class;

	/**
	 * @var EntityManager
	 */
	private $em;

	/**
	 * UserRepository constructor.
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 * @param Tour $tour
	 * @return void
	 */
	public function create(Tour $tour)
	{
		$this->em->persist($tour);
		$this->em->flush();
	}

	/**
	 * @param Tour $tour
	 * @param $data
	 * @return void
	 */
	public function update(Tour $tour, $data)
	{
		$tour->setName($data['name']);
		$this->em->persist($tour);
		$this->em->flush();
	}

	/**
	 * @param Tour $tour
	 * @return void
	 */
	public function delete(Tour $tour)
	{
		$this->em->remove($tour);
		$this->em->flush();
	}

	/**
	 * create Tour
	 * @return Tour
	 */
	public function load($data)
	{
		return new Tour($data);
	}

	/**
	 * @param $id
	 * @return null|object
	 */
	public function findById($id)
	{
		return $this->em->getRepository($this->class)->findOneBy([
			'id' => $id
		]);
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		$tasks = $this->em->getRepository($this->class)->findAll();
		return $tasks;
	}

	/**
	 * @param Tour $tour
	 * @return array
	 */
	public function toArray(Tour $tour)
	{
		return [
			'id' => $tour->getId(),
			'name' => $tour->getName()
		];
	}

	/**
	 * @param $dql
	 * @param int $page
	 * @param int $limit
	 * @return Paginator
	 */
	public function paginate($dql, $page = 1, $limit = 20)
	{
		$query = $this->em->createQuery($dql)
			->setFirstResult($limit * ($page - 1))
			->setMaxResults($limit);

		$paginator = new Paginator($query, $fetchJoinCollection = true);

		return $this->paginatorToArray($paginator);
	}

	/**
	 * @param Paginator $paginator
	 * @return array
	 */
	public function paginatorToArray(Paginator $paginator)
	{
		$arrayResponse = [];

		foreach($paginator as $manager){
			$arrayResponse[] = $this->toArray($manager);
		}

		return $arrayResponse;
	}


	/**
	 * @param array $filter
	 * @return array
	 */
	public function findByCriteria(array $filter)
	{
		$criteria = $this->addCriteria($filter);
		$result = $this->em->getRepository($this->class)->matching($criteria)->toArray();

		$arrayResponse = [];

		foreach ($result as $manager){
			$arrayResponse[]  = $this->toArray($manager);
		}

		return $arrayResponse;
	}

	/**
	 * @param $filter
	 * @return Criteria
	 */
	public function addCriteria($filter)
	{
		$criteria = Criteria::create();
		$expr = Criteria::expr();

		if (count($filter)) {
			foreach ($filter as $expression => $comparison) {
				if(is_array($comparison[0])){
					foreach ($comparison as $statement){

						list($field, $operator, $value) = $statement;

						if($field === "createdAt" || $field === "updatedAt"){
							$value = new \DateTime($value);

						}

						if ($expression === 'or') {
							$criteria->orWhere($expr->{$operator}($field,$value));
						}

						if ($expression === 'and') {
							$criteria->andWhere($expr->{$operator}($field,$value));
						}
					}
				}
				else{
					list($field, $operator, $value) = $comparison;
					$criteria->where($expr->{$operator}($field,$value));
				}
			}
		}

		return $criteria;
	}

}