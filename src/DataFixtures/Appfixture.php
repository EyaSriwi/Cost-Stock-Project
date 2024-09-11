<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Appfixture extends Fixture
{
    private $faker;



    public function __construct()
    {
        $this->faker = FakerFactory::create();

    }

    public function load(ObjectManager $manager): void
    {
        //user
        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user->setFullName($this->faker->name())
                ->setUsername($this->faker->userName())  // Always provide a username
                ->setEmail($this->faker->email())
                ->setRoles(["ROLE_USERE"])
                ->setPlainPassword('password');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
