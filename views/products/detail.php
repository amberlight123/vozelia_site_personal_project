<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="product-detail">
<div class="product-image">
<img src="public/img/<?php echo htmlspecialchars($product['image'] ?: 'placeholder.png'); ?>" alt="">
</div>
<div class="product-info">
<h1><?php echo htmlspecialchars($product['name']); ?></h1>
<p class="price">B/. <?php echo number_format($product['price'], 2); ?></p>
<p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
<form method="post" action="index.php?controller=cart&action=add">
<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
<label>Cantidad
<input type="number" name="quantity" value="1" min="1">
</label>
<button type="submit">Agregar al carrito</button>
</form>
</div>
</div>
<h2>Reseñas</h2>
<?php if ($reviews): ?>
<ul class="reviews">
<?php foreach ($reviews as $r): ?>
<li>
<p><strong><?php echo htmlspecialchars($r['name']); ?></strong> · <?php echo (int)$r['rating']; ?>/5</p>
<p><?php echo nl2br(htmlspecialchars($r['comment'])); ?></p>
</li>
<?php endforeach; ?>
</ul>
<?php else: ?>
<p>No hay reseñas aún.</p>
<?php endif; ?>
<?php if (is_logged_in()): ?>
<h3>Dejar reseña</h3>
<form method="post" action="index.php?controller=product&action=addReview" class="form-card">
<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
<label>Calificación
<select name="rating">
<option value="5">5</option>
<option value="4">4</option>
<option value="3">3</option>
<option value="2">2</option>
<option value="1">1</option>
</select>
</label>
<label>Comentario
<textarea name="comment"></textarea>
</label>
<button type="submit">Enviar reseña</button>
</form>
<?php endif; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
