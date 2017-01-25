<?php

namespace MudlibBridgeBundle\Service;

use Doctrine\ORM\EntityManager;
use MudlibBridgeBundle\Entity\Event;
use stesie\mudlib\Event\DomainEventInterface;
use stesie\mudlib\EventBusInterface;

class EventStore implements \stesie\mudlib\EventStoreInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EventBusInterface
     */
    private $eventBus;

    public function __construct(EntityManager $entityManager, EventBusInterface $eventBus)
    {
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
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
            $this->eventBus->publish($domainEvent);
        }
    }
}
