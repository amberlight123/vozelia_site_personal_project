<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/crypto.php';
class Address {
    public static function byUser($userId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM addresses WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['label'] = rsa_decrypt($row['label_enc']);
            $row['address'] = rsa_decrypt($row['address_enc']);
        }
        return $rows;
    }
    public static function create($userId, $label, $address) {
        $pdo = getConnection();
        $labelEnc = rsa_encrypt($label);
        $addressEnc = rsa_encrypt($address);
        $stmt = $pdo->prepare('INSERT INTO addresses (user_id, label_enc, address_enc) VALUES (?, ?, ?)');
        $stmt->execute([$userId, $labelEnc, $addressEnc]);
    }
    public static function delete($id, $userId) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('DELETE FROM addresses WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }
}
