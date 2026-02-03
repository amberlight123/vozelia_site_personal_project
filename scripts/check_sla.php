<?php
// Ejecuta: php scripts/check_sla.php
require_once __DIR__ . '/../config/config.php';

$ctx = ctx();
$pdo = getConnection();

// Leads sin primera respuesta y SLA vencido
$stmt = $pdo->query("SELECT id, email, priority, first_response_due_at FROM leads WHERE first_response_at IS NULL AND first_response_due_at IS NOT NULL AND first_response_due_at < NOW() AND status = 'nuevo' ORDER BY first_response_due_at ASC LIMIT 200");
$rows = $stmt->fetchAll();

foreach ($rows as $l) {
    $leadId = (int)$l['id'];

    // Dedupe: no spamear el mismo breach cada minuto
    $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM alerts WHERE code='LEAD_SLA_BREACH' AND message LIKE ? AND ts >= DATE_SUB(NOW(), INTERVAL 30 MINUTE)");
    $stmt2->execute(["%lead_id=$leadId%"]);
    $exists = (int)$stmt2->fetchColumn() > 0;
    if ($exists) {
        continue;
    }

    $msg = "SLA vencido para lead_id=$leadId (priority={$l['priority']}, due={$l['first_response_due_at']})";
    Obs::alert('LEAD_SLA_BREACH', 'critical', $msg, ['lead_id' => (string)$leadId]);
    Obs::event('lead_sla_breached', 'error', ['lead_id' => (string)$leadId, 'priority' => $l['priority']], ['due_at' => $l['first_response_due_at']]);
}

echo "Checked " . count($rows) . " lead(s).\n";
