<?php

namespace MudlibBridgeBundle\Service;

use Doctrine\ORM\EntityManager;
use MudlibBridgeBundle\Entity\Event;
use stesie\mudlib\Event\DomainEvent;

class EventStore implements \stesie\mudlib\EventStore
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param DomainEvent[] $domainEvents
     */
    public function storeEvents(array $domainEvents)
    {
        foreach ($domainEvents as $domainEvent) {
            $eventClassPath = explode('\\', get_class($domainEvent));
            $eventName = end($eventClassPath);

            $event = new Event();
            $event
                ->setAggregateId($domainEvent->getAggregateId())
                ->setName($eventName)
                ->setExtraData(serialize($domainEvent))
            ;

            $this->entityManager->persist($event);
        }
    }
}
