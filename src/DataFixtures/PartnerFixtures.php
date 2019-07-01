<?php
/**
 * Created by PhpStorm.
 * User: maiwenn
 * Date: 01/07/2019
 * Time: 11:25
 */

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 3; $i++) {
            $event = new Partner();
            $event->setName($faker->realText($maxNbChars = 100, $indexSize = 2));
            $event->setDescription($faker->realText($maxNbChars = 300, $indexSize = 2));
            $event->setPicture($faker->imageUrl(500, 600, 'food'));
            $manager->persist($event);
        }
        $manager->flush();
    }
}
