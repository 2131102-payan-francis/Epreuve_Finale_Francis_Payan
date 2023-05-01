<?php

namespace App\Domain\User;

use PDO;

class UserRepository
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function isValidApiKey(string $apiKey): bool
    {
        $stmt = $this->connection->prepare("SELECT id FROM usager WHERE cle = :apiKey");
        $stmt->bindParam(':apiKey', $apiKey);
        $stmt->execute();

        return !empty($stmt->fetch(PDO::FETCH_ASSOC));
    }

    // Fonction pour vérifier si l'utilisateur existe dans la base de données :
    public function login(string $codeUsager, string $password): ?array
    {
        $stmt = $this->connection->prepare("SELECT id, codeusager, motdepasse FROM usager WHERE codeusager = :codeUsager");
        $stmt->bindParam(':codeUsager', $codeUsager);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($password, $user['motdepasse'])) {
            return null;
        }

        return $user;
    }

    // Fonction pour générer une nouvelle clé API et l'associer à l'utilisateur :
    public function generateApiKey(int $userId): string
    {
        $apiKey = bin2hex(random_bytes(16));

        $stmt = $this->connection->prepare("UPDATE usager SET cle = :apiKey WHERE id = :userId");
        $stmt->bindParam(':apiKey', $apiKey);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $apiKey;
    }

}
