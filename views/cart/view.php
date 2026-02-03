<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="page-section">
  <h1>Carrito de compras</h1>

  <?php if (empty($items)): ?>
    <div class="empty-state">
      <p>Tu carrito está vacío.</p>
      <p style="margin-top:.6rem;">
        Explora nuestro catálogo y descubre productos para tu hogar.
      </p>
    </div>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio unitario</th>
          <th>Subtotal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        <?php foreach ($items as $i): ?>
          <?php $total += $i['subtotal']; ?>
          <tr>
            <td><?php echo htmlspecialchars($i['product']['name']); ?></td>
            <td><?php echo (int)$i['qty']; ?></td>
            <td>B/. <?php echo number_format($i['product']['price'], 2); ?></td>
            <td>B/. <?php echo number_format($i['subtotal'], 2); ?></td>
            <td>
              <a href="index.php?controller=cart&action=remove&id=<?php echo $i['product']['id']; ?>">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p class="total">Total: B/. <?php echo number_format($total, 2); ?></p>

    <div class="cart-actions">
      <a class="btn-secondary" href="index.php?controller=cart&action=clear">Vaciar carrito</a>
      <a class="btn" href="index.php?controller=order&action=checkout">Proceder al pago</a>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
