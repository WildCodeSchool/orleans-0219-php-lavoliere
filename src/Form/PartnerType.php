<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-12 col-sm-12'],

            ])
            ->add('url', TextType::class, [
                'required' => false,
                'label' => 'Lien',
                'label_attr' => ['class' => 'col-12 col-sm-12'],
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image',
                'label_attr' => ['class' => 'col-12 col-sm-12 custom-file'],
                'allow_delete' => false,
                'download_link' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
