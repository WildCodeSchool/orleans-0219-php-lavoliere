<?php

namespace App\DataFixtures;

use App\Entity\PickingCalendar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PickingCalendarFixtures extends Fixture implements DependentFixtureInterface
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
            $pickingCalendar = new PickingCalendar();
            $pickingCalendar->setProduct($produit);
            $pickingCalendar->setSeasonStartAt($this->getReference('month_' . rand(0, 11)));
            $pickingCalendar->setSeasonEndAt($this->getReference('month_' . rand(0, 11)));
            $pickingCalendar->setPickingStartAt($this->getReference('month_' . rand(0, 11)));
            $pickingCalendar->setPickingEndAt($this->getReference('month_' . rand(0, 11)));
            $pickingCalendar->setOutOfStock($faker->boolean);

            $manager->persist($pickingCalendar);
        }
        $manager->flush();
    }
}
