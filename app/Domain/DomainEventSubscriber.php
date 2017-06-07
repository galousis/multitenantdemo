<?php
namespace App\Domain;

/**
 * Interface DomainEventSubscriber
 *
 * @package App\Domain
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface DomainEventSubscriber
{
	/**
	 * @param DomainEvent $aDomainEvent
	 */
	public function handle($aDomainEvent);

	/**
	 * @param DomainEvent $aDomainEvent
	 * @return bool
	 */
	public function isSubscribedTo($aDomainEvent);

}