<?php
namespace App\Domain\User\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
/**
 * Class UserDoesNotExistException
 *
 * @package App\Domain\User\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserDoesNotExistException extends JWTException
{

}