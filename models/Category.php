<?php
require_once __DIR__ . '/../config/db.php';
class Category {
    public static function all() {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }
    public static function findBySlug($slug) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE slug = ?');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    public static function findById($id) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
