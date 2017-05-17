<?php
namespace App\Domain\User\Entities;

use Carbon\Carbon;
use App\Domain\User\ValueObjects\UserId;

/**
 * Class User
 *
 * @package App\Domain\User\Entities
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class User
{
	#region properties
	/** @var UserId */
	public $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $rememberToken;

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
	 * Manager constructor.
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id = isset($data['id']) ? $data['id'] : null;
		$this->setEmail($data['email']);
		$this->setName($data['name']);
		$this->setPassword($data['password']);
		$this->setRememberToken();
		$this->setCreatedAt();
		$this->setUpdatedAt();
	}
	#endregion

	#region Setters
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = password_hash($password,PASSWORD_DEFAULT);
	}
	#endregion

	#region Getters
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
		//return $this->createdAt->format('Y-m-d H:i:s');
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	public function setCreatedAt()
	{
		$this->createdAt = new \DateTime();
	}

	public function setUpdatedAt()
	{
		$this->updatedAt = new \DateTime();
	}

	public function setRememberToken()
	{
		$this->rememberToken = '';
	}

	public function getRememberToken()
	{
		return $this->rememberToken;
	}
	#endregion

}

