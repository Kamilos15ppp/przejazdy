<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\NotFoundException;
use App\Exception\StorageException;
use PDO;
use Throwable;

class UserModel extends RideAbstractModel
{
    public function get(string $username): array
    {
        try {
            $username = $this->connection->quote($username);
            $query = "SELECT username, password, userRole FROM users WHERE username = $username";
            $result = $this->connection->query($query);
            $user = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie znaleziono takiego użytkownika');
        }

        if (!$user) {
            throw new NotFoundException("Użytkownik o podanym loginie: $username nie istnieje");
        }

        return $user;
    }

    public function createUser(array $data): void
    {
        try {
            $username = $this->connection->quote($data['username']);
            $usernameSafe =$data['usernameSafe'];
            $password = $data['password'];
            $userRole = $this->connection->quote($data['userRole']);
            $created = $this->connection->quote(date('Y-m-d H:i:s'));
            $passwordHash = $this->connection->quote(password_hash($password, PASSWORD_DEFAULT));
            $query = "INSERT INTO users(username, password, userRole, created) VALUES($username, $passwordHash, $userRole, $created)";
            $queryTable = "
                CREATE TABLE $usernameSafe (
                    id INT(200) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    tabor VARCHAR(50) NOT NULL,
                    line VARCHAR(50) NOT NULL,
                    direction VARCHAR(50) NOT NULL,
                    first VARCHAR(50) NOT NULL,
                    last VARCHAR(50) NOT NULL,
                    created DATETIME NOT NULL,
                    updated DATETIME DEFAULT NULL)";
            dump($queryTable);
            dump($query);

            $this->connection->exec($queryTable);
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowego użytkownika', 400, $e);
        }
    }
}