<?php
namespace AppBundle\Form;

use AppBundle\Entity\airport;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class AirportTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    public function transform($airport)
    {
        if (null === $airport) {
            return '';
        }

        return $airport->getId();
    }
    public function reverseTransform($airportName)
    {
        if (!$airportName) {
            return;
        }

        $departFrom = $this->manager
            ->getRepository('AppBundle:airport')->findOneBy(array('airportName' => $airportName));

        if (null === $departFrom) {
            throw new TransformationFailedException(sprintf('There is no "%s" exists',
                $airportName
            ));
        }

        return $departFrom;
    }
}