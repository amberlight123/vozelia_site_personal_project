<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Mis pedidos</h1>

  <?php if (empty($orders)): ?>
    <div class="empty-state">
      <p>Aún no tienes pedidos registrados.</p>
      <p style="margin-top:.6rem;">
        Cuando realices una compra, podrás ver aquí el historial y estado de tus pedidos.
      </p>
    </div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Total</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
          <tr>
            <td><?php echo (int)$o['id']; ?></td>
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
