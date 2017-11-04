<?php
namespace App\Application\Services;

use App\Domain\User\Entities\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;

/**
 * Class PasswordService
 *
 * @package App\Application\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class PasswordService
{

	#region properties
	/**
	 * @var Hasher
	 */
	private $hasher;
	/**
	 * @var MyPasswordStrengthValidator
	 */
	private $passwordStrengthValidator;
	#endregion

	#region Constructor
	/**
	 * @param Hasher $hasher
	 * @param MyPasswordStrengthValidator $passwordStrength
	 */
	public function __construct(
		Hasher $hasher,
		MyPasswordStrengthValidator $passwordStrength
	) {
		$this->hasher = $hasher;
		$this->passwordStrengthValidator = $passwordStrength;
    }
	#endregion

	#region Methods
	/**
	 * Validate and change the given users password
	 *
	 * @param User $user
	 * @param string $password
	 * @throws PasswordTooWeakException
	 * @return void
	 */
	public function changePassword(User $user, $password)
	{
		if ($this->passwordStrengthValidator->isStrongEnough($password)) {
			$user->setPassword($this->hasher->make($password));
        } else {
			throw new PasswordTooWeakException();
		}
	}
	#endregion
}