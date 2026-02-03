<?php

/**
 * PILAR 3 (Observabilidad): eventos, métricas y alertas.
 * Implementación minimalista (sin vendor) con fallback a archivo.
 */

class Obs
{
    private static ?array $ctx = null;
    private static ?string $reqId = null;
    private static float $reqStart = 0.0;
    private static bool $dbTablesChecked = false;
    private static bool $dbTablesAvailable = false;

    public static function init(array $ctx): void
    {
        self::$ctx = $ctx;
        self::$reqStart = microtime(true);
        self::$reqId = bin2hex(random_bytes(8));
        header('X-Request-Id: ' . self::$reqId);
    }

    public static function ctx(): array
    {
        return self::$ctx ?? [];
    }

    public static function requestId(): string
    {
        return self::$reqId ?? 'unknown';
    }

    public static function requestStart(): float
    {
        return self::$reqStart;
    }

    public static function event(string $name, string $level = 'info', array $tags = [], array $payload = []): void
    {
        $row = [
            'ts' => gmdate('c'),
            'level' => $level,
            'name' => $name,
            'request_id' => self::requestId(),
            'tags' => $tags,
            'payload' => $payload,
        ];

        // Intento 1: DB (si existe tabla events)
        if (self::dbAvailable()) {
            try {
                $pdo = getConnection();
                $stmt = $pdo->prepare('INSERT INTO events (ts, level, name, request_id, tags_json, payload_json) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([
                    gmdate('Y-m-d H:i:s'),
                    $level,
                    $name,
                    self::requestId(),
                    json_encode($tags, JSON_UNESCAPED_UNICODE),
                    json_encode($payload, JSON_UNESCAPED_UNICODE),
                ]);
                return;
            } catch (Throwable $e) {
                // Si falla DB, cae a archivo.
            }
        }

        self::appendFile('events.ndjson', $row);
    }

    public static function metric(string $name, float $value, array $tags = []): void
    {
        $row = [
            'ts' => gmdate('c'),
            'name' => $name,
            'value' => $value,
            'request_id' => self::requestId(),
            'tags' => $tags,
        ];

        if (self::dbAvailable()) {
            try {
                $pdo = getConnection();
                $stmt = $pdo->prepare('INSERT INTO metric_points (ts, name, value, tags_json, request_id) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([
                    gmdate('Y-m-d H:i:s'),
                    $name,
                    $value,
                    json_encode($tags, JSON_UNESCAPED_UNICODE),
                    self::requestId(),
                ]);
                return;
            } catch (Throwable $e) {
                // fallback
            }
        }

        self::appendFile('metrics.ndjson', $row);
    }

    public static function alert(string $code, string $severity, string $message, array $tags = []): void
    {
        $row = [
            'ts' => gmdate('c'),
            'code' => $code,
            'severity' => $severity, // info|warning|critical
            'message' => $message,
            'request_id' => self::requestId(),
            'tags' => $tags,
        ];

        if (self::dbAvailable()) {
            try {
                $pdo = getConnection();
                $stmt = $pdo->prepare('INSERT INTO alerts (ts, severity, code, message, tags_json, request_id) VALUES (?, ?, ?, ?, ?, ?)');
                $stmt->execute([
                    gmdate('Y-m-d H:i:s'),
                    $severity,
                    $code,
                    $message,
                    json_encode($tags, JSON_UNESCAPED_UNICODE),
                    self::requestId(),
                ]);
                return;
            } catch (Throwable $e) {
                // fallback
            }
        }

        self::appendFile('alerts.ndjson', $row);
    }

    public static function httpSummary(string $route, string $method, int $status, float $durationMs): void
    {
        self::metric('http_request_ms', $durationMs, ['route' => $route, 'method' => $method, 'status' => (string)$status]);
        self::metric('http_requests_total', 1, ['route' => $route, 'method' => $method, 'status' => (string)$status]);
        if ($status >= 500) {
            self::metric('http_errors_total', 1, ['route' => $route, 'method' => $method]);
        }
    }

    public static function tail(string $file, int $lines = 200): array
    {
        $path = self::storagePath($file);
        if (!file_exists($path)) {
            return [];
        }
        $data = self::tailFile($path, $lines);
        $rows = [];
        foreach ($data as $line) {
            $json = json_decode($line, true);
            if (is_array($json)) {
                $rows[] = $json;
            }
        }
        return $rows;
    }

    private static function storagePath(string $file): string
    {
        return __DIR__ . '/../storage/' . $file;
    }

    private static function appendFile(string $file, array $row): void
    {
        $path = self::storagePath($file);
        $dir = dirname($path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @file_put_contents($path, json_encode($row, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);
    }

    private static function tailFile(string $filepath, int $lines): array
    {
        $f = fopen($filepath, 'rb');
        if (!$f) {
            return [];
        }
        $buffer = '';
        $pos = -1;
        $lineCount = 0;
        $result = [];

        fseek($f, 0, SEEK_END);
        $filesize = ftell($f);
        if ($filesize === 0) {
            fclose($f);
            return [];
        }

        while ($lineCount < $lines && -$pos <= $filesize) {
            fseek($f, $pos, SEEK_END);
            $char = fgetc($f);
            if ($char === "\n") {
                $lineCount++;
                if ($buffer !== '') {
                    $result[] = strrev(rtrim($buffer, "\n\r"));
                    $buffer = '';
                }
            } else {
                $buffer .= $char;
            }
            $pos--;
        }

        if ($buffer !== '') {
            $result[] = strrev(rtrim($buffer, "\n\r"));
        }

        fclose($f);
        return array_reverse($result);
    }

    private static function dbAvailable(): bool
    {
        if (self::$dbTablesChecked) {
            return self::$dbTablesAvailable;
        }
        self::$dbTablesChecked = true;
        self::$dbTablesAvailable = false;

        // Si el proyecto no tiene DB conectada, no matamos requests.
        try {
            $pdo = getConnection();
            $stmt = $pdo->query("SHOW TABLES LIKE 'events'");
            $hasEvents = (bool)$stmt->fetchColumn();
            $stmt2 = $pdo->query("SHOW TABLES LIKE 'metric_points'");
            $hasMetrics = (bool)$stmt2->fetchColumn();
            $stmt3 = $pdo->query("SHOW TABLES LIKE 'alerts'");
            $hasAlerts = (bool)$stmt3->fetchColumn();
            self::$dbTablesAvailable = ($hasEvents && $hasMetrics && $hasAlerts);
        } catch (Throwable $e) {
            self::$dbTablesAvailable = false;
        }

        return self::$dbTablesAvailable;
    }
}
