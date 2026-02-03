<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Pedidos</h1>
<p class="muted">Tablas de Cada Pedido, Actualizado</p>
  <div class="admin-links">
    <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
  </div>

  <?php if (empty($orders)): ?>
    <div class="empty-state">
      <p>No hay pedidos registrados.</p>
    </div>
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
            <td><?php echo (int)$o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($o['created_at']); ?></td>
            <td>B/. <?php echo number_format($o['total'], 2); ?></td>
            <td><?php echo htmlspecialchars($o['status']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
