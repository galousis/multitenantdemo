<?php
namespace App\Application\Services\DataTransformer\User;

use App\Domain\User\Entities\User;

/**
 * Class UserTransformer
 *
 * @package App\Application\Services\DataTransformer\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserTransformer implements UserDataTransformer
{

	#region properties
	/** @var  User */
	private $user;
	#endregion

	#region Methods
	/**
	 * @param User $user
	 * @return $this
	 */
	public function write(User $user)
	{
		$this->user = $user;
		return $this;
	}

	/**
	 * @return array
	 */
	public function read()
	{
		return [
			'id' => $this->user->getId(),
			'num_documents' => 0,
		];
	}
	#endregion

}