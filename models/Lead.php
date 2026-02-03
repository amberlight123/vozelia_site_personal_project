<?php
require_once __DIR__ . '/../config/db.php';

class Lead
{
    /**
     * PILAR 2 (Datos): el dato existe para tomar decisiones.
     * Aquí convertimos el formulario de contacto en un “ticket/lead” con:
     * - prioridad
     * - estimación económica
     * - SLA de primera respuesta
     */
    public static function create(array $data): array
    {
        $pdo = getConnection();

        $channels = isset($data['concurrent_channels']) ? (int)$data['concurrent_channels'] : 0;
        $extensions = isset($data['extensions']) ? (int)$data['extensions'] : 0;

        // Decisión #1: prioridad
        $priority = 'media';
        if ($channels >= 20 || $extensions >= 100) {
            $priority = 'alta';
        } elseif ($channels > 0 || $extensions > 0) {
            $priority = 'media';
        } else {
            $priority = 'baja';
        }

        // Decisión #2: estimación económica (fake pero coherente)
        // Regla simple: canales + extras.
        $estMonthly = ($channels * 20.0) + ($extensions * 0.25);
        if (!empty($data['pbx'])) {
            $estMonthly += 49.0;
        }

        // Decisión #3: SLA de primera respuesta (presión)
        $ctx = function_exists('ctx') ? ctx() : [];
        $mins = (int)($ctx['sla']['lead_first_response_minutes'] ?? 15);
        $minsHigh = (int)($ctx['sla']['lead_high_priority_minutes'] ?? 5);
        $slaMins = ($priority === 'alta') ? $minsHigh : $mins;
        $dueAt = (new DateTime('now', new DateTimeZone($ctx['ops']['timezone'] ?? 'UTC')))
            ->modify('+' . $slaMins . ' minutes')
            ->format('Y-m-d H:i:s');

        $stmt = $pdo->prepare(
            'INSERT INTO leads (name, email, phone, company, service, pbx, extensions, concurrent_channels, destinations, subject, message, priority, est_monthly_usd, first_response_due_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );

        $stmt->execute([
            $data['name'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['service'] ?? null,
            $data['pbx'] ?? null,
            $extensions ?: null,
            $channels ?: null,
            $data['destinations'] ?? null,
            $data['subject'] ?? null,
            $data['message'] ?? null,
            $priority,
            $estMonthly,
            $dueAt,
        ]);

        $id = (int)$pdo->lastInsertId();
        $result = ['id' => $id, 'priority' => $priority, 'est_monthly_usd' => $estMonthly, 'due_at' => $dueAt];

        if (class_exists('Obs')) {
            Obs::event('lead_created', 'info', ['priority' => $priority], [
                'channels' => $channels,
                'extensions' => $extensions,
                'est_monthly_usd' => $estMonthly,
                'due_at' => $dueAt,
            ]);
        }

        return $result;
    }

    public static function all(): array
    {
        $pdo = getConnection();
        $stmt = $pdo->query('SELECT * FROM leads ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function markFirstResponse(int $id): void
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE leads SET first_response_at = NOW(), status = 'en_proceso' WHERE id = ?");
        $stmt->execute([$id]);

        if (class_exists('Obs')) {
            Obs::event('lead_first_response', 'info', ['lead_id' => (string)$id]);
        }
    }
}
