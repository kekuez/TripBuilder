<?php
// src/AppBundle/Form/TaskType.php
namespace AppBundle\Form;
use AppBundle\Form\AirportTransformer;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\CallbackTransformer;
use Doctrine\ORM\EntityManager;
class AirportChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $traitChoices = $options['trait_choices'];
        $manager = $options['entityManager'];
        foreach($traitChoices as $traitChoice){
            $choices[$traitChoice->getFlightName()]=$traitChoice->getId();
        }
        $builder
            ->add('tripName', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('departFrom', TextType::class, array(
                'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')
            ))
            /*
            ->add('departFrom',EntityType::class,array(
                'class' => 'AppBundle\Entity\airport',
                'placeholder' => 'Choose an option',
                'choice_label' => 'airportName',
                'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')
            ))
            */
            ->add('destination',EntityType::class,array(
                'class' => 'AppBundle\Entity\airport',
                'placeholder' => 'Choose an option',
                'choice_label' => 'airportName',
                'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')
            ))

            ->add('flightId', ChoiceType::class, array(
                'choices'  => $choices,
                'multiple'=>true,
                'expanded'=>true,
                'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px;')
            ))

            ->add('description', TextareaType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Submit Trip', 'attr'=>array('class'=>'btn btn-primary', 'style'=>'margin-bottom:15px')))
        ;

        $builder->get('departFrom')
            ->addModelTransformer(new AirportTransformer($manager));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\trip',
            'trait_choices' => null,
            'entityManager'=> null
        ));
    }
}