<?php

namespace App\DataFixtures;

use App\Entity\Documentation;
use App\Entity\Doumentation;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DocumentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 40; $i++) {

            $documentation = new Documentation();
            $documentation->setTitle($faker->realText(40, 2));
            $documentation->setContent($faker->realTextBetween(160, 500, 2));
            $documentation->setPoster('fixture3.jpg');
            $documentation->setAuthor($this->getReference('author_' . $faker->numberBetween(0, 7)));
            $manager->persist($documentation);
            $this->addReference('documentation_' . $i, $documentation);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
