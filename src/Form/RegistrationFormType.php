<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
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
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [ 'label' => 'Mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Votre mot de passe', 'class' => 'my-1'],
                ],
                'second_options' => ['label' => 'Entrez à nouveau votre mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Confirmez votre mot de passe', 'class' => 'my-1'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
