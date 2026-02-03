<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Usuarios</h1>
<p class="muted">Cualquier Usuario, sin importar su rol, aparecerá en la lista.</p>
  <div class="admin-links">
    <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Fecha registro</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?php echo (int)$u['id']; ?></td>
          <td><?php echo htmlspecialchars($u['name']); ?></td>
          <td><?php echo htmlspecialchars($u['email']); ?></td>
          <td><?php echo htmlspecialchars($u['role']); ?></td>
          <td><?php echo htmlspecialchars($u['created_at']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
