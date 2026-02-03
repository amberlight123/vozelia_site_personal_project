<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section">
  <div class="section-header">
    <h1>Leads & SLA</h1>
    <p class="muted">Panel de Acceso a funciones Estandares de Calidad</p>
    <div class="admin-links">
    <a class="btn-secondary btn-compact" aria-current="page" href="index.php?controller=admin&action=dashboard">Panel</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=leads">Leads & SLA</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=products">Productos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=orders">Pedidos</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=admin&action=users">Usuarios</a>
    <a class="btn-secondary btn-compact" href="index.php?controller=ops&action=status">Estado</a>
  </div>
    <p class="muted">Ref: <code><?= htmlspecialchars(Obs::requestId()) ?></code></p>
  </div>

  <div class="card">
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Creado</th>
            <th>Prioridad</th>
            <th>Due (1ª respuesta)</th>
            <th>1ª respuesta</th>
            <th>Est. USD/mes</th>
            <th>Contacto</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $now = new DateTime('now');
          foreach ($leads as $l):
            $due = isset($l['first_response_due_at']) ? new DateTime($l['first_response_due_at']) : null;
            $responded = !empty($l['first_response_at']);
            $breach = ($due && !$responded && $now > $due);
        ?>
          <tr>
            <td><?= (int)$l['id'] ?></td>
            <td><?= htmlspecialchars($l['created_at']) ?></td>
            <td>
              <?php
                $p = $l['priority'] ?? 'media';
                $c = ($p === 'alta') ? 'badge-danger' : (($p === 'baja') ? 'badge-ok' : 'badge-warn');
              ?>
              <span class="badge <?= $c ?>"><?= htmlspecialchars(strtoupper($p)) ?></span>
            </td>
            <td>
              <?php if ($due): ?>
                <?= htmlspecialchars($l['first_response_due_at']) ?>
                <?php if ($breach): ?>
                  <span class="badge badge-danger" style="margin-left:8px;">SLA VENCIDO</span>
                <?php endif; ?>
              <?php else: ?>
                <span class="muted">(sin SLA)</span>
              <?php endif; ?>
            </td>
            <td><?= $responded ? htmlspecialchars($l['first_response_at']) : '<span class="muted">pendiente</span>' ?></td>
            <td><?= isset($l['est_monthly_usd']) ? number_format((float)$l['est_monthly_usd'], 2) : '-' ?></td>
            <td>
              <div><strong><?= htmlspecialchars($l['name']) ?></strong></div>
              <div class="muted"><?= htmlspecialchars($l['email']) ?></div>
              <?php if (!empty($l['company'])): ?><div class="muted"><?= htmlspecialchars($l['company']) ?></div><?php endif; ?>
            </td>
            <td>
              <?php if (!$responded): ?>
                <form method="post" action="index.php?controller=admin&action=markLeadFirstResponse">
                  <input type="hidden" name="id" value="<?= (int)$l['id'] ?>">
                  <button class="btn btn-compact" type="submit">Marcar 1ª respuesta</button>
                </form>
              <?php else: ?>
                <span class="muted">OK</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
