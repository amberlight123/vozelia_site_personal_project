<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section">
  <div class="page-head">
    <h1>Acceso restringido</h1>
    <p class="muted">Esta sección está disponible únicamente para administradores.</p>
    <div class="actions-row">
      <a class="btn-secondary btn-compact" href="index.php?controller=pages&action=home">Volver al inicio</a>
      <a class="btn btn-compact" href="index.php?controller=admin&action=dashboard">Ir a Admin</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
