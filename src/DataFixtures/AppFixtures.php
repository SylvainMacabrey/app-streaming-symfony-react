<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Csa;
use App\Entity\Movie;
use App\Repository\CategoryRepository;
use App\Repository\CsaRepository;
use App\Service\CallTMDBAPIService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }
}
