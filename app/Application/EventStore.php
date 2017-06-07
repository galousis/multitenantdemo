<?php
namespace App\Application;

use App\Domain\Event\DomainEvent;

/**
 * Interface EventStore
 *
 * @package App\Application
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface EventStore
{
	/**
	 * @param DomainEvent $aDomainEvent
	 * @return mixed
	 */
	public function append($aDomainEvent);

	/**
	 * @param $anEventId
	 * @return DomainEvent[]
	 */
	public function allStoredEventsSince($anEventId);
}