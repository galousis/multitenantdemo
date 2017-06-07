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
	 * @var
	 */
	private $aliasDomain;

	/**
	 * @var
	 */
	private $connection;

	/**
	 * @var
	 */
	private $meta;

	/**
	 * @var string
	 */
	private $database;

	/**
	 * @var \DateTime
	 */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/**
	 * @var \DateTime
	 */
	private $updatedAt = 'CURRENT_TIMESTAMP';

	#endregion

	#region constructor
	/**
	 * Tenant constructor.
	 * @param $data
	 */
	public function __construct($data = null)
	{
		$this->setConnection(config('app.database.default'));

		if (count($data)>0)
		{
			$this->id 				= isset($data['id']) ? $data['id'] : null;
			$this->subDomain 		= isset($data['sub_domain']) ? $data['sub_domain'] : null;
			$this->aliasDomain 		= isset($data['alias_domain']) ? $data['alias_domain'] : null;
			$this->meta 			= isset($data['meta']) ? $data['meta'] : null;
			$this->database 	= isset($data['tenant_database']) ? $data['tenant_database'] : null;

		}
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
	 * @param string $aliasDomain
	 */
	public function setAliasDomain($aliasDomain)
	{
		$this->aliasDomain = $aliasDomain;
	}

	/**
	 * @param string $connection
	 */
	public function setConnection($connection)
	{
		$this->connection = $connection;
	}

	/**
	 * @param string $meta
	 */
	public function setMeta($meta)
	{
		$this->meta = $meta;
	}

	/**
	 * @param string $db
	 */
	public function setTenantDatabase($db)
	{
		$this->database = $db;
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
	public function getAliasDomain()
	{
		return $this->aliasDomain;
	}

	/**
	 * @return null|string
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * @return null|string
	 */
	public function getMeta()
	{
		return $this->meta;
	}

	/**
	 * @return null|string
	 */
	public function getTenantDatabase()
	{
		return $this->database;
	}
	#endregion


}