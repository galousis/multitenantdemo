<?php
namespace App\Domain\User\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class UserAlreadyExistsException
 *
 * @package App\Domain\User\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserAlreadyExistsException extends JWTException
{

}