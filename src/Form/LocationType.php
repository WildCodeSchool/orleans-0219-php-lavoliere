<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'invalid_message' => 'Veuillez saisir un nom de point de collecte'
            ])
            ->add('adress', TextType::class, [
                'invalid_message' => 'Veuillez saisir l\'adresse du point de collecte'
            ])
            ->add('postal_code', TextType::class, [
                'invalid_message' => 'Veuillez saisir le code postal du point de collecte'
            ])
            ->add('city', TextType::class, [
                'invalid_message' => 'Veuillez choisir la ville du point de collecte'
            ])
            ->add('delivery_date', TextType::class, [
                'invalid_message' => 'Veuillez choisir un jour de livraison'
            ])
            ->add('isPrivate', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
