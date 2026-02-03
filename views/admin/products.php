<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Administrar productos</h1>
<p class="muted">Tablas de Cada Producto, Actualizado</p>
  <div class="admin-links">
    <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
  </div>

  <p>
    <a class="btn" href="index.php?controller=admin&action=productForm">Nuevo producto</a>
  </p>

  <div style="overflow-x:auto;-webkit-overflow-scrolling:touch">
  <table class="table" style="min-width:760px">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Activo</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?php echo (int)$p['id']; ?></td>
          <td><?php echo htmlspecialchars($p['name']); ?></td>
          <td><?php echo htmlspecialchars($p['category_name']); ?></td>
          <td>B/. <?php echo number_format($p['price'], 2); ?></td>
          <td><?php echo (int)$p['stock']; ?></td>
          <td><?php echo $p['is_active'] ? 'Sí' : 'No'; ?></td>
          <td>
            <a href="index.php?controller=admin&action=productForm&id=<?php echo (int)$p['id']; ?>">Editar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
