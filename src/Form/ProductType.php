<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'attr' => ['class' => 'col-8'],
                'invalid_message' => 'Nom de produit obligatoire',
            ])

            ->add('bundle', TextType::class, [
                'label' => 'Lot :',
                'attr' => ['class' => 'col-8'],
                'invalid_message' => 'Lot obligatoire',
            ])

            ->add('price', TextType::class, [
                'label' => 'Prix :',
                'attr' => ['class' => 'col-8'],
                'invalid_message' => 'Lot obligatoire',
            ])

            ->add('origin', TextType::class, [
                'label' => 'Origine :',
                'required' => false,
                'attr' => ['class' => 'col-8'],
                'invalid_message' => 'Lot obligatoire',
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'attr' => ['class' => 'col-8', 'rows' => '4', 'cols' => '80'],
                'invalid_message' => 'Lot obligatoire',
            ])

            ->add('picture', FileType::class, [
                'label' => 'Image :',
                'attr' => ['class' => 'col-md-4'],
                'invalid_message' => 'Veuillez importer une image',
            ])

            ->add('isShowcased', CheckboxType::class, [
                'label' => 'Top du moment',
                'required' => false,
            ])

            ->add('isAvailable', CheckBoxType::class, [
                'label' => 'En ligne',
                'required' => false,
                'attr' => ['checked' => 'checked']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
