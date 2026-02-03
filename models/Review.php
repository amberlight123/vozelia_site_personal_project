<?php
require_once __DIR__ . '/../config/db.php';
class Review {
    public static function create($userId, $productId, $rating, $comment) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $productId, $rating, $comment]);
    }
    public static function byProduct($productId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT r.*, u.name FROM reviews r INNER JOIN users u ON r.user_id = u.id WHERE product_id = ? ORDER BY created_at DESC');
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }
}
