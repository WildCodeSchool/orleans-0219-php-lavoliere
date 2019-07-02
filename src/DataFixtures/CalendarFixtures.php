<?php

namespace App\DataFixtures;

use App\Entity\Calendar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CalendarFixtures extends Fixture
{

    const PRODUITS = [
        'fraise',
        'framboise',
        'tomate',
        'salade',
        'courgette',
        'radis',
        'carotte',
        'poivron/aubergine',
        'haricot vert',
        'petit pois',
        'courge',
        'concombre',
        'mache',
        'poireau',
        'fleur a couper',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        foreach (self::PRODUITS as $key => $produit) {
            $calendar = new Calendar();
            $calendar->setProduct($produit);
            $calendar->setSeasonStartAt($faker->dateTimeThisYear($max = 'now', $timezone = null));
            $calendar->setSeasonEndAt($faker->dateTimeThisYear($max = 'now', $timezone = null));
            $calendar->setPickingStartAt($faker->dateTimeThisYear($max = 'now', $timezone = null));
            $calendar->setPickingEndAt($faker->dateTimeThisYear($max = 'now', $timezone = null));
            $calendar->setOutOfStock($faker->boolean);

            $manager->persist($calendar);
        }
        $manager->flush();
    }
}
