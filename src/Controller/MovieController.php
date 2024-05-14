<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class MovieController extends AbstractController
{
    private $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    #[Route('/', name: 'movie.index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/movie/{id}', requirements: ['id' => Requirement::DIGITS], name: 'movie.show')]
    public function show(): Response
    {
        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    #[Route('/api/movies/', name: 'movie.getmovies')]
    public function getMovies(Request $request): Response
    {
        $title = $request->query->get('title');
        $categories = $request->query->get('categories');
        $movies = (($title !== null && $title !== "") || ($categories !== null && $categories !== "")) ? $this->movieRepository->search($title, $categories): $this->movieRepository->findAll();
        return $this->json($movies, 200, [], [
            'groups' => ['movie.getmovies']
        ]);
    }

    #[Route('/api/movies/{id}', requirements: ['id' => Requirement::DIGITS], name: 'movie.getmovie')]
    public function getMovie(Movie $movie): Response
    {
        return $this->json($movie, 200, [], [
            'groups' => ['movie.getmovie']
        ]);
    }

    #[Route('/api/movies/{id}/suggestions', requirements: ['id' => Requirement::DIGITS], name: 'movie.getmovie.suggestion')]
    public function getMovieSuggestion(Movie $movie): Response
    {
        return $this->json($movie->getSuggestions(), 200, [], [
            'groups' => ['movie.getmovies']
        ]);
    }
}
