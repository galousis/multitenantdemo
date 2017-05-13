<?php
namespace App\Domain\User;

use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\Event\DomainEvent;
use App\Domain\User\Entities\User;
use App\Application\Exceptions\JWTException; 			#Call a exception from Domain...
use Firebase\JWT\JWT;  									#Infrastructure dependency
use Illuminate\Support\Facades\Hash;

class Authentifier
{
	#region properties
	/**
	 * @var UserRepositoryContract
	 */
	private $repository;
	#endregion

	#region Constructor
	/**
	 * Authentifier constructor.
	 *
	 * @param UserRepositoryContract $repository
	 */
	public function __construct(UserRepositoryContract$repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods
	public function authenticate($email, $password)
	{

		//TODO fix bug when result is null
		$user = $this->repository->findByEmail($email);

		if (!$user) {
			return false;
		}

		$encrypted = $user->getPassword();

		if (Hash::check($password, $encrypted)) {

			//$tokenId    = base64_encode(mcrypt_create_iv(32));
			$issuedAt   = time();
			$notBefore  = $issuedAt + 10;  //Adding 10 seconds
			$expire     = $notBefore + 60; // Adding 60 seconds
			$serverName = getenv('APP_SERVER_NAME');

			/*
			 * Create the token as an array
			 */
			$data = [
				'iat'  => $issuedAt,         // Issued at: time when the token was generated
				//'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
				'iss'  => $serverName,       // Issuer
				'nbf'  => $notBefore,        // Not before
				'exp'  => $expire,           // Expire
				'data' => [                  // Data related to the signer user
					'userId'   => $user->getId(), // userid from the users table
					'name' => $user->getName(), // User name
					'email' => $user->getEmail(), // User name
				]
			];

			$jwt = JWT::encode(
				$data,      //Data to be encoded in the JWT
				getenv('APP_KEY'), // The signing key
				getenv('APP_ENCRYPT_ALGORITHM')  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
			);

			//$this->persistAuthentication($user);

			return ['jwt'=>$jwt];

		} else {

			throw new JWTException('Unauthorized',401);
		}

	}

//	abstract public function logout();
//	abstract protected function persistAuthentication(User $user);
//	abstract protected function isAlreadyAuthenticated();
	#endregion

}