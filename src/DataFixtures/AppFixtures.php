<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\entity\Module;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    $faker = Faker\Factory::create('fr_FR');
        $modules = [];
        for ($i = 1; $i <= 10; $i++){
            $modules[$i] = new Module();
            $modules[$i] ->setName($faker->name)
                ->setDescription($faker->paragraph)
                ->setUptime($faker->dateTime())
                ->setIsWorking($faker->boolean())
                ->setTemperature($faker->numberBetween(-20,55))
                ->setHumidity($faker->numberBetween(0,100))
                ->setWind($faker->numberBetween(0,200));
            $manager->persist($modules[$i]);
        }
        $manager->flush();
    }
}
