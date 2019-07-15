<?php

namespace App\Form;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\Location;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class DeliveryType extends AbstractType
{

    private $dateMin;
    private $dateMax;
    const NAME_FIELD = 'name';
    const DELIVERY_DATE_FIELD = 'deliveryDate';
    const COMMENT_FIELD = 'comments';

    public function __construct(ParameterBagInterface $params)
    {
        $dateParams = $params;
        $dateMin = $dateParams->get('date_interval_min');
        $dateMax = $dateParams->get('date_interval_max');

        $dateMin = new \DateTime($dateMin);
        $this->dateMin = $dateMin->format('Y-m-d');

        $dateMax = new DateTime($dateMax);
        $this->dateMax = $dateMax->format('Y-m-d');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::NAME_FIELD, EntityType::class, [
                'class' => Location::class,
                'required' => true,
                'constraints' => new NotBlank(['message' => 'Champ obligatoire']),
                'label' => 'Point de collecte :',
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'placeholder' => 'Choisir ...',
                'invalid_message' => 'Veuillez choisir un point de collecte.',
                'choice_label' => function ($location) {
                    $name = $location->getName();
                    $city = $location->getCity();
                    $isPrivate = $location->getIsPrivate();
                    $area = "$name | $city";
                    if ($isPrivate == true) {
                        $area .= ' ( Réservé aux employés )';
                    }
                    return $area;
                }
            ])
            ->add(self::DELIVERY_DATE_FIELD, DateType::class, [
                'label' => 'Date de collecte :',
                'required' => false,
                'attr' => [
                    'class' => 'text-left',
                    'min' => $this->dateMin,
                    'max' => $this->dateMax,
                    'placeholder' =>
                        'Veuillez entrer une date entre le ' . $this->dateMin . ' et le ' . $this->dateMax
                ],
                'invalid_message' => 'Veuillez entrer une date entre le ' . $this->dateMin . ' et le ' . $this->dateMax,
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'constraints' => [
                    new NotBlank(['message' => 'Champ obligatoire']),
                    new Range([
                        'min' => $this->dateMin,
                        'max' => $this->dateMax,
                        'minMessage' =>
                            'Veuillez entrer une date entre le ' . $this->dateMin . ' et le ' . $this->dateMax,
                        'maxMessage' =>
                            'Veuillez entrer une date entre le ' . $this->dateMin . ' et le ' . $this->dateMax,
                    ]),
                ],
                'widget' => 'single_text',
                'model_timezone' => 'Europe/Paris',
            ])
            ->add(self::COMMENT_FIELD, TextareaType::class, [
                'required' => false,
                'constraints' => new Length(['max' => 255]),
                'label' => 'Commentaire :',
                'label_attr' => ['class' => 'col-12 col-sm-12 px-0'],
                'invalid_message' => 'Veuillez limiter votre message à 255 caractères.',
                'attr' => ['rows' => '2', 'cols' => '80', 'placeholder' => 'Bonjour,'],
            ]);
    }
}
