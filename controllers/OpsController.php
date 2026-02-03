<?php

class OpsController
{
    private function ensureAdmin(): void
    {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        if (!is_admin()) {
            http_response_code(403);
            require __DIR__ . '/../views/errors/403.php';
            exit;
        }
    }

    private function flash(string $type, string $msg): void
    {
        $_SESSION['ops_flash'] = ['type' => $type, 'msg' => $msg];
    }

    public function status(): void
    {
        $this->ensureAdmin();

        $ctx = ctx();
        $title = $ctx['ops']['status_page_title'] ?? 'Estado Operativo';

        $windowMinutes = 30;
        $now = time();
        $sinceTs = $now - ($windowMinutes * 60);

        $httpMs = [];
        $reqTotal = 0;
        $errTotal = 0;

        $sipP95 = [];
        $sipErr = [];
        $sipCalls = [];

        $alerts = [];
        $events = [];

        $usedDb = false;

        try {
            $pdo = getConnection();
            $hasMetrics = (bool)$pdo->query("SHOW TABLES LIKE 'metric_points'")->fetchColumn();
            $hasAlerts  = (bool)$pdo->query("SHOW TABLES LIKE 'alerts'")->fetchColumn();
            $hasEvents  = (bool)$pdo->query("SHOW TABLES LIKE 'events'")->fetchColumn();

            if ($hasMetrics && $hasAlerts && $hasEvents) {
                $usedDb = true;

                $wanted = "('http_request_ms','http_requests_total','http_errors_total','sip_p95_ms','sip_error_rate','sip_calls_per_min')";
                $stmt = $pdo->prepare("SELECT ts, name, value FROM metric_points WHERE ts >= ? AND name IN $wanted");
                $stmt->execute([gmdate('Y-m-d H:i:s', $sinceTs)]);
                while ($row = $stmt->fetch()) {
                    $name = $row['name'];
                    $val = (float)$row['value'];
                    if ($name === 'http_request_ms') $httpMs[] = $val;
                    elseif ($name === 'http_requests_total') $reqTotal += (int)$val;
                    elseif ($name === 'http_errors_total') $errTotal += (int)$val;
                    elseif ($name === 'sip_p95_ms') $sipP95[] = $val;
                    elseif ($name === 'sip_error_rate') $sipErr[] = $val;
                    elseif ($name === 'sip_calls_per_min') $sipCalls[] = $val;
                }

                $stmtA = $pdo->prepare('SELECT ts, severity, code, message FROM alerts ORDER BY ts DESC LIMIT 25');
                $stmtA->execute();
                $alerts = $stmtA->fetchAll();

                $stmtE = $pdo->prepare("SELECT ts, level, name, payload_json FROM events WHERE ts >= ? AND level IN ('warning','error') ORDER BY ts DESC LIMIT 50");
                $stmtE->execute([gmdate('Y-m-d H:i:s', $sinceTs)]);
                $events = $stmtE->fetchAll();
            }
        } catch (Throwable $e) {
            $usedDb = false;
        }

        if (!$usedDb) {
            $metrics = Obs::tail('metrics.ndjson', 2500);
            foreach ($metrics as $m) {
                $ts = strtotime($m['ts'] ?? '') ?: 0;
                if ($ts < $sinceTs) continue;

                $name = $m['name'] ?? '';
                $val = (float)($m['value'] ?? 0);

                if ($name === 'http_request_ms') $httpMs[] = $val;
                elseif ($name === 'http_requests_total') $reqTotal += (int)$val;
                elseif ($name === 'http_errors_total') $errTotal += (int)$val;
                elseif ($name === 'sip_p95_ms') $sipP95[] = $val;
                elseif ($name === 'sip_error_rate') $sipErr[] = $val;
                elseif ($name === 'sip_calls_per_min') $sipCalls[] = $val;
            }
            $alerts = array_reverse(Obs::tail('alerts.ndjson', 50));
            $events = array_reverse(Obs::tail('events.ndjson', 200));
        }

        sort($httpMs);
        $p50 = self::percentile($httpMs, 50);
        $p95 = self::percentile($httpMs, 95);
        $errorRate = $reqTotal > 0 ? ($errTotal / $reqTotal) : 0.0;

        sort($sipP95);
        $sipP95p95 = self::percentile($sipP95, 95);
        $sipErrAvg = self::avg($sipErr);
        $sipCallsAvg = self::avg($sipCalls);

        // Umbrales (presión)
        $thresholdErr     = (float)($ctx['sla']['error_rate_threshold'] ?? 0.02);
        $thresholdHttpP95 = (float)($ctx['sla']['quote_compute_p95_ms'] ?? 200);
        $thresholdSipP95  = 260.0;

        // Razones (para admin con mínimo conocimiento)
        $issues = [];
        if ($reqTotal > 0 && $errorRate >= $thresholdErr) {
            $issues[] = "Errores Web: " . round($errorRate * 100, 2) . "% ≥ " . round($thresholdErr * 100, 2) . "%";
        }
        if ($p95 >= $thresholdHttpP95) {
            $issues[] = "Latencia HTTP P95: " . round($p95, 1) . "ms ≥ " . round($thresholdHttpP95, 1) . "ms";
        }
        if ($sipCallsAvg > 0 && $sipErrAvg >= $thresholdErr) {
            $issues[] = "Error SIP (avg): " . round($sipErrAvg * 100, 2) . "% ≥ " . round($thresholdErr * 100, 2) . "%";
        }
        if ($sipP95p95 >= $thresholdSipP95) {
            $issues[] = "Latencia SIP P95: " . round($sipP95p95, 1) . "ms ≥ " . round($thresholdSipP95, 1) . "ms";
        }

        // 3 estados bien puestos:
        // - Buen Estado (verde)
        // - Atención (amarillo) = al menos 1 umbral roto
        // - Crítico (rojo) = severo o múltiples umbrales
        $breaches = count($issues);
        $severe = (
            $errorRate >= ($thresholdErr * 2) ||
            $sipErrAvg >= ($thresholdErr * 2) ||
            $p95 >= ($thresholdHttpP95 * 1.5) ||
            $sipP95p95 >= ($thresholdSipP95 * 1.25)
        );

        $stateKey = 'ok';
        if ($breaches >= 1) $stateKey = 'attention';
        if ($severe || $breaches >= 2) $stateKey = 'critical';

        $state = [
            'key' => $stateKey,
            'label' => ($stateKey === 'ok' ? 'Buen Estado' : ($stateKey === 'attention' ? 'Atención' : 'Crítico')),
            'badge' => ($stateKey === 'ok' ? 'ops-badge--ok' : ($stateKey === 'attention' ? 'ops-badge--warn' : 'ops-badge--danger')),
        ];

        require __DIR__ . '/../views/ops/status.php';
    }

