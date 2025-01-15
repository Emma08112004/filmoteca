<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\DatabaseConnection;
use App\Service\EntityMapper;
use App\Entity\Film;

class FilmRepository
{
    private \PDO $db;
    private EntityMapper $entityMapperService;

    public function __construct()
    {
        $this->db = DatabaseConnection::getConnection();
        $this->entityMapperService = new EntityMapper();
    }

    public function findAll(): array
    {
        $query = 'SELECT * FROM film';
        $stmt = $this->db->query($query);
        $films = $stmt->fetchAll();
        return $this->entityMapperService->mapToEntities($films, Film::class);
    }

    public function find(int $id): Film
    {
        $query = 'SELECT * FROM film WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $film = $stmt->fetch();
        return $this->entityMapperService->mapToEntity($film, Film::class);
    }
    public function read(array $queryParams): void {

        $filmRepository = new FilmRepository();
        $film = $filmRepository->find((int)$queryParams['id']);
    
        echo $this->renderer->render('film/read.html.twig', [
            'film' => $film,
        ]);
    }

    
    public function update($id, Film $film): bool
    {
        $stmt = $this->db->prepare("
            UPDATE film
            SET title = :title, year = :year, type = :type, synopsis = :synopsis, director = :director, updated_at = NOW(), deleted_at = NULL
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $film->getTitle(),
            ':year' => $film->getYear(),
            ':type' => $film->getType(),
            ':synopsis' => $film->getSynopsis(),
            ':director' => $film->getDirector(),
        ]); 
    }


    public function create(Film $film): bool
    {
        $query = 'INSERT INTO film (title, year, type, synopsis, director, created_at)
                  VALUES (:title, :year, :type, :synopsis, :director, NOW())';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':title', $film->getTitle());
        $stmt->bindValue(':year', $film->getYear(), \PDO::PARAM_INT);  
        $stmt->bindValue(':type', $film->getType());
        $stmt->bindValue(':synopsis', $film->getSynopsis() ?? null);  
        $stmt->bindValue(':director', $film->getDirector() ?? null);  

        $stmt->execute();

        $filmId = $this->db->lastInsertId();
        $film->setId((int) $filmId);

        return true;
    }

    public function delete(Film $film): void
    {
        $stmt = $this->db->prepare('DELETE FROM film WHERE id = :id');
        $stmt->execute(['id' => $film->getId()]);
    }
}
