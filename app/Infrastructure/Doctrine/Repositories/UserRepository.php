<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\User\Entities\User;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\Exceptions\UserDoesNotExistException;
use Doctrine\ORM\EntityManager;
use App\Domain\User\Contracts\UserRepositoryContract;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;
use App\Interfaces\Api\Http\Controllers\ApiController;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

/**
 * Class UserRepository
 *
 * @package App\Infrastructure\Doctrine\Mappings\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserRepository implements UserRepositoryContract
{
	use PaginatesFromRequest;

	/**
	 * @var string
	 */
	private $class = User::class;

	/**
	 * @var EntityManager
	 */
	private $_em;

	/**
	 * UserRepository constructor.
	 * @param EntityManager $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->_em = $em;
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function create(User $user)
	{
		$this->_em->persist($user);
		$this->_em->flush();
	}

	/**
	 * @param User $user
	 * @param $data
	 * @return void
	 */
	public function update(User $user, $data)
	{
		$user->setName($data['name']);
		$user->setEmail($data['email']);
		$user->setPassword($data['password']);
		$this->_em->persist($user);
		$this->_em->flush();
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function delete(User $user)
	{
		$this->_em->remove($user);
		$this->_em->flush();
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
	 * @param UserId $id
	 * @return null|object
	 */
	public function findById(UserId $id)
	{
		return $this->_em->getRepository($this->class)->findOneBy([
			'id' => $id->id()
		]);
	}

	/**
	 * @param $email
	 * @return null|object
	 */
	public function findByEmail($email)
	{
		$result = $this->_em->getRepository($this->class)->findOneBy([
				'email'=>$email
		]);

		return $result;
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		$tasks = $this->_em->getRepository($this->class)->findAll();
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
			->from(User::class, $alias, $indexBy);
	}

}