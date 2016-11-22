<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * trip
 *
 * @ORM\Table(name="trip")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\tripRepository")
 */
class trip
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
     * @ORM\Column(name="tripName", type="string", length=255)
     */
    private $tripName;

    /**
     * @var string
     *
     * @ORM\Column(name="DepartFrom", type="string", length=255)
     */
    private $departFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="Destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;


    /**
     * @var string
     *
     * @ORM\Column(name="flightId", type="string", length=255)
     */
     private $flightId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tripName
     *
     * @param string $tripName
     *
     * @return trip
     */
    public function setTripName($tripName)
    {
        $this->tripName = $tripName;

        return $this;
    }

    /**
     * Get tripName
     *
     * @return string
     */
    public function getTripName()
    {
        return $this->tripName;
    }

    /**
     * Set departFrom
     *
     * @param string $departFrom
     *
     * @return string
     */
    public function setDepartFrom($departFrom)
    {
        $this->departFrom = $departFrom;

        return $this;
    }

    /**
     * Get departFrom
     *
     * @return string
     */
    public function getDepartFrom()
    {
        return $this->departFrom;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return trip
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return trip
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return trip
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set flightId
     *
     * @param string $flightId
     *
     * @return trip
     */
    public function setFlightId($flightId)
    {
        $this->flightId = $flightId;

        return $this;
    }

    /**
     * Get flightId
     *
     * @return string
     */
    public function getFlightId()
    {
        return $this->flightId;
    }
}

