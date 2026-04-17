<?php

namespace App\Managers;

use App\Core\Database;
use PDO;

class ContactManager extends Database {


    public function addContact($nom, $prenom, $email, $phone, $favoris, $userId) {
        $sql = "INSERT INTO contacts (nom, prenom, email, phone, favoris, user_id) VALUES (:nom, :prenom, :email, :phone, :favoris, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'phone' => $phone,
            'favoris' => $favoris,
            'user_id' => $userId
        ]);
    }

    public function getContactsByUser($userId) {
        $sql = "SELECT * FROM contacts WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getContactById($id) {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateContact($id, $nom, $prenom, $email, $phone, $favoris) {
        $sql = "UPDATE contacts SET nom = :nom, prenom = :prenom, email = :email, phone = :phone, favoris = :favoris WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'phone' => $phone,
            'favoris' => $favoris
        ]);
    }

    public function deleteContact($id) {
        $sql = "DELETE FROM contacts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function searchContacts($userId, $keyword)
    {
        $sql = "SELECT * FROM contacts 
                WHERE user_id = :user_id 
                AND (
                    nom LIKE :keyword 
                    OR prenom LIKE :keyword 
                    OR email LIKE :keyword
                )
                LIMIT 10";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'keyword' => "%" . $keyword . "%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

public function getContactsPaginated($userId, $limit, $offset)
{
    $sql = "SELECT * FROM contacts 
            WHERE user_id = :user_id
            LIMIT :limit OFFSET :offset";

    $stmt = $this->pdo->prepare($sql);

    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}