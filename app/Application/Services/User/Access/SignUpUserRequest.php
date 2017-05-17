<?php
namespace App\Application\Services\User\Access;

/**
 * Class SignUpUserRequest
 *
 * @package App\Application\Services\User\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class SignUpUserRequest
{

	#region properties
	private $name;
	private $email;
	private $password;
	#endregion

	#region Constructor
	/**
	 * SignUpUserRequest constructor.
	 * @param $name
	 * @param null $email
	 * @param null $password
	 */
	public function __construct($name = null, $email = null, $password = null)
	{
		$this->name 	= $name;
		$this->email 	= $email;
		$this->password = $password;
	}
	#endregion

	#region setter, getters Methods
	/**
	 * @return mixed
	 */
	public function email()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function name()
	{
		return $this->name();
	}

	/**
	 * @return mixed
	 */
	public function password()
	{
		return $this->password;
	}

	/**
	 * @param $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}
	#endregion

}