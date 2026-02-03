<?php require __DIR__ . '/../layout/header.php'; ?>
<h1>Confirmar pedido</h1>
<table class="table">
<thead>
<tr>
<th>Producto</th>
<th>Cantidad</th>
<th>Subtotal</th>
</tr>
</thead>
<tbody>
<?php foreach ($items as $i): ?>
<tr>
<td><?php echo htmlspecialchars($i['product']['name']); ?></td>
<td><?php echo (int)$i['qty']; ?></td>
<td>B/. <?php echo number_format($i['subtotal'], 2); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p class="total">Total: B/. <?php echo number_format($total, 2); ?></p>
<form method="post" action="index.php?controller=order&action=place" class="form-card">
<p>Este ejemplo guarda el pedido en el sistema. La integración con pasarela de pago se puede añadir después.</p>
<button type="submit">Confirmar pedido</button>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
