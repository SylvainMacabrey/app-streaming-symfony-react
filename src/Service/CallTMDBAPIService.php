<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallTMDBAPIService {

    private $client;
    private $baseurl;
    private $apikey;

    public function __construct(HttpClientInterface $client)
    {
        $this->baseurl = "https://api.themoviedb.org/3/";
        $this->apikey = "a4fcb2105887f5dce7cea6ab64bcff43";
        $this->client = $client;
    }

    private function clientRequest($url, $page = null): array
    {
        $urlRequest =  $this->baseurl . $url . '?api_key=' . $this->apikey;
        if ($page !== null) {
            $urlRequest .= '&page=' . $page;
        }
        $response = $this->client->request('GET', $urlRequest);
        return $response->toArray();
    }

    public function getTMDBCategories(): array
    {
        return $this->clientRequest('genre/movie/list');
    }

    public function getTMDBMovies($page): array
    {
        return $this->clientRequest('movie/now_playing', $page);
    }

    public function getTMDBMovieDetail($id): array
    {
        return $this->clientRequest('movie/' . $id);
    }

    public function getTMDBMovieCredit($id): array
    {
        return $this->clientRequest('movie/' . $id . '/credits');
    }

    public function getTMDBMovieRecommendations($id): array
    {
        return $this->clientRequest('movie/' . $id . '/recommendations');
    }

    public function getTMDBMovieTrailer($id): array
    {
        return $this->clientRequest('movie/' . $id . '/videos');
    }
}