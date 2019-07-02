<?php

namespace App\Form;

use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Product', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('seasonStartAt', DateType::class, [
                'required' => true,
                'label' => 'Début de saison :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',

            ])
            ->add('seasonEndAt', DateType::class, [
                'required' => true,
                'label' => 'Fin de saison :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',

            ])
            ->add('pickingStartAt', DateType::class, [
                'required' => true,
                'label' => 'Début de cueillette :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',

            ])
            ->add('pickingEndAt', DateType::class, [
                'required' => true,
                'label' => 'Fin de cueillette :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',

            ])
            ->add('outOfStock', CheckboxType::class, [
                'label' => 'En rupture',
                'required' => false,
                'attr' => ['class' => 'admin-checkbox']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
