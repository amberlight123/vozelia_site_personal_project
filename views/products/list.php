<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Catálogo de productos</h1>

  <div class="grid">
    <?php foreach ($products as $p): ?>
      <div class="card">
        <img src="public/img/<?php echo htmlspecialchars($p['image'] ?: 'placeholder.png'); ?>" alt="">
        <h2><?php echo htmlspecialchars($p['name']); ?></h2>
        <p class="price">B/. <?php echo number_format($p['price'], 2); ?></p>
        <p class="category"><?php echo htmlspecialchars($p['category_name'] ?? ''); ?></p>
        <a class="btn" href="index.php?controller=product&action=detail&slug=<?php echo urlencode($p['slug']); ?>">Ver detalle</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
