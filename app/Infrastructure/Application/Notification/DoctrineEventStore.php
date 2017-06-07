<?php
namespace App\Infrastructure\Notification;

use Doctrine\ORM\EntityRepository;
use App\Application\EventStore;
use App\Domain\Event\StoredEvent;
use JMS\Serializer\SerializerBuilder;

/**
 * Class DoctrineEventStore
 *
 * @package App\Infrastructure\Notification
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class DoctrineEventStore extends EntityRepository implements EventStore
{
	private $serializer;

	public function append($aDomainEvent)
	{
		$storedEvent = new StoredEvent(
			get_class($aDomainEvent),
			$aDomainEvent->occurredOn(),
			$this->serializer()->serialize($aDomainEvent, 'json')
		);

		$this->getEntityManager()->persist($storedEvent);
		$this->getEntityManager()->flush($storedEvent);
	}

	public function allStoredEventsSince($anEventId)
	{
		$query = $this->createQueryBuilder('e');
		if ($anEventId) {
			$query->where('e.eventId > :eventId');
			$query->setParameters(array('eventId' => $anEventId));
		}
		$query->orderBy('e.eventId');

		return $query->getQuery()->getResult();
	}

	/**
	 * @return \JMS\Serializer\Serializer
	 */
	private function serializer()
	{
		if (null === $this->serializer) {
			$this->serializer = SerializerBuilder::create()->build();
		}

		return $this->serializer;
	}
}