    public function health(): void
    {
        $this->ensureAdmin();

        header('Content-Type: application/json; charset=utf-8');
        $ctx = ctx();

        $payload = [
            'service' => $ctx['business']['name'] ?? 'Vozelia',
            'request_id' => Obs::requestId(),
            'time_utc' => gmdate('c'),
            'status' => 'operational',
        ];

        try {
            $pdo = getConnection();
            $pdo->query('SELECT 1')->fetchColumn();
        } catch (Throwable $e) {
            $payload['status'] = 'degraded';
            $payload['db'] = 'down';
        }

        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    }

    // Botón en UI: Genera dataset SIP (sin consola)
    public function seedSip(): void
    {
        $this->ensureAdmin();
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            redirect('index.php?controller=ops&action=status');
        }

        try {
            $pdo = getConnection();
            $has = (bool)$pdo->query("SHOW TABLES LIKE 'metric_points'")->fetchColumn();
            if (!$has) {
                $this->flash('warning', 'No existe metric_points. Importa database.sql primero.');
                redirect('index.php?controller=ops&action=status');
            }

            // Limpia SIP reciente (para no duplicar)
            $cut = gmdate('Y-m-d H:i:s', time() - 7200);
            $pdo->prepare("DELETE FROM metric_points WHERE ts >= ? AND name IN ('sip_calls_per_min','sip_p95_ms','sip_error_rate')")
                ->execute([$cut]);

            $now = time();
            $stmt = $pdo->prepare('INSERT INTO metric_points (ts, name, value, tags_json, request_id) VALUES (?, ?, ?, ?, ?)');

            for ($i = 60; $i >= 0; $i--) {
                $ts = $now - ($i * 60);
                $dt = gmdate('Y-m-d H:i:s', $ts);

                $base = 80 + (int)(30 * sin(($ts / 60) / 10.0));
                $jitter = random_int(-8, 8);
                $calls = max(0, $base + $jitter);

                $p95 = 120 + (int)(0.8 * $calls) + random_int(-20, 20);
                $errorRate = max(0, min(0.08, ($calls > 110 ? 0.03 : 0.01) + (random_int(-5, 5) / 1000)));

                $tags = json_encode(['stream' => 'sip'], JSON_UNESCAPED_UNICODE);

                $stmt->execute([$dt, 'sip_calls_per_min', (float)$calls, $tags, 'seed']);
                $stmt->execute([$dt, 'sip_p95_ms', (float)$p95, $tags, 'seed']);
                $stmt->execute([$dt, 'sip_error_rate', (float)$errorRate, $tags, 'seed']);

                if ($errorRate > 0.025 || $p95 > 260) {
                    Obs::alert('SIP_DEGRADED', 'warning', "Degradación SIP (p95={$p95}ms, err=" . round($errorRate * 100, 2) . "%)", ['ts' => $dt]);
                    Obs::event('sip_degraded', 'warning', ['stream' => 'sip'], ['p95_ms' => $p95, 'error_rate' => $errorRate, 'ts' => $dt]);
                }
            }

            $this->flash('success', 'Dataset SIP generado (últimos 60 minutos).');
        } catch (Throwable $e) {
            $this->flash('warning', 'No se pudo generar el dataset SIP. Revisa conexión DB.');
        }

