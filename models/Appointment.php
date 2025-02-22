<?php
require_once '../config/database.php';

class Appointment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function bookAppointment($user_id, $date_heure) {
        $stmt = $this->pdo->prepare("INSERT INTO rendezvous (user_id, date_heure) VALUES (?, ?)");
        return $stmt->execute([$user_id, $date_heure]);
    }

    public function getUserAppointments($user_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM rendezvous WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelAppointment($id) {
        $stmt = $this->pdo->prepare("DELETE FROM rendezvous WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
