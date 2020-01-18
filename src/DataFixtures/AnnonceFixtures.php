<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Entity\Rubrique;
use App\Entity\User;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\DateTime;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        // 6 rubriques
        for ($i = 1; $i <= 6; $i++) {
            $rubrique = new Rubrique();
            $rubrique->setLibelle($faker->word);

            $manager->persist($rubrique);
            // 3 images
            for ($j = 1; $j <= 6; $j++) {
                $user = new User();
                $user->setName($faker->firstName())
                     ->setEmail($faker->email)
                     ->setPassword($faker->password(16));

                $manager->persist($user);

                for ($k = 1; $k <= 6; $k++) {
                    $annonce   = new Annonce();
                    $createdAt = $faker->dateTimeBetween('- 3 months');
                    $limit     = $createdAt->add(new DateInterval('P21D'));
                    $annonce->setBody($faker->paragraph(4))
                            ->setTitle($faker->sentence(4))
                            ->setAuthor($user)
                            ->setCreatedAt($createdAt)
                            ->setLimitDate($limit)
                            ->setRubrique($rubrique);

                    $manager->persist($annonce);

                    for ($l = 1; $l <= 3; $l++) {
                        $image = new Image();
                        $image->setSrc($faker->imageUrl())
                              ->setAnnonce($annonce);
                        $manager->persist($image);
                    }
                }
            }
        }

        $manager->flush();
    }
}
