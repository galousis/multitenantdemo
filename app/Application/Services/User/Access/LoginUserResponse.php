<?php
namespace App\Application\Services\User\Access;

use App\Domain\User\Entities\User;

/**
 * Class LoginUserResponse
 *
 * @package App\Application\Services\User\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class LoginUserResponse
{

	#region properties
	/** @var User  */
	private $user;
	#endregion

	#region Constructor
	/**
	 * LoginUserResponse constructor.
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}
	#endregion

	#region Methods
	/**
	 * @return User
	 */
	public function user()
	{
		return $this->user;
	}
	#endregion

}