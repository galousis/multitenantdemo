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
	private $email;
	private $password;
	#endregion

	#region Constructor
	public function __construct($email = null, $password = null)
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