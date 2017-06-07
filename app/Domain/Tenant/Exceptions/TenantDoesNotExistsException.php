<?php
namespace App\Domain\Tenant\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class TenantDoesNotExistsException
 *
 * @package App\Domain\Tenant\Exceptions
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantDoesNotExistsException extends JWTException
{

}