<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('bundle', TextType::class, [
                'required' => true,
                'label' => 'Lot :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => 'Prix :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'invalid_message' => 'Prix non valide',

            ])
            ->add('origin', TextType::class, [
                'required' => true,
                'label' => 'Origine :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description :',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'attr' => ['rows' => '4', 'cols' => '80'],
            ])
            ->add('pictureFile', VichImageType::class, [
                'required' => false,
                'label' => 'Image :',
                'label_attr' => ['class' => 'col-sm-12 pl-0 custom-file'],
                'attr' => ['lang' => 'fr'],
                'allow_delete' => false,
                'download_link' => false,
            ])
            ->add('category', null, [
                'required' => true,
                'choice_label' => 'name',
                'placeholder' => 'Choisir ...',
                'label_attr' => ['class' => 'col-sm-12 pl-0'],
                'label' => 'Catégorie :',
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
