<?php


namespace App\DataFixtures;

use App\Entity\Location;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Self_;

class LocationFixtures extends Fixture
{

    const NAME = [
        'La ferme',
        'Le distributeur',
        'Le Lab\'O',
        'Orléans Métropole',
    ];

    const LOCATION_TYPE = [
        'Entreprise',
        'Particulier',
    ];

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        foreach (self::NAME as $names) {
            $location = new Location();
            $location->setName($names);
            $location->setAdress($faker->streetAddress);
            $location->setPostalCode($faker->postcode);
            $location->setCity($faker->city);
            $location->setDeliveryDate($faker->dayOfWeek);
            $location->setLocationType(self::LOCATION_TYPE[rand(0, 1)]);

            $manager->persist($location);
        }
        $manager->flush();
    }
}
