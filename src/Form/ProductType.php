<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'invalid_message' => 'Nom de produit obligatoire',
            ])
            ->add('bundle', TextType::class, [
                'label' => 'Lot :',
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'invalid_message' => 'Lot obligatoire',
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix :',
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'invalid_message' => 'Prix obligatoire',
            ])
            ->add('origin', TextType::class, [
                'label' => 'Origine :',
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'attr' => ['rows' => '4', 'cols' => '80'],
                'invalid_message' => 'Description obligatoire',
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image :',
                'label_attr' => ['class' => 'col-sm-3 pl-0 custom-file'],
                'attr' => ['lang' => 'fr'],
                'invalid_message' => 'Veuillez importer une image',
            ])
            ->add('category', null, [
                'choice_label' => 'name',
                'label_attr' => ['class' => 'col-sm-3 pl-0'],
                'label' => 'Catégorie :',

                'invalid_message' => 'Veuillez choisir une catégorie',
            ])
            ->add('isShowcased', CheckboxType::class, [
                'label' => 'Top du moment',
                'required' => false,
                'attr' => ['class' => 'admin-checkbox']
            ])
            ->add('isAvailable', CheckBoxType::class, [
                'label' => 'En ligne',
                'required' => false,
                'attr' => ['checked' => 'checked', 'class' => 'admin-checkbox']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
