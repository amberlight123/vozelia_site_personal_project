<?php
require_once __DIR__ . '/../config/db.php';
class OrderItem {
    public static function create($orderId, $productId, $quantity, $unitPrice, $subtotal) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$orderId, $productId, $quantity, $unitPrice, $subtotal]);
    }
    public static function byOrder($orderId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT oi.*, p.name FROM order_items oi INNER JOIN products p ON oi.product_id = p.id WHERE order_id = ?');
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
