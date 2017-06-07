<?php
namespace App\Domain;

use App\Domain\Event\PublishableDomainEvent;
use App\Application\EventStore;

/**
 * Class PersistDomainEventSubscriber
 *
 * @package App\Domain
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class PersistDomainEventSubscriber implements DomainEventSubscriber
{
	/**
	 * @var EventStore
	 */
	private $eventStore;

	public function __construct($anEventStore)
	{
		$this->eventStore = $anEventStore;
	}

	public function handle($aDomainEvent)
	{
		$this->eventStore->append($aDomainEvent);
	}

	public function isSubscribedTo($aDomainEvent)
	{
		return $aDomainEvent instanceof PublishableDomainEvent;
	}
}
