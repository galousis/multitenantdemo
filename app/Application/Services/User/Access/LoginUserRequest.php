<?php
namespace App\Application\Services\User\Access;

/**
 * Class LoginUserRequest
 *
 * @package App\Application\Services\User\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class LoginUserRequest
{
	#region properties
	private $username;
	private $password;
	#endregion

	#region Contructor
	/**
	 * LoginUserRequest constructor.
	 * @param $username
	 * @param $password
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}
	#endregion

	#region Methods
	/**
	 * @return mixed
	 */
	public function username()
	{
		return $this->username;
	}

	/**
	 * @return mixed
	 */
	public function password()
	{
		return $this->password;
	}
	#endregion

}