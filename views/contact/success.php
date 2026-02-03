<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-head">
  <h1>Solicitud recibida</h1>
  <p>Gracias. Recibimos tu solicitud y te responderemos lo antes posible con una propuesta.</p>

  <?php if (isset($lead) && is_array($lead)): ?>
    <div class="card" style="margin-top:14px;">
      <h3>Compromiso de respuesta (SLA)</h3>
      <p><strong>Te contactaremos antes de:</strong> <?= htmlspecialchars($lead['due_at'] ?? '') ?></p>
      <p class="muted">Prioridad: <?= htmlspecialchars(strtoupper($lead['priority'] ?? '')) ?> · Estimación referencial: USD <?= number_format((float)($lead['est_monthly_usd'] ?? 0), 2) ?>/mes</p>
      <p class="muted">Ref: <code><?= htmlspecialchars(Obs::requestId()) ?></code></p>
    </div>
  <?php endif; ?>
</section>

<div class="actions-row">
  <a class="btn" href="index.php?controller=pages&action=home">Volver al inicio</a>
  <a class="btn-secondary" href="index.php?controller=pages&action=tarifas">Ver tarifas</a>
  <a class="btn-secondary" href="index.php?controller=ops&action=status">Estado operativo</a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
