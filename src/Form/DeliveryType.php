<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Location::class,
                'required' => true,
                'constraints' => new NotBlank(),
                'label' => 'Point de collecte :',
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'placeholder' => 'Choisir ...',
                'choice_label' => function ($location) {
                    $name = $location->getName();
                    $city = $location->getCity();
                    $locationType = $location->getLocationType();
                    $area = "$name | $city.";
                    if ($locationType == true) {
                        $area .= ' ( Réservé aux employés )';
                    }
                    return $area;
                }
            ])
            ->add('deliveryDate', DateType::class, [
                'label' => 'Date de collecte :',
                'placeholder' => 'Choisir ...',
                'attr' => ['class' => 'text-left'],
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'constraints' => new NotBlank(),
                'widget' => 'single_text',
            ])
            ->add('comments', TextareaType::class, [
                'required' => false,
                'constraints' => new Length(['max' => 255]),
                'label' => 'Commentaire :',
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'invalid_message' => 'Veuillez remplir ce champ',
                'attr' => ['rows' => '2', 'cols' => '80', 'placeholder' => 'Bonjour,'],
            ]);
    }

}
