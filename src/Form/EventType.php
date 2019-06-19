<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre',
                'label_attr' => ['class' => 'col-md-12'],

            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'label_attr' => ['class' => 'col-md-12'],
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image',
                'label_attr' => ['class' => 'col-md-12'],
                'allow_delete' => false,
                'download_link' => false,
            ])
            ->add('startAt', DateType::class, [
                'required' => false,
                'label' => 'Début',
                'label_attr' => ['class' => 'col-md-12'],
            ])
            ->add('endAt', DateType::class, [
                'required' => false,
                'label' => 'Fin',
                'label_attr' => ['class' => 'col-md-12'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
