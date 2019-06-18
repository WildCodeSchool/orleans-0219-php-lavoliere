<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'Ancien mot de passe',
                'label_attr' => ['class' => 'col-md-12'],
                'invalid_message' => 'Veuillez votre ancien mot de passe',
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Votre mot de passe', 'class' => 'my-1'],
                ],
                'second_options' => ['label' => 'Confirmez votre mot de passe',
                    'label_attr' => ['class' => 'col-md-12'],
                    'attr' => ['placeholder' => 'Confirmez votre mot de passe', 'class' => 'my-1'],
                ],
                'invalid_message' => 'Les mots de passe ne sont pas identiques.',
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
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
