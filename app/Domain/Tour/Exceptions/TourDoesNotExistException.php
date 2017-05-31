<?php
namespace App\Domain\Tour\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class UserDoesNotExistException
 *
 * @package App\Domain\Tour\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourDoesNotExistException extends JWTException
{

}
