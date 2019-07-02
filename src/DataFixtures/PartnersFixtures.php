<?php
/**
 * Created by PhpStorm.
 * User: maiwenn
 * Date: 02/07/2019
 * Time: 09:52
 */

namespace App\DataFixtures;

use App\Entity\Partners;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PartnersFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $event = new Partners();
            $event->setName($faker->realText($maxNbChars = 100, $indexSize = 2));
            $event->setDescription($faker->realText($maxNbChars = 200, $indexSize = 2));
            $event->setPicture($faker->imageUrl(500, 600, 'food'));
            $manager->persist($event);
        }
        $manager->flush();
    }
}
