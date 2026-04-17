<?php
namespace App\Managers;
use App\Core\Database;
use PDO;

class ContactManager extends Database {


    public function addContact($nom, $prenom, $email, $phone, $favoris, $userId) {
        $sql = "INSERT INTO contacts (nom, prenom, email, phone, favoris, user_id) VALUES (:nom, :prenom, :email, :phone, :favoris, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("nom", $nom, PDO::PARAM_INT);
        $stmt->bindValue("prenom", $prenom, PDO::PARAM_INT);
        $stmt->bindValue("email", $email, PDO::PARAM_INT);
        $stmt->bindValue("phone", $phone, PDO::PARAM_INT);
        $stmt->bindValue("favoris", $favoris, PDO::PARAM_INT);
        $stmt->bindValue("user_id", $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getContactsByUser($userId) {
        $sql = "SELECT * FROM contacts WHERE user_id = :user_id ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getContactById($id) {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateContact($id, $nom, $prenom, $email, $phone, $favoris) {
        $sql = "UPDATE contacts SET nom = :nom, prenom = :prenom, email = :email, phone = :phone, favoris = :favoris WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("nom", $nom, PDO::PARAM_INT);
        $stmt->bindValue("prenom", $prenom, PDO::PARAM_INT);
        $stmt->bindValue("email", $email, PDO::PARAM_INT);
        $stmt->bindValue("phone", $phone, PDO::PARAM_INT);
        $stmt->bindValue("favoris", $favoris, PDO::PARAM_INT);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        return $stmt->execute(); }

    public function deleteContact($id) {
        $sql = "DELETE FROM contacts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue("id", $id, PDO::PARAM_INT);
        return $stmt->execute();
        }
}