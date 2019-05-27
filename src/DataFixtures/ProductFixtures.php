<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i <= 13; $i++) {
            $product = new Product();
            $product->setName($faker->word);
            $product->setBundle($faker->sentence(4, true));
            $product->setPrice($faker->randomFloat(2, 0, 30));
            $product->setDescription($faker->sentence(10, true));
            $product->setOrigin($faker->word);
            $product->setPicture($faker->imageUrl(480, 640, 'food'));
            $product->setIsShowcased($faker->boolean(5));
            $product->setIsAvailable($faker->boolean(90));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
