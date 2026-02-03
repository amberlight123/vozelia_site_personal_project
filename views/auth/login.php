<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="auth-section">
  <h1>Iniciar sesión</h1>

  <?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="post" action="index.php?controller=auth&action=login" class="form-card">
    <label>Correo electrónico
      <input type="email" name="email" required>
    </label>
    <label>Contraseña
      <input type="password" name="password" required>
    </label>
    <button class="btn" type="submit">Entrar</button>
  </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
