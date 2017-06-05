<?php
namespace App\Domain\Tenant\Contracts;

use App\Domain\Tenant\Entities\Tenant;

/**
 * Interface TenantRepositoryContract
 *
 * @package App\Domain\Tenant\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface TenantRepositoryContract
{

	/**
	 * @param Tenant $tenant
	 * @return mixed
	 */
	public function create(Tenant $tenant);

	/**
	 * @param Tenant $tenant
	 * @param $data
	 * @return mixed
	 */
	public function update(Tenant $tenant, $data);

	/**
	 * @param Tenant $tenant
	 * @return mixed
	 */
	public function delete(Tenant $tenant);

	/**
	 * @param $data
	 * @return mixed
	 */
	public function load($data);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function findById($id);

	/**
	 * @param $subDomain
	 * @return mixed
	 */
	public function findBySubDomain($subDomain);

	/**
	 * @return mixed
	 */
	public function findAll();


}