<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\Tour\Entities\Tour;
use App\Domain\Tour\Contracts\TourRepositoryContract;
use App\Domain\Tour\Exceptions\TourDoesNotExistException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use App\Interfaces\Api\Http\Controllers\ApiController;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;


/**
 * Class TourRepository
 *
 * @package App\Infrastructure\Doctrine\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourRepository implements TourRepositoryContract
{

	use PaginatesFromRequest;

	/**
	 * @var string
	 */
	private $class = Tour::class;

	/**
	 * @var EntityManagerInterface
	 */
	private $_em;

	/**
	 * TourRepository constructor.
	 * @param EntityManagerInterface $_em
	 */
	public function __construct(EntityManagerInterface $_em)
	{
		$this->_em = $_em;
	}

	/**
	 * @param Tour $tour
	 * @return void
	 */
	public function create(Tour $tour)
	{
		$this->_em->persist($tour);
		$this->_em->flush();
	}

	/**
	 * @param Tour $tour
	 * @param $data
	 * @return void
	 */
	public function update(Tour $tour, $data)
	{
		$tour->setName($data['name']);
		$this->_em->persist($tour);
		$this->_em->flush();
	}

	/**
	 * @param Tour $tour
	 * @return void
	 */
	public function delete(Tour $tour)
	{
		$this->_em->remove($tour);
		$this->_em->flush();
	}

	/**
	 * @param $data
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
		return $this->_em->getRepository($this->class)->findOneBy([
			'id' => $id
		]);
	}

	/**
	 * @return array
	 */
	public function findAll()
	{


		$tasksBuilder = $this->_em->getRepository($this->class);
		$tasks = $tasksBuilder->findAll();
		return $tasks;
	}

	/**
	 * Creates a new QueryBuilder instance that is prepopulated for this entity name.
	 *
	 * @param string $alias
	 * @param string $indexBy The index for the from.
	 *
	 * @return QueryBuilder
	 */
	public function createQueryBuilder($alias, $indexBy = null)
	{
		return $this->_em->createQueryBuilder()
			->select($alias)
			->from(Tour::class, $alias, $indexBy);
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
	 * @param array $filter
	 * @return array
	 */
	public function findByCriteria(array $filter)
	{
		$criteria = $this->addCriteria($filter);
		$result = $this->_em->getRepository($this->class)->matching($criteria)->toArray();

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