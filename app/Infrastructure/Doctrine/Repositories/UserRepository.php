<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\Exceptions\UserDoesNotExistException;
use Doctrine\ORM\EntityManager;
use App\Domain\User\Contracts\UserRepositoryContract;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use App\Interfaces\Api\Http\Controllers\ApiController;

/**
 * Class UserRepository
 *
 * @package App\Infrastructure\Doctrine\Mappings\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserRepository implements UserRepositoryContract
{
	/**
	 * @var string
	 */
	private $class = User::class;

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
	 * @param User $user
	 */
	public function create(User $user)
	{
		$this->em->persist($user);
		$this->em->flush();
	}

	/**
	 * @param User $user
	 * @param $data
	 */
	public function update(User $user, $data)
	{
		$user->setName($data['name']);
		$user->setEmail($data['email']);
		$user->setPassword($data['password']);
		$this->em->persist($user);
		$this->em->flush();
	}

	/**
	 * @param User $user
	 */
	public function delete(User $user)
	{
		$this->em->remove($user);
		$this->em->flush();
	}

	/**
	 * create User
	 * @return User
	 */
	public function load($data)
	{
		return new User($data);
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
	 * @param $email
	 * @return null|object
	 * @throws UserDoesNotExistException
	 */
	public function findByEmail($email)
	{
		$result = $this->em->getRepository($this->class)->findOneBy([
				'email'=>$email
		]);

		if (!$result)
		{
			throw new UserDoesNotExistException(401, ApiController::CODE_NOT_FOUND);
		}

		return $result;
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
	 * @param User $user
	 * @return array
	 */
	public function toArray(User $user)
	{
		return [
			'id' => $user->getId(),
			'name' => $user->getName(),
			'email' => $user->getEmail()
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