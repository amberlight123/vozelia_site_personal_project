<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section user-page">
  <h1>Direcciones de envío</h1>

  <div class="profile-actions">
    <a class="btn-secondary" href="index.php?controller=user&action=profile">Volver a mi perfil</a>
  </div>

  <?php if (empty($addresses)): ?>
    <p class="subtle">No tienes direcciones guardadas.</p>
  <?php else: ?>
    <div class="address-list">
      <?php foreach ($addresses as $addr): ?>
        <div class="address-item">
          <div class="title"><?php echo htmlspecialchars($addr['label'] ?? 'Dirección'); ?></div>
          <div class="meta"><?php echo nl2br(htmlspecialchars($addr['address'] ?? '')); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <h2 style="margin-top:1.4rem;">Agregar nueva dirección</h2>

  <div class="profile-card">
    <form method="post" action="index.php?controller=user&action=addresses">
      <div class="profile-grid">

        <div class="profile-field">
          <label for="label">Etiqueta</label>
          <input id="label" type="text" name="label" placeholder="Casa, Trabajo" required>
        </div>

        <div class="profile-field">
          <label for="address">Dirección</label>
          <textarea id="address" name="address" required></textarea>
        </div>

      </div>

      <div class="profile-actions">
        <button class="btn-primary" type="submit">Guardar dirección</button>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
