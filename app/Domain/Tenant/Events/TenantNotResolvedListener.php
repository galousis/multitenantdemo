<?php
namespace App\Domain\Tenant\Events;

use Illuminate\Foundation\Application;
use App\Domain\Tenant\Exceptions\TenantNotResolvedException;

/**
 * Class TenantNotResolvedListener
 * @package App\Domain\Tenant\Events
 */
class TenantNotResolvedListener
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(TenantNotResolvedEvent $event)
    {
        if ( ! $this->app->runningInConsole())
        {
            throw new TenantNotResolvedException($event->tenant);
        }
    }
}