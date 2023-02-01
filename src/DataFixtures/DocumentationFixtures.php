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

            $documenation = new Documentation();
            $documenation->setTitle($faker->realText(40, 2));
            $documenation->setContent($faker->realTextBetween(160, 500, 2));
            $documenation->setPoster('fixture1.jpg');
            $documenation->setAuthor($this->getReference('author_' . $faker->numberBetween(0, 7)));
            $manager->persist($documenation);
            $this->addReference('documentation_' . $i, $documenation);
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
