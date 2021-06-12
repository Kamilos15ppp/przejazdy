<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class RideModel extends RideAbstractModel implements RideModelInterface
{
    public function list(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array
    {
        return $this->findBy($pageNumber, $pageSize, $sortBy, $sortOrder);
    }

    public function listVehicles(string $type): array
    {
        try {
            switch ($type) {
                case 'bus':
                    $type = 'A';
                    break;
                case 'tram':
                    $type = 'T';
                    break;
                case 'relic':
                    $type = 'Z';
                    break;
            }

            $query = "SELECT tabor, producer, model FROM pojazdy WHERE type = '$type'";
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {}
        throw new StorageException('Nie udało się pobrać danych o pojazdach', 400, $e);
    }

    public function count(): int
    {
        try {
            $username = '';
            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }
            $query = "SELECT count(*) AS cn FROM $username";
            $result = $this->connection->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new StorageException('Błąd przy próbie pobrania ilości przejazdów', 400);
            }

            return (int) $result['cn'];
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać informacji o liczbie przejazdów', 400, $e);
        }
    }

    public function get(int $id): array
    {
        try {
            $username = '';
            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }
            $query = "SELECT * FROM $username WHERE id = $id";
            $result = $this->connection->query($query);
            $ride = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać przejazdu', 400, $e);
        }

        if (!$ride) {
            throw new NotFoundException("Przejazd o id: $id nie istnieje");
        }

        return $ride;
    }

    public function create(array $data): void
    {
        try {
            $tabor = $this->connection->quote($data['tabor']);
            $line = $this->connection->quote($data['line']);
            $direction = $this->connection->quote($data['direction']);
            $first = $this->connection->quote($data['first']);
            $last = $this->connection->quote($data['last']);
            $created = $this->connection->quote(date('Y-m-d H:i:s'));

            $username = '';
            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }

            $query = "
                INSERT INTO $username(tabor, line, direction, first, last, created)
                VALUES($tabor, $line, $direction, $first, $last, $created)
            ";

            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowego przejazdu', 400, $e);
        }
    }

    public function edit(int $id, array $data): void
    {
        try {
            $tabor = $this->connection->quote($data['tabor']);
            $line = $this->connection->quote($data['line']);
            $direction = $this->connection->quote($data['direction']);
            $first = $this->connection->quote($data['first']);
            $last = $this->connection->quote($data['last']);
            $updated = $this->connection->quote(date('Y-m-d H:i:s'));

            $username = '';
            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }

            $query = "
                UPDATE $username
                SET tabor = $tabor,
                    line = $line,
                    direction = $direction,
                    first = $first,
                    last = $last,
                    updated = $updated
                WHERE id = $id
            ";

            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się zaktualizować przejazdu', 400, $e);
        }
    }

    public function delete(int $id): void
    {
        try {
            $username = '';
            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }
            $query = "DELETE FROM $username WHERE id = $id";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się usunąć przejazdu', 400, $e);
        }
    }

    private function findBy(
        int $pageNumber,
        int $pageSize,
        string $sortBy,
        string $sortOrder
    ): array
    {
        try {
            $limit = $pageSize;
            $offset = ($pageNumber - 1) * $pageSize;
            $username = '';

            if (!in_array($sortBy, ['created', 'tabor'])) {
                $sortBy = 'created';
            }

            if (!in_array($sortOrder, ['asc', 'desc'])) {
                $sortOrder = 'desc';
            }

            if(!empty($_SESSION)) {
                $username = $_SESSION['username'];
            }

            $query = "
                SELECT id, tabor, line, direction, first, last, created 
                FROM $username 
                ORDER BY $sortBy $sortOrder
                LIMIT $offset, $limit    
            ";
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać przejazdów', 400, $e);
        }
    }
}