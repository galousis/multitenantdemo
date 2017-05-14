<?php
namespace App\Domain\User\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * Class UserDoesNotExistException
 *
 * @package App\Domain\User\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserDoesNotExistException extends NotFoundHttpException
{

}