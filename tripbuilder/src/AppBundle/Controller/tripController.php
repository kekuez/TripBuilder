<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\trip;
use AppBundle\Form\AirportChoiceType;
use AppBundle\Form\EditAirportChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class tripController extends Controller
{
    /**
     * @Route("/", name="trip_list")
     */
    public function listAction()
    {
        $trips = $this->getDoctrine()
            ->getRepository('AppBundle:trip')
            ->findAll();
        // replace this example code with whatever you need
        return $this->render('trip/index.html.twig', array('trips'=>$trips));
    }
    /**
     * @Route("/trip/create", name="trip_create")
     */
    public function createAction(Request $request)
    {
        $trip = new trip;
        $traitChoices = $this->getDoctrine()
            ->getRepository('AppBundle:flight')
            ->findAll();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(AirportChoiceType::class, $trip, array(
            'trait_choices' => $traitChoices,
            'entityManager' => $entityManager
        ));
        /*
        $form = $this->createForm(AirportChoiceType::class, $trip, array(
            'trait_choices' => $traitChoices,

        ));
        */

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           //Get Data
            $tripName = $form['tripName']->getData();
            $departFrom = $form['departFrom']->getData();
            $destination = $form['destination']->getData();
            $description = $form['description']->getData();
            $flightId = $form['flightId']->getData();
            //convert array to string
            $flightText = "";
            $i = 0;
            foreach($flightId as $id){
                if($i>0){
                    $flightText .= ", ";
                }
                $flightText .= $id;
                $i++;
            }

            $now = new\DateTime('now');
            $trip->setTripName($tripName);
            $trip->setDepartFrom($departFrom);
            $trip->setDestination($destination);
            $trip->setDescription($description);
            $trip->setFlightId($flightText);
            $trip->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($trip);
            $em->flush();
            $this->addFlash(
                'notice',
                'Trip Added'
            );

            return $this->redirectToRoute('trip_list');
        }

        // replace this example code with whatever you need
        return $this->render('trip/create.html.twig',
            array('form'=>$form->createView()
            ));
    }
    /**
     * @Route("/trip/edit/{id}", name="trip_edit")
     */
    public function editAction($id, Request $request)
    {
        $trip = $this->getDoctrine()
            ->getRepository('AppBundle:trip')
            ->find($id);
        $trip->setTripName($trip->getTripName());
        $trip->setDepartFrom($trip->getDepartFrom());
        $trip->setDestination($trip->getDestination());
        $trip->setDescription($trip->getDescription());
        $flightArray = explode(", ",$trip->getFlightId());
        $trip->setFlightId($flightArray);
        $trip->setCreateDate($trip->getCreateDate());

        $traitChoices = $this->getDoctrine()
            ->getRepository('AppBundle:flight')
            ->findAll();
        foreach($traitChoices as $traitChoice){
            $choices[$traitChoice->getFlightName()]=$traitChoice->getId();
        }
        $form = $this->createFormBuilder($trip)
            ->add('flightId', ChoiceType::class, array(
                'choices'  => $choices,
                'multiple'=>true,
                'expanded'=>true,
                'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px;')
            ))
            ->add('save', SubmitType::class, array('label'=> 'Submit Trip', 'attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Get Data
            $flightId = $form['flightId']->getData();
            //convert array to string
            $flightText = "";
            $i = 0;
            foreach($flightId as $fid){
                if($i>0){
                    $flightText .= ", ";
                }
                $flightText .= $fid;
                $i++;
            }

            $em = $this->getDoctrine()->getManager();
            $trip = $em->getRepository('AppBundle:trip')->find($id);

            $now = new\DateTime('now');
            $trip->setFlightId($flightText);
            $trip->setCreateDate($now);

            $em->flush();
            $this->addFlash(
                'notice',
                'Trip Updated'
            );

           return $this->redirectToRoute('trip_list');
        }
        // replace this example code with whatever you need
        return $this->render('trip/edit.html.twig', array(
            'trip'=>$trip,
            'form'=>$form->createView()
        ));
    }
    /**
     * @Route("/trip/details/{id}", name="trip_detail")
     */
    public function detailsAction($id)
    {
        $trip = $this->getDoctrine()
            ->getRepository('AppBundle:trip')
            ->find($id);

        if(!$trip){
            throw $this->createNotFoundException(
                'No trip found for id '.$id
            );
        }
            return $this->render('trip/details.html.twig', array('trip'=>$trip));
        // replace this example code with whatever you need

    }
    /**
     * @Route("/trip/delete/{id}", name="trip_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('AppBundle:trip')->find($id);
        $em->remove($trip);
        $em->flush();
        $this->addFlash(
            'notice',
            'Trip Deleted'
        );
        return $this->redirectToRoute('trip_list');
    }
    /**
     * @Route("/trip/number", name="trip_number")
     */
    public function numberAction()
    {
        $number = mt_rand(0,100);
        $test = array(1,2,3);
        // replace this example code with whatever you need
        return $this->render('trip/number.html.twig', array('number'=>$number,'test'=>$test));
    }

    /**
     * @Route("/trip", name="airport_trip")
     */
    public function tripAction(Request $request)
    {
        $names = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:airport')->createQueryBuilder('c')
            ->where('c.airportName LIKE :name')
            ->setParameter('name', '%'.$term.'%')
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity)
        {
            //$names[] = $entity->getAirportName()."({$entity->getLocation()})";
            $names[] = $entity->getAirportName();
        }

        $response = new JsonResponse();
        $response->setData($names);

        return $response;
    }

}
