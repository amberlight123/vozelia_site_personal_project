<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="auth-section">
  <h1>Contáctanos</h1>

  <?php if (isset($error)): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="post" action="index.php?controller=contact&action=send" class="form-card">
    <label>Nombre
      <input type="text" name="name" required>
    </label>
    <label>Correo electrónico
      <input type="email" name="email" required>
    </label>
    <label>Asunto
      <input type="text" name="subject">
    </label>
    <label>Mensaje
      <textarea name="message" required></textarea>
    </label>
    <button type="submit">Enviar</button>
  </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
