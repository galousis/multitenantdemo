<?php
namespace App\Application\Services\DataTransformer\User;

use App\Domain\User\Entities\User;

/**
 * Interface UserDataTransformer
 *
 * @package App\Application\Services\DataTransformer\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface UserDataTransformer
{

	public function read();

	public function write(User $user);

}