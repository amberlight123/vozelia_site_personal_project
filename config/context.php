<?php
/**
 * PILAR 4 (Contexto): Aquí se “amarra” el sistema a un negocio real.
 * - Usuario real: supervisor/a de operaciones / soporte de un call center que usa trunk SIP.
 * - Métrica económica: ingresos en riesgo por llamadas fallidas + leads perdidos por tardanza.
 * - Presión: SLA de respuesta a lead y salud del trunk (errores/latencia).
 */
return [
    'business' => [
        'name' => 'Vozelia – Proveedor de Trunk SIP para Call Centers (Panamá)'
    ],
    'primary_user' => [
        'persona' => 'Supervisor/a de Operaciones (NOC/Soporte)'
    ],
    'economic_success' => [
        // Ajusta a tu realidad. Estos números fuerzan decisiones.
        'usd_per_lost_lead' => 150.0,
        'usd_per_failed_call' => 0.05,
        'usd_per_minute_downtime' => 25.0,
    ],
    'sla' => [
        'lead_first_response_minutes' => 15,
        'lead_high_priority_minutes' => 5,
        'quote_compute_p95_ms' => 200,
        'db_p95_ms' => 150,
        'error_rate_threshold' => 0.02,
    ],
    'ops' => [
        'timezone' => 'America/Panama',
        'status_page_title' => 'Estado Operativo',
    ],
    'chaos' => [
        // Para PILAR 1: simula fallos a propósito.
        'enabled' => getenv('CHAOS_MODE') ? true : false,
        'db_fail' => getenv('CHAOS_DB_FAIL') === '1',
        'db_latency_ms' => (int)(getenv('CHAOS_DB_LATENCY_MS') ?: 0),
        'http_fail_rate' => (float)(getenv('CHAOS_HTTP_FAIL_RATE') ?: 0.0),
    ],
];
