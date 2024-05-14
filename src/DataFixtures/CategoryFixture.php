<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\CallTMDBAPIService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    private $tmdbService;

    public function __construct(CallTMDBAPIService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $this->tmdbService->getTMDBCategories();

        foreach($categories["genres"] as $c) {
            $category = new Category();
            $category->setName($c["name"]);
            $category->setIdTMDB($c["id"]);
            $manager->persist($category);
            $this->addReference($c["id"], $category);
        }

        $manager->flush();
    }
}
