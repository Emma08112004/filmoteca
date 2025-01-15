<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\TemplateRenderer;
use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Service\EntityMapper;

class FilmController 
{
    private TemplateRenderer $renderer;

    public function __construct()
    {
        $this->renderer = new TemplateRenderer();
    }

    public function list(array $queryParams): void
    {
        $filmRepository = new FilmRepository();
        $films = $filmRepository->findAll();
        
        echo $this->renderer->render('film/list.html.twig', [
            'films' => $films,
        ]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filmEntityMapper = new EntityMapper();
            $film = $filmEntityMapper->mapToEntity($_POST, Film::class);

            $film->setCreatedAt(new \DateTime());
            $film->setUpdatedAt(new \DateTime());

            $filmRepository = new FilmRepository();
            $filmRepository->create($film);

            header('Location: /film/list?message=Film%20créé%20avec%20succès');
            exit;
        }

        echo $this->renderer->render('film/create-movie.html.twig');
    }

    public function read(array $queryParams): void
    {
        $filmRepository = new FilmRepository();
        $film = $filmRepository->find((int)$queryParams['id']);
        
        echo $this->renderer->render('film/read.html.twig', [
            'film' => $film,
        ]);
    }

    public function delete(array $queryParams): void
    {
        if (!isset($queryParams['id'])) {
            throw new \InvalidArgumentException('Film ID is required.');
        }

        $filmRepository = new FilmRepository();
        $film = $filmRepository->find((int)$queryParams['id']);

        if (!$film) {
            throw new \RuntimeException('Film not found.');
        }

        $filmRepository->delete($film);
        header('Location: /film/list');
        exit;
    }

    public function update(array $queryParams): void
    {
        if (!isset($queryParams['id'])) {
            throw new \InvalidArgumentException('Film ID is required.');
        }

        $filmRepository = new FilmRepository();
        $film = $filmRepository->find((int)$queryParams['id']);

        if (!$film) {
            throw new \RuntimeException('Film not found.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $film->setTitle($_POST['title']);
            $film->setYear($_POST['year']);
            $film->setType($_POST['type']);
            $film->setDirector($_POST['director']);
            $film->setSynopsis($_POST['synopsis']);
            $film->setUpdatedAt(new \DateTime());
            $filmRepository->update((int)$queryParams['id'], $film);

            header('Location: /film/list?message=Film%20mis%20à%20jour%20avec%20succès');
            exit;
        }

        echo $this->renderer->render('film/update.html.twig', [
            'film' => $film,
        ]);
    }
}
