<?php

namespace App\Domain\Contact\Repository;

use PDO;

/**
 * Repository.
 */
class ContactRepository
{
    /**
     * @var PDO La connexion à la base de données
     */
    private $connection;

    /**
     * Constructeur.
     *
     * @param PDO $connection La connexion à la base de données
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Sélectionne la liste de tous les contacts.
     *
     * @return array La liste des contacts
     */
    public function selectAllContacts(): array
    {
        $sql = "SELECT * FROM contact";

        $query = $this->connection->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Sélectionne les informations d'un contact.
     * 
     * @param int $contactId Le id du contact à afficher
     * 
     * @return array Les informations du contact
     */
    public function selectContactById(int $contactId): array
    {
        $sql = "SELECT * FROM contact WHERE id = :id;";
        $params = [
            'id' => $contactId
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result[0] ?? [];
    }

    /**
     * Met à jour un contact dans la base de données.
     *
     * @param int $contactId L'ID du contact à mettre à jour
     * @param array $data Les données à mettre à jour
     * @return array Le contact mis à jour
     */
    public function updateContact(int $contactId, array $data): array
    {
        $sql = "UPDATE contact
                SET nom = :nom, 
                    prenom = :prenom, 
                    email = :email, 
                    message = :message
                WHERE id = :id;";
        
        $params = [
            "id" => $contactId,
            "nom" => $data['nom'] ?? "",
            "prenom" => $data['prenom'] ?? "",
            "email" => $data['email'] ?? "",
            "message" => $data['message'] ?? ""
        ];
        
        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $this->selectContactById($contactId);

        return $result;
    }

    /**
     * Supprime un contact dans la base de données.
     *
     * @param int $contactId L'ID du contact à supprimer
     * @return bool
     */
    public function deleteContact(int $contactId): bool
    {
        $sql = "DELETE FROM contact WHERE id = :id;";
        $params = [
            'id' => $contactId
        ];

        $query = $this->connection->prepare($sql);
        $query->execute($params);

        return true;
    }

    /**
     * Insère un contact dans la base de données.
     *
     * @param array $data Les données à insérer
     * @return array Le contact inséré
     */
    public function insertContact(array $data): array
    {
        $sql = "INSERT INTO contact (nom, prenom, email, message)
                VALUES (:nom, :prenom, :email, :message);";
        
        $params = [
            "nom" => $data['nom'] ?? "",
            "prenom" => $data['prenom'] ?? "",
            "email" => $data['email'] ?? "",
            "message" => $data['message'] ?? ""
        ];
        
        $query = $this->connection->prepare($sql);
        $query->execute($params);

        $result = $this->selectContactById($this->connection->lastInsertId());

        return $result;
    }

    
}
