<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Votre nom',
                'invalid_message' => 'Veuillez remplir ce champ',
                'attr' => ['placeholder' => 'George Abitbol'],
                'label_attr' => ['class' => 'contact-form col-md-8 col-sm-12 px-1 m-top-3 m-bottom-1'],
            ])

            ->add('mail', EmailType::class, [
                'required' => true,
                'label' => 'Votre mail',
                'invalid_message' => 'Veuillez donnez votre adresse mail',
                'attr' => ['placeholder' => 'george.abitbol@chips.com'],
                'label_attr' => ['class' => 'contact-form col-md-8 col-sm-12 px-1 mt-3'],
            ])

            ->add('phone', TextType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'attr' => ['placeholder' => '06123456789',],
                'label_attr' => ['class' => 'contact-form col-md-8 col-sm-12 px-1 mt-3'],
                'invalid_message' => 'Veuillez entrer un numéro de téléphone valide',

            ])

            ->add('object', TextType::class, [
                'required' => false,
                'label' => 'Objet de votre message',
                'attr' => ['placeholder' => 'Renseignements'],
                'label_attr' => ['class' => 'contact-form col-md-8 col-sm-12 px-1 mt-3'],
            ])

            ->add('message', TextareaType::class, [
                'required' => true,
                'label' => 'Votre message',
                'invalid_message' => 'Veuillez remplir ce champ',
                'attr' => ['rows' => '8', 'cols' => '80', 'placeholder' => 'Bonjour,'],
                'label_attr' => ['class' => 'contact-form col-md-8 col-sm-12 px-1 mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
