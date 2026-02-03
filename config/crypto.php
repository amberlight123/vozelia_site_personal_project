<?php

/**
 * Nota operativa:
 * - NO guardes private.pem en el repo.
 * - En producción, entrega rutas vía ENV:
 *   CRYPTO_PUBLIC_KEY_PATH y CRYPTO_PRIVATE_KEY_PATH
 */

function crypto_public_key_path(): string {
    $p = getenv('CRYPTO_PUBLIC_KEY_PATH');
    if ($p && file_exists($p)) {
        return $p;
    }
    $fallback = __DIR__ . '/keys/public.pem';
    if (file_exists($fallback)) {
        return $fallback;
    }
    $example = __DIR__ . '/keys/public.pem.example';
    return $example;
}

function crypto_private_key_path(): string {
    $p = getenv('CRYPTO_PRIVATE_KEY_PATH');
    if ($p && file_exists($p)) {
        return $p;
    }
    $fallback = __DIR__ . '/keys/private.pem';
    if (file_exists($fallback)) {
        return $fallback;
    }
    $example = __DIR__ . '/keys/private.pem.example';
    return $example;
}

function rsa_encrypt($plaintext) {
    if ($plaintext === null || $plaintext === '') {
        return null;
    }
    $publicPath = crypto_public_key_path();
    if (!file_exists($publicPath)) {
        return null;
    }
    $publicKey = file_get_contents($publicPath);
    $encrypted = null;
    openssl_public_encrypt($plaintext, $encrypted, $publicKey);
    return $encrypted ? base64_encode($encrypted) : null;
}

function rsa_decrypt($ciphertext) {
    if ($ciphertext === null || $ciphertext === '') {
        return null;
    }
    $privatePath = crypto_private_key_path();
    if (!file_exists($privatePath)) {
        return null;
    }
    $privateKey = file_get_contents($privatePath);
    $decoded = base64_decode($ciphertext);
    $decrypted = null;
    openssl_private_decrypt($decoded, $decrypted, $privateKey);
    return $decrypted;
}
