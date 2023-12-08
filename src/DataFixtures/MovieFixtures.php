<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i=0; $i<3;$i++) {
        $movie = new Movie();
        $movie->setTitle($faker->name);             
        // $movie->setTitle('Conan The Barbarian');             
          $movie->setReleaseYear(rand(1970,2023));             
          $movie->setDescription($faker->safeColorName);             
       // $movie->setImagePath('https://cdn.pixabay.com/photo/2022/11/23/20/49/barbarian-warrior-7612898_1280.jpg');  // $movie->setTitle('Conan The Barbarian');             

      $movie->setImagePath('https://cdn.pixabay.com/photo/2022/11/23/20/49/barbarian-warrior-7612898_1280.jpg');
      $movie->addActor($this->getReference('actor_' . rand(1, 12)));
      $movie->addActor($this->getReference('actor_' . rand(1, 12)));
      $movie->addActor($this->getReference('actor_'.rand(1,12)));// uses an added ref 
           $manager->persist($movie);
        }

        $manager->flush();
    }
}
