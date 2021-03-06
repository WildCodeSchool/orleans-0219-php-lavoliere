<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $event = new Event();
            $event->setTitle($faker->realText($maxNbChars = 100, $indexSize = 2));
            $event->setDescription($faker->realText($maxNbChars = 300, $indexSize = 2));
            $event->setPicture($faker->imageUrl(500, 600, 'food'));
            $event->setStartAt($faker->dateTime($max = '2040-12-29 00:00:00', $timezone = null));
            $event->setEndAt($faker->dateTime($max = '2040-12-29 00:00:00', $timezone = null));
            $manager->persist($event);
        }
        $manager->flush();
    }
}
