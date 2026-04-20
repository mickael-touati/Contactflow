<?php

namespace App\Managers;

use App\Core\Database;
use PDO;

class ContactManager extends Database {

    public function addContact($nom, $prenom, $email, $phone, $favoris, $userId) {

        $sql = "INSERT INTO contacts (nom, prenom, email, phone, favoris, user_id)
                VALUES (:nom, :prenom, :email, :phone, :favoris, :user_id)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "phone" => $phone,
            "favoris" => $favoris,
            "user_id" => $userId
        ]);
    }

    public function getContactById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchContacts($userId, $keyword) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM contacts
            WHERE user_id = :user_id
            AND (nom LIKE :k OR prenom LIKE :k OR email LIKE :k)
            LIMIT 10
        ");

        $stmt->execute([
            "user_id" => $userId,
            "k" => "%$keyword%"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContactsPaginated($userId, $limit, $offset) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM contacts
            WHERE user_id = :user_id
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateContact($id, $nom, $prenom, $email, $phone, $favoris) {

        $stmt = $this->pdo->prepare("
            UPDATE contacts
            SET nom=:nom, prenom=:prenom, email=:email, phone=:phone, favoris=:favoris
            WHERE id=:id
        ");

        return $stmt->execute([
            "id" => $id,
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "phone" => $phone,
            "favoris" => $favoris
        ]);
    }

    public function deleteContact($id) {
        $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE id = :id");
        return $stmt->execute(["id" => $id]);
    }
}