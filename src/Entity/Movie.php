<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["movie.getmovies", "movie.getmovie"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["movie.getmovies", "movie.getmovie"])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(["movie.getmovies", "movie.getmovie"])]
    private ?string $thumbnail = null;

    #[ORM\Column(length: 255)]
    #[Groups(["movie.getmovie"])]
    private ?string $trailer = null;

    #[ORM\Column(length: 255)]
    #[Groups(["movie.getmovie"])]
    private ?string $director = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(["movie.getmovie"])]
    private array $actors = [];

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $suggestions;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'movies')]
    #[Groups(["movie.getmovies", "movie.getmovie"])]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["movie.getmovies", "movie.getmovie"])]
    private ?Csa $csa = null;

    #[ORM\Column]
    #[Groups(["movie.getmovie"])]
    private ?int $duration = null;

    #[ORM\Column(length: 1000)]
    #[Groups(["movie.getmovie"])]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $idTMDB = null;

    public function __construct()
    {
        $this->suggestions = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getTrailer(): ?string
    {
        return $this->trailer;
    }

    public function setTrailer(string $trailer): static
    {
        $this->trailer = $trailer;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getActors(): array
    {
        return $this->actors;
    }

    public function setActors(array $actors): static
    {
        $this->actors = $actors;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSuggestions(): Collection
    {
        return $this->suggestions;
    }

    public function addSuggestion(self $suggestion): static
    {
        if (!$this->suggestions->contains($suggestion)) {
            $this->suggestions->add($suggestion);
        }

        return $this;
    }

    public function removeSuggestion(self $suggestion): static
    {
        $this->suggestions->removeElement($suggestion);

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addMovie($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeMovie($this);
        }

        return $this;
    }

    public function getCsa(): ?Csa
    {
        return $this->csa;
    }

    public function setCsa(?Csa $csa): static
    {
        $this->csa = $csa;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIdTMDB(): ?int
    {
        return $this->idTMDB;
    }

    public function setIdTMDB(int $idTMDB): static
    {
        $this->idTMDB = $idTMDB;

        return $this;
    }

}
