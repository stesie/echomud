<?php

namespace MudlibBridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="MudlibBridgeBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="aggregate_root_id", type="string", length=50)
     */
    private $aggregateRootId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="extra_data", type="blob")
     */
    private $extraData;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set aggregateRootId
     *
     * @param string $aggregateRootId
     *
     * @return Event
     */
    public function setAggregateRootId($aggregateRootId)
    {
        $this->aggregateRootId = $aggregateRootId;

        return $this;
    }

    /**
     * Get aggregateRootId
     *
     * @return string
     */
    public function getAggregateRootId()
    {
        return $this->aggregateRootId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set extraData
     *
     * @param string $extraData
     *
     * @return Event
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;

        return $this;
    }

    /**
     * Get extraData
     *
     * @return string
     */
    public function getExtraData()
    {
        return $this->extraData;
    }
}
