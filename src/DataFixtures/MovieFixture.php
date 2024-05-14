<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Repository\CategoryRepository;
use App\Repository\CsaRepository;
use App\Service\CallTMDBAPIService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixture extends Fixture
{
    private $tmdbService;
    private $categoryRepository;
    private $csaRepository;

    public function __construct(CallTMDBAPIService $tmdbService, CategoryRepository $categoryRepository, CsaRepository $csaRepository)
    {
        $this->tmdbService = $tmdbService;
        $this->categoryRepository = $categoryRepository;
        $this->csaRepository = $csaRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $listMovies = [];
        for ($i = 1; $i <= 10; $i++) {
            $movies = $this->tmdbService->getTMDBMovies($i);
            $listMovies = array_merge($listMovies, $movies["results"]);
        }
        
        foreach($listMovies as $m) {
            $detail = $this->tmdbService->getTMDBMovieDetail($m["id"]);
            $credits = $this->tmdbService->getTMDBMovieCredit($m["id"]);
            $trailers = $this->tmdbService->getTMDBMovieTrailer($m["id"]);
            $actors = [];
            $productions = [];
            foreach($credits["cast"] as $credit) {
                if($credit["known_for_department"] === "Acting") {
                    array_push($actors, $credit["name"]);
                }
            }
            foreach($credits["crew"] as $credit) {
                if($credit["known_for_department"] === "Production") {
                    array_push($productions, $credit["name"]);
                }
            }
            $movie = new Movie();
            $movie->setIdTMDB($m["id"]);
            $movie->setTitle($m["title"]);
            $movie->setDescription($m["overview"]);
            $movie->setThumbnail("https://image.tmdb.org/t/p/w500" . $m["poster_path"]);
            if(!empty($trailers["results"])) {
                $movie->setTrailer($trailers["results"][0]["key"]);
            } else {
                $movie->setTrailer("dQw4w9WgXcQ");
            }
            $production = count($productions) > 0 ? $productions[0] : "";
            $movie->setDirector($production);
            $movie->setActors($actors);
            $movie->setDuration($detail["runtime"]);
            $csa = $this->csaRepository->find($this->getReference("Tous public"));
            $movie->setCsa($csa);
            $movieCategories = $m["genre_ids"];
            foreach($movieCategories as $movieCategorie) {
                $mc = $this->categoryRepository->findOneBy(['idTMDB' => $movieCategorie]);
                $movie->addCategory($mc);
            }
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CsaFixture::class,
            CategoryFixture::class,
        );
    }
}