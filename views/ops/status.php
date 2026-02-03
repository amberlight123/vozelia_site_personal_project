<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section ops-page">
  <div class="page-head">
    <h1><?= htmlspecialchars($title) ?> — Vozelia</h1>
    <p class="muted">Ventana: últimos <?= (int)$windowMinutes ?> minutos · Ref: <code><?= htmlspecialchars(Obs::requestId()) ?></code></p>

      <div class="admin-links">
      <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
      <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
      <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
      <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
      <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
      <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
      </div>

    <div class="actions-row">
      <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Actualizar</a>
      <a class="btn-outline btn-compact" href="index.php?controller=ops&action=health" target="_blank" rel="noreferrer">Health JSON</a>

      <form method="post" action="index.php?controller=ops&action=seedSip" style="display:inline">
        <button class="btn btn-compact" type="submit">Generar dataset SIP</button>
      </form>

      <form method="post" action="index.php?controller=ops&action=testAlert" style="display:inline">
        <button class="btn-secondary btn-compact" type="submit">Enviar alerta de prueba</button>
      </form>

      <form method="post" action="index.php?controller=ops&action=reset" style="display:inline">
        <button class="btn-outline btn-compact" type="submit">Reset tablero</button>
      </form>
    </div>

    <?php if (!empty($_SESSION['ops_flash'])): ?>
      <?php $f = $_SESSION['ops_flash']; unset($_SESSION['ops_flash']); ?>
      <div class="notice" style="margin-top:1rem;">
        <strong><?= htmlspecialchars(($f['type'] ?? 'info') === 'success' ? 'OK:' : 'Aviso:') ?></strong>
        <?= htmlspecialchars($f['msg'] ?? '') ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="grid ops-grid">
    <div class="card">
      <h3>Estado</h3>
      <div class="ops-status-row">
        <span class="ops-badge <?= htmlspecialchars($state['badge']) ?>"><?= htmlspecialchars($state['label']) ?></span>
        <span class="muted">Lo importante: saber si hay acción que tomar.</span>
      </div>

      <?php if (!empty($issues)): ?>
        <ul class="ops-issues">
          <?php foreach ($issues as $it): ?>
            <li><?= htmlspecialchars($it) ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="muted" style="margin-top:.6rem;">Sin señales de degradación dentro de la ventana.</p>
      <?php endif; ?>

      <?php if ((float)$sipCallsAvg <= 0.0): ?>
        <p class="muted" style="margin-top:.6rem;">
          Nota: no hay tráfico SIP en la ventana. Usa <strong>“Generar dataset SIP”</strong> para ver el tablero en acción.
        </p>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>Latencia Web HTTP</h3>
      <div class="kpis">
        <div><strong>P50:</strong> <?= number_format($p50, 1) ?> ms</div>
        <div><strong>P95:</strong> <?= number_format($p95, 1) ?> ms</div>
      </div>
      <p class="muted">Umbral P95: <?= (float)($ctx['sla']['quote_compute_p95_ms'] ?? 200) ?> ms</p>
    </div>

    <div class="card">
      <h3>Errores Web</h3>
      <div class="kpis">
        <div><strong>Requests:</strong> <?= (int)$reqTotal ?></div>
        <div><strong>Errores:</strong> <?= (int)$errTotal ?></div>
      </div>
      <p class="muted">Error rate: <?= number_format($errorRate * 100, 2) ?>% (umbral <?= number_format(((float)($ctx['sla']['error_rate_threshold'] ?? 0.02))*100, 2) ?>%)</p>
    </div>

    <div class="card">
      <h3>Salud Trunk SIP</h3>
      <div class="kpis">
        <div><strong>Calls/min (avg):</strong> <?= number_format($sipCallsAvg, 1) ?></div>
        <div><strong>P95:</strong> <?= number_format($sipP95p95, 1) ?> ms</div>
      </div>
      <p class="muted">Error rate (avg): <?= number_format($sipErrAvg * 100, 2) ?>%</p>
    </div>
  </div>

  <div class="tabs" data-tabs style="margin-top:1rem;">
    <button class="tab-btn is-active" data-tab="alertas" type="button">Alertas</button>
    <button class="tab-btn" data-tab="timeline" type="button">Timeline</button>
  </div>

  <div class="tab-panel is-active" data-tab-panel="alertas">
    <div class="card">
      <h3>Alertas recientes</h3>
      <?php if (empty($alerts)): ?>
        <p class="muted">Sin alertas en la ventana.</p>
      <?php else: ?>
        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>Tiempo (UTC)</th>
                <th>Severidad</th>
                <th>Código</th>
                <th>Mensaje</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($alerts as $a): ?>
                <?php
                  $sev = strtolower($a['severity'] ?? '');
                  $sevBadge = $sev === 'critical' ? 'ops-badge--danger' : ($sev === 'warning' ? 'ops-badge--warn' : 'ops-badge--ok');
                ?>
                <tr>
                  <td><?= htmlspecialchars($a['ts'] ?? '') ?></td>
                  <td><span class="ops-badge <?= $sevBadge ?>"><?= htmlspecialchars($a['severity'] ?? '') ?></span></td>
                  <td><code><?= htmlspecialchars($a['code'] ?? '') ?></code></td>
                  <td><?= htmlspecialchars($a['message'] ?? '') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="tab-panel" data-tab-panel="timeline">
    <div class="card">
      <h3>Timeline (errores / warnings)</h3>
      <?php if (empty($events)): ?>
        <p class="muted">Sin eventos de error/warning en la ventana.</p>
      <?php else: ?>
        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>Tiempo (UTC)</th>
                <th>Nivel</th>
                <th>Evento</th>
                <th>Detalle</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($events as $e): ?>
                <?php
                  $payload = $e['payload_json'] ?? null;
                  if (is_string($payload)) $payload = json_decode($payload, true);
                  $detail = '';
                  if (is_array($payload)) {
                    if (!empty($payload['message'])) $detail = $payload['message'];
                    elseif (!empty($payload['type'])) $detail = $payload['type'];
                    elseif (!empty($payload['note'])) $detail = $payload['note'];
                  }
                  $lvl = strtolower($e['level'] ?? '');
                  $lvlBadge = $lvl === 'error' ? 'ops-badge--danger' : 'ops-badge--warn';
                ?>
                <tr>
                  <td><?= htmlspecialchars($e['ts'] ?? '') ?></td>
                  <td><span class="ops-badge <?= $lvlBadge ?>"><?= htmlspecialchars($e['level'] ?? '') ?></span></td>
                  <td><code><?= htmlspecialchars($e['name'] ?? '') ?></code></td>
                  <td><?= htmlspecialchars($detail) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
