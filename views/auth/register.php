<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="auth-section">
  <h1>Crear cuenta</h1>

  <?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="post" action="index.php?controller=auth&action=register" class="form-card">
    <label>Nombre completo
      <input type="text" name="name" required>
    </label>
    <label>Correo electrónico
      <input type="email" name="email" required>
    </label>
    <label>Teléfono
      <input type="text" name="phone">
    </label>
    <label>Dirección principal
      <textarea name="address"></textarea>
    </label>
    <label>Contraseña
      <input type="password" name="password" required>
    </label>
    <button class="btn" type="submit">Registrarse</button>
  </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
