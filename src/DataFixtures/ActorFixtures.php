<?php

namespace App\DataFixtures;

use App\Entity\Actor;
 ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for($i=0; $i<13;$i++) {
        $actor = new Actor();
        $actor->setName($faker->name);             
             
          $actor->setBirthYear(rand(1970,2000));             
        
           $manager->persist($actor);
          $this->addReference('actor_'.$i,$actor);//adds a relation ref to use in other fixtures 
        }

        $manager->flush();

      
    }
}
