<?php
require_once __DIR__ . '/../config/db.php';
class Order {
    public static function create($userId, $total) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $total, 'pending']);
        return $pdo->lastInsertId();
    }
    public static function byUser($userId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public static function all() {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT o.*, u.name AS user_name FROM orders o INNER JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC');
        return $stmt->fetchAll();
    }
    public static function updateStatus($id, $status) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }
}
