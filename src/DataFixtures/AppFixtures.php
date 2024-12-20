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
        $coaches = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name())
                ->setEmail($faker->unique()->safeEmail())
                ->setPlainPassword(plainPassword: 'coucou123');

            if ($i < 5) {
                // Les 5 premiers utilisateurs sont des coaches
                $user->setRoles(['ROLE_ADMIN']);
                $coaches[] = $user;
            } else {
                // Les autres sont des utilisateurs normaux
                $user->setRoles(['ROLE_USER']);
                $userUser[] = $user;
            }

            $manager->persist($user);
            $users[] = $user;
        }

        // Créer des programmes
        $programs = [];
        foreach ($coaches as $coach) {
            for ($i = 0; $i < 2; $i++) {
                $program = new Program();
                $program->setTitle($faker->words(3, true))
                    ->setDescription($faker->sentence())
                    ->setUserProgram($coach); // Relation User-Program corrigée
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
                    ->setProgram($program); // Relation Program-Session
                $manager->persist($session);
                $sessions[] = $session;
            }
        }

        // Créer des suivis pour les sessions
        foreach ($sessions as $session) {
            // Filtrer uniquement les utilisateurs avec ROLE_USER
            $roleUsers = array_filter($users, function ($user) {
                return $user->getRoles() === ['ROLE_USER']; // Vérification stricte des rôles
            });

            // Associer des utilisateurs aléatoires avec ROLE_USER
            $randomUsers = $faker->randomElements($roleUsers, rand(2, 5));
            foreach ($randomUsers as $user) {
                $session->addUser($user); // Relation ManyToMany
            }
        }

        // Associer uniquement les utilisateurs avec ROLE_USER aux sessions

        foreach ($sessions as $session) {
            $randomUsers = $faker->randomElements($userUser, rand(2, 5));
            foreach ($randomUsers as $user) {
                $session->addUser($user); // Relation ManyToMany
            }
        }

        $manager->flush();
    }


}
