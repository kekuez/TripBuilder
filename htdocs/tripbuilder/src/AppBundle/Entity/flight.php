<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * flight
 *
 * @ORM\Table(name="flight")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\flightRepository")
 */
class flight
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
     * @ORM\Column(name="flightName", type="string", length=255)
     */
    private $flightName;

    /**
     * @var string
     *
     * @ORM\Column(name="operator", type="string", length=255)
     */
    private $operator;


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
     * Set flightName
     *
     * @param string $flightName
     *
     * @return flight
     */
    public function setFlightName($flightName)
    {
        $this->flightName = $flightName;

        return $this;
    }

    /**
     * Get flightName
     *
     * @return string
     */
    public function getFlightName()
    {
        return $this->flightName;
    }

    /**
     * Set operator
     *
     * @param string $operator
     *
     * @return flight
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
    public function __toString() {
        return $this->flightName;
    }
}

