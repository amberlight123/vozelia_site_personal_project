<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section user-page">
  <h1>Mi perfil</h1>

  <div class="profile-card">
    <form method="post" action="index.php?controller=user&action=updateProfile">
      <div class="profile-grid">

        <div class="profile-field">
          <label for="name">Nombre</label>
          <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
        </div>

        <div class="profile-field">
          <label for="phone">Teléfono</label>
          <input id="phone" type="text" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>

        <div class="profile-field">
          <label for="address">Dirección principal</label>
          <textarea id="address" name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
        </div>

      </div>

      <div class="profile-actions">
        <button class="btn-primary" type="submit">Guardar cambios</button>
        <a class="btn-secondary" href="index.php?controller=user&action=addresses">Direcciones de envío</a>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
