<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Suscríbete a nuestras ofertas</h1>
<?php if (isset($error)): ?>
<p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post" action="index.php?controller=subscription&action=subscribe" class="form-card">
<label>Correo electrónico
<input type="email" name="email" required>
</label>
<button type="submit">Suscribirme</button>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
