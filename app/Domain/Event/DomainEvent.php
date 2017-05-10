<?php
namespace App\Domain\Event;

/**
 * Interface DomainEvent
 *
 * @package App\Domain\Event
 * @author thanos theodorakopoulos galousis@gmail.com
 */
interface DomainEvent
{
	/**
	 * @return \DateTime
	 */
	public function occurredOn();
}