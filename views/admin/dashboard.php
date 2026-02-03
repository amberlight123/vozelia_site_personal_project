<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section admin-page">
  <h1>Panel de administración</h1>
  <p class="muted">Panel de Acceso a funciones Administrativas</p>

  <div class="admin-links">
    <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
  </div>

  <?php
    $now = new DateTime('now');
    $breaches = 0;
    foreach ($leads as $l) {
      if (!empty($l['first_response_at'])) continue;
      if (empty($l['first_response_due_at'])) continue;
      try {
        $due = new DateTime($l['first_response_due_at']);
        if ($now > $due) $breaches++;
      } catch (Throwable $e) {}
    }
  ?>

  <div class="grid admin-tiles">
    <a class="card hover-lift admin-tile" href="index.php?controller=admin&action=leads">
      <div class="k">Presión</div>
      <div class="h">Leads & SLA</div>
      <p><?= $breaches > 0 ? ('<strong>' . (int)$breaches . '</strong> SLA vencidos (dinero en riesgo).') : 'Sin SLA vencidos en este momento.' ?></p>
    </a>

    <a class="card hover-lift admin-tile" href="index.php?controller=admin&action=products">
      <div class="k">Catálogo</div>
      <div class="h">Productos</div>
      <p>Crear, editar y organizar el catálogo.</p>
    </a>

    <a class="card hover-lift admin-tile" href="index.php?controller=admin&action=orders">
      <div class="k">Operaciones</div>
      <div class="h">Pedidos</div>
      <p>Revisar pedidos recientes y su estado.</p>
    </a>

    <a class="card hover-lift admin-tile" href="index.php?controller=admin&action=users">
      <div class="k">Accesos</div>
      <div class="h">Usuarios</div>
      <p>Ver usuarios registrados y sus roles.</p>
    </a>
  </div>

  <h2>Últimos pedidos</h2>

  <div class="admin-table">
    <?php if (empty($orders)): ?>
      <div class="empty-state"><p>No hay pedidos registrados.</p></div>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
            <tr>
              <td><?= (int)$o['id']; ?></td>
              <td><?= htmlspecialchars($o['customer_name']); ?></td>
              <td><?= htmlspecialchars($o['created_at']); ?></td>
              <td>B/. <?= number_format((float)$o['total'], 2); ?></td>
              <td><?= htmlspecialchars($o['status']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
