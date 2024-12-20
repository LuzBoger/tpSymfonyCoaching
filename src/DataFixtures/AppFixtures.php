<?php

namespace App\DataFixtures;

use App\Entity\FollowUp;
use App\Entity\Program;
use App\Entity\Session;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Créer des utilisateurs
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name())
                ->setEmail($faker->unique()->safeEmail());
            $user->setPassword("coucou123");
            $manager->persist($user);
            $users[] = $user;
        }

        // Créer des programmes
        $programs = [];
        foreach ($users as $user) {
            for ($i = 0; $i < 2; $i++) {
                $program = new Program();
                $program->setTitle($faker->words(3, true))
                    ->setDescription($faker->sentence())
                    ->setUserProgram($user);
                $manager->persist($program);
                $programs[] = $program;
            }
        }

        // Créer des sessions
        $sessions = [];
        foreach ($programs as $program) {
            for ($i = 0; $i < 3; $i++) {
                $session = new Session();
                $session->setDate($faker->dateTimeBetween('-1 year', 'now'))
                    ->setStatus($faker->randomElement(['Pending', 'Completed', 'Cancelled']))
                    ->setProgram($program);
                $manager->persist($session);
                $sessions[] = $session;
            }
        }

        // Créer des suivis pour les sessions
        foreach ($sessions as $session) {
            $followUp = new FollowUp();
            $followUp->setComments($faker->sentence())
                ->setRating($faker->numberBetween(1, 5));
            $session->setFollowUp($followUp);
            $manager->persist($followUp);
        }

        // Associer les utilisateurs aux sessions
        foreach ($sessions as $session) {
            $randomUsers = $faker->randomElements($users, rand(2, 5));
            foreach ($randomUsers as $user) {
                $session->addUser($user);
            }
        }

        $manager->flush();
    }
}
