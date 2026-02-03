<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="category-section">
  <h1>Categorías</h1>
  <p>Explora nuestro catálogo por tipo de producto.</p>

  <div class="category-grid">
    <?php foreach ($categories as $c): ?>
      <a class="category-card" href="index.php?controller=category&action=show&slug=<?php echo urlencode($c['slug']); ?>">
        <div class="category-thumb">
          <img src="public/img/categoria-generica.png" alt="<?php echo htmlspecialchars($c['name']); ?>">
        </div>
        <h2><?php echo htmlspecialchars($c['name']); ?></h2>
        <p>Ver productos de <?php echo htmlspecialchars($c['name']); ?></p>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
