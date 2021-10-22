<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $admin = new User;
        $admin->firstName = $faker->firstName;
        $admin->lastName = $faker->lastName;
        $admin->email = "admin@mail.com";
        $admin->password = "password";
        $admin->roles = ["ROLE_ADMIN"];
        $manager->persist($admin);

        $moderator = new User;
        $moderator->firstName = $faker->firstName;
        $moderator->lastName = $faker->lastName;
        $moderator->email = "moderator@mail.com";
        $moderator->password = "password";
        $moderator->roles = ["ROLE_MODERATOR"];
        $manager->persist($moderator);


        for($u = 0; $u < 5; $u++) {
            $user = new User;
            $user->firstName = $faker->firstName;
            $user->lastName = $faker->lastName;
            $user->email = "user$u@mail.com";
            $user->password = "az";

            $manager->persist($user);

            for($i = 0; $i < random_int(5, 10); $i++) {
                $event = new Event;

                $event->name  = 'Rendez-vous avec ' . $faker->lastName;
                $event->date  = $faker->dateTimeBetween('+0 days', '+1 month');
                $event->createdAt  = $faker->dateTimeBetween("-6 months");
                $event->description  = $faker->text(555);
                $event->user = $user;

                $manager->persist($event);
            }

            for($i = 0; $i < random_int(5, 10); $i++) {
                $event = new Event;

                $event->name  = 'rendez-vous avec ' . $faker->lastName;
                $event->date  = $faker->dateTimeBetween("-5 months");
                $event->createdAt  = $faker->dateTimeBetween("-6 months");
                $event->description  = 'description';
                $event->user = $user;

                $manager->persist($event);
            }

        }


        $manager->flush();
    }
}
