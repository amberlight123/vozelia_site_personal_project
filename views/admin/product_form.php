<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section admin-page">
  <div class="page-head">
    <h1><?php echo $product ? 'Editar producto' : 'Nuevo producto'; ?></h1>
  </div>

  <form method="post" action="index.php?controller=admin&action=saveProduct" class="form-card" style="max-width: 900px; margin: 0 auto;">
    <input type="hidden" name="id" value="<?php echo $product['id'] ?? ''; ?>">

    <label>Categoría
      <select name="category_id" required>
        <?php foreach ($categories as $c): ?>
          <option value="<?php echo $c['id']; ?>" <?php echo isset($product['category_id']) && $product['category_id'] == $c['id'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($c['name']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Nombre
      <input type="text" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
    </label>

    <label>Slug
      <input type="text" name="slug" value="<?php echo htmlspecialchars($product['slug'] ?? ''); ?>" required>
    </label>

    <label>Descripción
      <textarea name="description"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
    </label>

    <label>Precio
      <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price'] ?? '0'); ?>" required>
    </label>

    <label>Stock
      <input type="number" name="stock" value="<?php echo htmlspecialchars($product['stock'] ?? '0'); ?>" required>
    </label>

    <label>Imagen (nombre de archivo)
      <input type="text" name="image" value="<?php echo htmlspecialchars($product['image'] ?? ''); ?>">
    </label>

    <label>
      <input type="checkbox" name="is_active" <?php echo isset($product['is_active']) ? ($product['is_active'] ? 'checked' : '') : 'checked'; ?>>
      Activo
    </label>

    <button type="submit">Guardar</button>
  </form>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
