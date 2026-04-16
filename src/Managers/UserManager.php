<?php
namespace App\Managers;
use App\Core\Database;
use PDO;

class UserManager extends Database {
    
    public function register($username, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'username' => $username,
            'password' => $hash
        ]);
    }

    public function login($username, $password) {
        $sql = "SELECT id, password FROM user WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }

    public function getUser($id) {
        $sql = "SELECT id, username FROM user WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $username, $password = null) {
        if (!empty($password)) { 
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE user SET username = :username, password = :password WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'username' => $username,
                'password' => $hash
            ]);
        } 
        else {
            $sql = "UPDATE user SET username = :username WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'username' => $username
            ]);
        }
    }
}
?>