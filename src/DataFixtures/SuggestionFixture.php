<?php

namespace App\DataFixtures;

use App\Repository\MovieRepository;
use App\Service\CallTMDBAPIService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SuggestionFixture extends Fixture
{
    private $tmdbService;
    private $movieRepository;

    public function __construct(CallTMDBAPIService $tmdbService, MovieRepository $movieRepository)
    {
        $this->tmdbService = $tmdbService;
        $this->movieRepository = $movieRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $movies = $this->movieRepository->findAll();
        foreach($movies as $movie) {
            $recommendations = $this->tmdbService->getTMDBMovieRecommendations($movie->getIdTMDB());
            if (count($recommendations["results"]) > 0) {
                foreach($recommendations["results"] as $recommendation) {
                    $suggestion = $this->movieRepository->findOneBy(['idTMDB' => $recommendation["id"]]);
                    if ($suggestion !== null) {
                        $movie->addSuggestion($suggestion);
                        $manager->persist($movie);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            MovieFixture::class,
        );
    }
}