        redirect('index.php?controller=ops&action=status');
    }

    // Botón: dispara alerta + evento de prueba (verifica que “estás mirando”)
    public function testAlert(): void
    {
        $this->ensureAdmin();
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            redirect('index.php?controller=ops&action=status');
        }

        Obs::alert('OPS_TEST', 'warning', 'Alerta de prueba generada desde el panel', ['actor' => 'admin']);
        Obs::event('ops_test_alert', 'warning', ['panel' => 'ops'], ['note' => 'Validación de pipeline de alertas']);
        $this->flash('success', 'Alerta de prueba enviada. Debe aparecer en “Alertas recientes”.');

        redirect('index.php?controller=ops&action=status');
    }

    // Botón: limpia DB + archivos (reset de tablero)
    public function reset(): void
    {
        $this->ensureAdmin();
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            redirect('index.php?controller=ops&action=status');
        }

        try {
            $pdo = getConnection();
            $pdo->exec("DELETE FROM metric_points");
            $pdo->exec("DELETE FROM alerts");
            $pdo->exec("DELETE FROM events");
        } catch (Throwable $e) {
            // ok: puede no haber DB
        }

        @file_put_contents(__DIR__ . '/../storage/metrics.ndjson', '');
        @file_put_contents(__DIR__ . '/../storage/alerts.ndjson', '');
        @file_put_contents(__DIR__ . '/../storage/events.ndjson', '');

        $this->flash('success', 'Reset aplicado: métricas/alertas/timeline limpiados.');
        redirect('index.php?controller=ops&action=status');
    }

    private static function percentile(array $sortedValues, int $p): float
    {
        if (empty($sortedValues)) return 0.0;
        $n = count($sortedValues);
        $rank = ($p / 100) * ($n - 1);
        $lo = (int)floor($rank);
        $hi = (int)ceil($rank);
        if ($lo === $hi) return (float)$sortedValues[$lo];
        $w = $rank - $lo;
        return (1.0 - $w) * (float)$sortedValues[$lo] + $w * (float)$sortedValues[$hi];
    }

    private static function avg(array $values): float
    {
        if (empty($values)) return 0.0;
        $sum = 0.0;
        foreach ($values as $v) $sum += (float)$v;
        return $sum / count($values);
    }
}
