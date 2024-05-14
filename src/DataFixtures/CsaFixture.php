<?php

namespace App\DataFixtures;

use App\Entity\Csa;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CsaFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $csaName = [
            "Tous public",
            "Déconseillé aux moins de 10 ans",
            "Déconseillé aux moins de 12 ans",
            "Interdit aux moins de 16 ans",
            "Interdit aux moins de 18 ans"
        ];
        $csaValue = [null, 10, 12, 16, 18];
        for ($i = 0; $i < 5; $i++) {
            $csa = new Csa();
            $csa->setName($csaName[$i]);
            if ($i !== 0) {
                $csa->setValue($csaValue[$i]);
            }
            $manager->persist($csa);
            $this->addReference($csaName[$i], $csa);
        }

        $manager->flush();
    }
}
