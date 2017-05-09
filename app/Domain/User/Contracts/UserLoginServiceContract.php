<?php
namespace App\Domain\User\Contracts;

/**
 * Interface UserRepositoryContract
 *
 * @package App\Domain\User\Contracts
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface UserLoginServiceContract{

	public function execute($email,$password);

}