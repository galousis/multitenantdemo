<?php
namespace App\Domain\Tenant\Exceptions;

class TenantNotResolvedException extends \Exception
{
    public function getTenant()
    {
        return $this->getMessage();
    }
}