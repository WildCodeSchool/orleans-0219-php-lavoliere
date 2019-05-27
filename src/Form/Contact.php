<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class Contact extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'constraints' => [new NotBlank(),],
                'invalid_message' => 'Veuillez remplir ce champ'
            ])

            ->add('Mail', EmailType::class, [
                'required' => true,
                'label' => 'Adresse Mail',
                'constraints' => [new NotBlank(),],
                'invalid_message' => 'Veuillez donnez votre adresse mail'
            ])

            ->add('Phone', NumberType::class, [
                'required' => false,
                'label' => 'Numéro de téléphone (optionnel)',
                'empty_data' => 'Non communiqué',
            ])

            ->add('Object', TextType::class, [
                'required' => false,
                'label' => 'Objet de votre message (optionnel)',
                'empty_data' => 'Sans objet',
            ])

            ->add('Message', TextareaType::class, [
                'required' => true,
                'label' => 'Votre message',
                'constraints' => [new NotBlank(),],
                'invalid_message' => 'Veuillez remplir ce champ',
                'attr' => ['rows' => '10', 'cols' => '100']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
