<?php
require_once __DIR__ . '/../config/db.php';
class Product {
    public static function allActive() {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id WHERE p.is_active = 1 ORDER BY p.created_at DESC');
        return $stmt->fetchAll();
    }
    public static function findBySlug($slug) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id WHERE p.slug = ? AND p.is_active = 1');
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }
    public static function findById($id) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? AND is_active = 1');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public static function byCategoryId($categoryId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM products WHERE category_id = ? AND is_active = 1 ORDER BY created_at DESC');
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }
    public static function search($term) {
        $pdo = getConnection();
        $like = '%' . $term . '%';
        $stmt = $pdo->prepare('SELECT * FROM products WHERE is_active = 1 AND (name LIKE ? OR description LIKE ?) ORDER BY created_at DESC');
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }
    public static function allAdmin() {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC');
        return $stmt->fetchAll();
    }
    public static function create($data) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO products (category_id, name, slug, description, price, stock, image, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image'],
            $data['is_active']
        ]);
        return $pdo->lastInsertId();
    }
    public static function update($id, $data) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('UPDATE products SET category_id = ?, name = ?, slug = ?, description = ?, price = ?, stock = ?, image = ?, is_active = ? WHERE id = ?');
        return $stmt->execute([
            $data['category_id'],
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['image'],
            $data['is_active'],
            $id
        ]);
    }
    public static function delete($id) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
