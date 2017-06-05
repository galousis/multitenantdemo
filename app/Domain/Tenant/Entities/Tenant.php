<?php
namespace App\Domain\Tenant\Entities;

use App\Domain\Tenant\TenantId;

/**
 * Class Tenant
 *
 * @package App\Domain\Tenant\Entities
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class Tenant
{

	#region properties
	/** @var TenantId */
	public $id;

	/**
	 * @var string
	 */
	private $subDomain;

	/**
	 * @var string
	 */
	private $tenantDatabase;
	#endregion

	#region constructor
	/**
	 * Tenant constructor.
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id 				= isset($data['id']) ? $data['id'] : null;
		$this->subDomain 		= isset($data['sub_domain']) ? $data['sub_domain'] : null;
		$this->tenantDatabase 	= isset($data['tenant_database']) ? $data['tenant_database'] : null;
	}
	#endregion

	#region Setters
	/**
	 * @param TenantId $id
	 */
	public function setId(TenantId $id)
	{
		$this->id = $id;
	}

	/**
	 * @param string $subDomain
	 */
	public function setSubDomain($subDomain)
	{
		$this->subDomain = $subDomain;
	}
	/**
	 * @param string $db
	 */
	public function setTenantDatabase($db)
	{
		$this->tenantDatabase = $db;
	}
	#endregion

	#region Getters
	/**
	 * @return TenantId|null
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return null|string
	 */
	public function getSubDomain()
	{
		return $this->subDomain;
	}

	/**
	 * @return null|string
	 */
	public function getTenantDatabase()
	{
		return $this->tenantDatabase;
	}
	#endregion


}