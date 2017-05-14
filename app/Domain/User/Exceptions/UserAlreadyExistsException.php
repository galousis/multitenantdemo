<?php
namespace App\Domain\User\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class UserAlreadyExistsException
 *
 * @package App\Domain\User\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserAlreadyExistsException extends HttpException
{

}