<?php
/**
 * Created by PhpStorm.
 * User: maiwenn
 * Date: 03/07/2019
 * Time: 10:16
 */

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $recipe = new Recipe();
            $recipe->setName($faker->word);
            $recipe->setIsPresent($faker->boolean);
            $recipe->setUrl($faker->url);

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
