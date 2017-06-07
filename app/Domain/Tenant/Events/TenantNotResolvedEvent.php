<?php
namespace App\Domain\Tenant\Events;

/**
 * Class TenantNotResolvedEvent
 * @package App\Domain\Tenant\Events
 */
class TenantNotResolvedEvent extends TenantEvent
{
    public $tenant = null;

    function __construct($tenant)
    {
        $this->tenant = $tenant;
    }
}