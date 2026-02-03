<?php

/**
 * PILAR 1 (Código): el DB layer debe RESISTIR.
 * - Config por ENV (operación real)
 * - Simulación de fallos / latencia (chaos)
 * - Métricas de latencia y errores
 */

function getConnection(): PDO {
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    // Chaos: simular caída/latencia del DB (solo si activas env vars)
    $chaosFail = getenv('CHAOS_DB_FAIL') === '1';
    if ($chaosFail) {
        throw new RuntimeException('CHAOS: DB outage simulated');
    }
    $chaosLatencyMs = (int)(getenv('CHAOS_DB_LATENCY_MS') ?: 0);
    if ($chaosLatencyMs > 0) {
        usleep($chaosLatencyMs * 1000);
    }

    $host = getenv('DB_HOST') ?: 'localhost';
    $db = getenv('DB_NAME') ?: 'vozelia';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';
    $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $t0 = microtime(true);
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (Throwable $e) {
        // Si Obs está cargado, registra.
        if (class_exists('Obs')) {
            Obs::event('db_connect_error', 'error', [], ['message' => $e->getMessage()]);
            Obs::alert('DB_CONNECT_ERROR', 'critical', 'No se pudo conectar a DB');
        }
        throw $e;
    } finally {
        $durMs = (microtime(true) - $t0) * 1000.0;
        if (class_exists('Obs')) {
            Obs::metric('db_connect_ms', $durMs);
        }
    }

    return $pdo;
}
