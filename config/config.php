<?php

// ----------
// Boot básico
// ----------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('BASE_URL', '');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/crypto.php';

// ----------
// PILAR 4: Contexto del sistema
// ----------
$CTX = require __DIR__ . '/context.php';

// ----------
// PILAR 3: Observabilidad (eventos, métricas, alertas)
// ----------
require_once __DIR__ . '/../lib/Obs.php';
Obs::init($CTX);

// Error/Exception -> observabilidad
set_exception_handler(function (Throwable $e) {
    Obs::event('unhandled_exception', 'error', [], [
        'type' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);
    Obs::alert('UNHANDLED_EXCEPTION', 'critical', 'Excepción no manejada', ['type' => get_class($e)]);

    http_response_code(500);
    echo 'Error interno. Ref: ' . htmlspecialchars(Obs::requestId());
});

set_error_handler(function ($severity, $message, $file, $line) {
    // Respeta @ silencing
    if (!(error_reporting() & $severity)) {
        return false;
    }
    Obs::event('php_error', 'error', ['severity' => (string)$severity], [
        'message' => $message,
        'file' => $file,
        'line' => $line,
    ]);
    // Deja que PHP lo maneje también
    return false;
});

register_shutdown_function(function () {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        Obs::event('fatal_error', 'error', ['type' => (string)$err['type']], $err);
        Obs::alert('FATAL_ERROR', 'critical', 'Fatal error en PHP', ['type' => (string)$err['type']]);
    }

    // Métricas por request (aunque sean fake, te obligan a mirar la realidad)
    $route = $GLOBALS['__route'] ?? 'unknown';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
    $status = http_response_code();
    $durMs = (microtime(true) - Obs::requestStart()) * 1000.0;
    Obs::httpSummary($route, $method, $status, $durMs);
});

// ----------
// Helpers
// ----------
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function is_admin(): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function ctx(): array {
    return Obs::ctx();
}
