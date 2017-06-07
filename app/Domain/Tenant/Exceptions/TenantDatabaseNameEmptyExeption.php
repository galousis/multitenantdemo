<?php
namespace App\Domain\Tenant\Exceptions;

class TenantDatabaseNameEmptyException extends \Exception
{
    public function getTenant()
    {
        return $this->getMessage();
    }
}