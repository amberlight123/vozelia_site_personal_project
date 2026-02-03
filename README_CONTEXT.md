# Vozelia (versión operacional)

## Usuario real (único)
**Supervisor/a de Operaciones / Soporte de un call center** que depende de un trunk SIP para atender clientes.

## Métrica económica (no técnica)
- **Ingresos en riesgo** cuando sube la tasa de error o la latencia del trunk (llamadas caídas/inaudibles).
- **Leads perdidos** cuando se incumple el SLA de primera respuesta.

## Presión (por qué duele)
- SLA de primera respuesta a lead: 15 min (alta prioridad: 5 min)
- Umbral de error rate: 2%
- Umbral de latencia P95 web: 200 ms
- Umbral de latencia P95 SIP: 260 ms (ajustable)

## Observabilidad
- `events`, `metric_points`, `alerts` en DB (fallback a `storage/*.ndjson`).
- Panel de estado: `/index.php?controller=ops&action=status`
- Health check: `/index.php?controller=ops&action=health`

## Scripts
- Carga: `scripts/simulate_load.sh`
- SLA check: `php scripts/check_sla.php`
- Dataset fake de operación: `php scripts/generate_fake_ops_data.php`

> Si no puedes responder “qué pasó y cuándo”, tu sistema es ciego.
