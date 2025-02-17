<?php
require_once '../config/database.php';

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($nom, $prenom, $date_naissance, $adresse, $telephone, $email, $mot_de_passe) {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (nom, prenom, date_naissance, adresse, telephone, email, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $date_naissance, $adresse, $telephone, $email, $hashed_password]);
    }

    public function login($email, $mot_de_passe) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['prenom'] . " " . $user['nom'];
            return true;
        }
        return false;
    }

    public function deleteAccount($user_id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$user_id]);
    }
}
?>
