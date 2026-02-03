<?php
require_once __DIR__ . '/../config/db.php';

class ContactMessage {
    public static function create($name, $email, $subject, $message) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $subject, $message]);
    }
}
