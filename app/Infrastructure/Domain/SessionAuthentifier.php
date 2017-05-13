<?php
namespace App\Infrastructure\Domain;

use App\Domain\User\Authentifier;
use App\Domain\User\Entities\User;
use Illuminate\Support\Facades\Session;

/**
 * Class SessionAuthentifier
 *
 * @package App\Infrastructure\Domain
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class SessionAuthentifier extends Authentifier
{
	/**
	 * @var Session
	 */
	private $session;

	public function __construct($repository, $session)
	{
		parent::__construct($repository);
		$this->session = $session;
	}

	protected function persistAuthentication(User $user)
	{
		$this->session->set('user', 'TODO');
	}

	protected function isAlreadyAuthenticated()
	{
		return $this->session->has('user');
	}

	public function logout()
	{
		return $this->session->clear();
	}
}