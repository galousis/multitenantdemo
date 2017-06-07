<?php
namespace App\Infrastructure\Doctrine\Repositories;

use App\Domain\Tenant\Entities\Tenant;
use App\Domain\Tenant\Contracts\TenantRepositoryContract;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;


/**
 * Class TenantRepository
 *
 * @package App\Infrastructure\Doctrine\Repositories
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantRepository implements TenantRepositoryContract
{

	/**
	 * @var string
	 */
	private $class = Tenant::class;

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
	 * @param Tenant $tenant
	 * @return void
	 */
	public function create(Tenant $tenant)
	{
		$this->_em->persist($tenant);
		$this->_em->flush();
	}

	/**
	 * @param Tenant $tenant
	 * @param $data
	 * @return void
	 */
	public function update(Tenant $tenant, $data)
	{
		$tenant->setSubDomain($data['sub_domain']);
		$tenant->setTenantDatabase($data['database']);
		$this->_em->persist($tenant);
		$this->_em->flush();
	}

	/**
	 * @param Tenant $tenant
	 * @return void
	 */
	public function delete(Tenant $tenant)
	{
		$this->_em->remove($tenant);
		$this->_em->flush();
	}

	/**
	 * @param $data
	 * @return Tenant
	 */
	public function load($data)
	{
		return new Tenant($data);
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
	 * @param $subDomain
	 * @return null|object
	 */
	public function findBySubDomain($subDomain)
	{
		//TODO !attantion : we need to cache this particular query, since we load TenantResolveService from within service Tenant service provider and it executes in any request

		return $this->_em->getRepository($this->class)->findOneBy([
			'subDomain' => $subDomain
		]);
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		return $this->_em->getRepository($this->class)->findAll();
	}
}