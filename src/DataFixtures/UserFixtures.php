<?php

namespace App\DataFixtures;

use App\Entity\Documentation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail('test@gmail.com');
        $user->setLastname('Broyer');
        $user->setFirstname('Damien');
        $user->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'test2601'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $faker = Factory::create();
        for ($i = 0; $i < 8; $i++) {
            $author = new User();
            $author->setEmail($faker->email());
            $author->setLastname($faker->lastName());
            $author->setFirstname($faker->firstName());
            $author->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword($author, '123@wiki-wild');
            $author->setPassword($hashedPassword);
            $manager->persist($author);
            $this->addReference('author_' . $i, $author);
        }

        $manager->flush();
    }
}
