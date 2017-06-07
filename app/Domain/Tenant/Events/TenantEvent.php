<?php
namespace App\Domain\Tenant\Events;

use Illuminate\Queue\SerializesModels;
use App\Domain\Tenant\Entities\Tenant;

/**
 * Class TenantEvent
 * @package App\Domain\Tenant\Events
 */
class TenantEvent
{
    use SerializesModels;

    public $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

}