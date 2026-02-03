<?php
require_once __DIR__ . '/../config/db.php';
class Subscription {
    public static function create($email) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO subscriptions (email) VALUES (?)');
        $stmt->execute([$email]);
    }
}
