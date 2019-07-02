<?php

namespace App\Form;

use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', TextType::class, [
                'required' => true,
                'label' => 'Nom du produit :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('seasonStartAt', null, [
                'required' => true,
                'label' => 'Début de saison :',
                'choice_label' => 'month',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('seasonEndAt', null, [
                'required' => true,
                'label' => 'Fin de saison :',
                'choice_label' => 'month',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('pickingStartAt', null, [
                'required' => true,
                'label' => 'Début de cueillette :',
                'choice_label' => 'month',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('pickingEndAt', null, [
                'required' => true,
                'label' => 'Fin de cueillette :',
                'choice_label' => 'month',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('outOfStock', CheckboxType::class, [
                'label' => 'Indisponible',
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
