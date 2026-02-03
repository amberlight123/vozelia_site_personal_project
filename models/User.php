<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/crypto.php';
class User {
    public static function findById($id) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public static function findByEmail($email) {
        $pdo = getConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public static function create($name, $email, $password, $phone, $address) {
        $pdo = getConnection();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $phoneEnc = rsa_encrypt($phone);
        $addressEnc = rsa_encrypt($address);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, phone_enc, address_enc, role) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $hash, $phoneEnc, $addressEnc, 'customer']);
        return $pdo->lastInsertId();
    }
    public static function updateProfile($id, $name, $phone, $address) {
        $pdo = getConnection();
        $phoneEnc = rsa_encrypt($phone);
        $addressEnc = rsa_encrypt($address);
        $stmt = $pdo->prepare('UPDATE users SET name = ?, phone_enc = ?, address_enc = ? WHERE id = ?');
        return $stmt->execute([$name, $phoneEnc, $addressEnc, $id]);
    }
    public static function all() {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }
}
