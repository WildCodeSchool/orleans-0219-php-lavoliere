<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'Abitbol'],
                'invalid_message' => 'Veuillez saisir votre nom',
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'Georges'],
                'invalid_message' => 'Veuillez saisir votre prénom',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => 'georges.abitbol@chips.com'],
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-md-12'],
                'attr' => ['placeholder' => '06123456789'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
