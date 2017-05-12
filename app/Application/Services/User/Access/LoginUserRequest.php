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
	private $email;
	private $password;
	#endregion

	#region Contructor
	/**
	 * LoginUserRequest constructor.
	 * @param $email
	 * @param $password
	 */
	public function __construct($email, $password)
	{
		$this->email = $email;
		$this->password = $password;
	}
	#endregion

	#region Methods
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
	public function password()
	{
		return $this->password;
	}
	#endregion

}