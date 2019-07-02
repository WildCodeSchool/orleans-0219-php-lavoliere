<?php

namespace App\DataFixtures;

use App\Entity\Calendar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CalendarFixtures extends Fixture implements DependentFixtureInterface
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

    public function getDependencies()
    {
        return [MonthCalendarFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        foreach (self::PRODUITS as $key => $produit) {
            $calendar = new Calendar();
            $calendar->setProduct($produit);
            $calendar->setSeasonStartAt($this->getReference('month_' . rand(0, 11)));
            $calendar->setSeasonEndAt($this->getReference('month_' . rand(0, 11)));
            $calendar->setPickingStartAt($this->getReference('month_' . rand(0, 11)));
            $calendar->setPickingEndAt($this->getReference('month_' . rand(0, 11)));
            $calendar->setOutOfStock($faker->boolean);

            $manager->persist($calendar);
        }
        $manager->flush();
    }
}
