<?php

namespace App\DataFixtures;


use App\Entity\Post;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;

use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    //nous avons besoin de l'encodeur pour encoder les mots de passe
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        //Nous créons une instance de Faker en français
        $faker = Factory::create('fr_FR');

        // Nous créons 3 themes
        $themes = [];
        for ($t = 0; $t < 3; $t++) {
            $theme = new Theme();
            $theme->setNom($faker->sentence());
            $manager->persist($theme);
            $themes[] = $theme; // Nous les enregistrons dans un tableau
        }

        // Nous créons 5 utilisateurs
        for ($u = 0; $u < 5; $u++) {
            $user = new User;
            $hash = $this->encoder->hashPassword($user, "password");
            $user->setRoles(["ROLE_USER"])
                ->setIsVerified(true)
                ->setSurname($faker->lastName())
                ->setName($faker->firstName())
                ->setEmail($faker->email())
                ->setConsent(true)
                ->setLastInteraction(new \DateTime())
                ->setEmail($faker->email())
                ->setPassword($hash);
            $manager->persist($user);

            //Pour chaque utilisateur, nous créons entre 2 et 5 articles
            for ($p = 0; $p < mt_rand(2, 5); $p++) {
                $post = new Post();
                $post->setTitle($faker->sentence())
                    ->setContent($faker->paragraph(5))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setDraft(false)
                    ->setLikes(0)
                    ->setUser($user);
                //Et nous affectons les themes au post aléatoirement
                $randomThemes = (array)array_rand($themes, mt_rand(1, 3));
                foreach ($randomThemes as $themeIndex) {
                    $post->addTheme($themes[$themeIndex]);
                }
                $manager->persist($post);
            }
        }
        // Nous enregistrons le tout en base de données
        $manager->flush();

    }
}