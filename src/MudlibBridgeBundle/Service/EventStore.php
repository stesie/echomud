<?php

namespace MudlibBridgeBundle\Service;

use Doctrine\ORM\EntityManager;
use MudlibBridgeBundle\Entity\Event;
use stesie\mudlib\Event\DomainEventInterface;

class EventStore implements \stesie\mudlib\EventStoreInterface
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
     * @param DomainEventInterface[] $domainEvents
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
