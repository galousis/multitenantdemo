<?php
namespace App\Domain\User\Services;

use App\Domain\User\Contracts\UserLoginServiceContract;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Application\Exceptions\JWTException; 			#Call a exception from Domain...
use Firebase\JWT\JWT;  									#Infrastructure dependency
use Illuminate\Support\Facades\Hash;

/**
 * Class UserLoginService
 *
 * @package App\Domain\User\Services
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserLoginService implements UserLoginServiceContract
{

	#region properties
	/**
	 * @var UserRepositoryContract
	 */
	public $repository;
	#endregion

	#region Constructor
	/**
	 * ManagerLoginService constructor.
	 * @param UserRepositoryContract $repository
	 */
	public function __construct(UserRepositoryContract $repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods
	/**
	 * @param $email
	 * @param $password
	 * @return array
	 * @throws JWTException
	 */
	public function execute($email, $password){

		//TODO fix bug when result is null
		$manager = $this->repository->findByEmail($email);

		$encrypted = $manager->getPassword();

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
					'userId'   => $manager->getId(), // userid from the users table
					'name' => $manager->getName(), // User name
					'email' => $manager->getEmail(), // User name
				]
			];

			$jwt = JWT::encode(
				$data,      //Data to be encoded in the JWT
				getenv('APP_KEY'), // The signing key
				getenv('APP_ENCRYPT_ALGORITHM')  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
			);

			return ['jwt'=>$jwt];

		} else {

			throw new JWTException('Unauthorized',401);
		}
	}
	#endregion
}