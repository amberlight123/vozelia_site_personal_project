<?php
// Ejecuta: php scripts/generate_fake_ops_data.php
require_once __DIR__ . '/../config/config.php';

$pdo = getConnection();

// Asegura que existan tablas (si importaste database.sql)
$has = (bool)$pdo->query("SHOW TABLES LIKE 'metric_points'")->fetchColumn();
if (!$has) {
    echo "No existe metric_points. Importa database.sql primero.\n";
    exit(1);
}

$now = time();
for ($i = 60; $i >=0; $i--){
    $ts = $now - ($i*60);
    $dt = gmdate('Y-m-d H:i:s', $ts);

    // Dataset fake pero coherente: hora pico -> más llamadas -> más latencia -> algunos errores
    $base = 80 + (int)(30 * sin(($ts/60) / 10.0));
    $jitter = random_int(-8, 8);
    $calls = max(0, $base + $jitter);

    $p95 = 120 + (int)(0.8 * $calls) + random_int(-20, 20);
    $errorRate = max(0, min(0.08, ($calls > 110 ? 0.03 : 0.01) + (random_int(-5, 5)/1000)));

    // Inserta métricas
    $stmt = $pdo->prepare('INSERT INTO metric_points (ts, name, value, tags_json, request_id) VALUES (?, ?, ?, ?, ?)');

    $stmt->execute([$dt, 'sip_calls_per_min', (float)$calls, json_encode(['stream' => 'sip'], JSON_UNESCAPED_UNICODE), 'seed']);
    $stmt->execute([$dt, 'sip_p95_ms', (float)$p95, json_encode(['stream' => 'sip'], JSON_UNESCAPED_UNICODE), 'seed']);
    $stmt->execute([$dt, 'sip_error_rate', (float)$errorRate, json_encode(['stream' => 'sip'], JSON_UNESCAPED_UNICODE), 'seed']);

    // Cada tanto, simula un “incidente”
    if ($errorRate > 0.025 || $p95 > 260) {
        Obs::alert('SIP_DEGRADED', 'warning', "Degradación SIP detectada (p95={$p95}ms, err=" . round($errorRate*100,2) . "%)", ['ts' => $dt]);
        Obs::event('sip_degraded', 'warning', ['stream' => 'sip'], ['p95_ms' => $p95, 'error_rate' => $errorRate, 'ts' => $dt]);
    }
}

echo "OK: generadas métricas fake de los últimos 60 minutos.\n";
