<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section-pad-sm" aria-label="Numeración">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Numeración</div>
      <h1 class="section-title">DIDs nacionales e <span class="gradient-text">internacionales</span></h1>
      <p class="section-desc">Ejemplos de numeración DID por país. La disponibilidad puede variar por ciudad/área.</p>
    </div>
  </div>
</section>

<div class="card glass-card" style="border-radius:1.4rem">
  <div class="actions-row" style="justify-content:space-between; align-items:center">
    <div>
      <strong>Buscador rápido</strong>
      <div class="muted">Escribe un país para filtrar la tabla.</div>
    </div>
    <input class="search-input" style="flex:1 1 280px; min-width:220px" type="text" placeholder="Ej.: Estados Unidos" data-filter-table="numeracion" aria-label="Buscar país">
  </div>
  <div class="table-wrap">
<table class="table" id="numeracion">
    <thead>
      <tr>
        <th>País</th>
        <th>Ejemplo DID</th>
        <th>Tipo</th>
        <th>Notas</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Panamá</td>
        <td>+507 6xxx xxxx</td>
        <td>Nacional</td>
        <td>Disponibilidad por área</td>
      </tr>
      <tr>
        <td>Estados Unidos</td>
        <td>+1 (305) xxx-xxxx</td>
        <td>Internacional</td>
        <td>Ciudad/área según inventario</td>
      </tr>
      <tr>
        <td>España</td>
        <td>+34 9xx xxx xxx</td>
        <td>Internacional</td>
        <td>Opciones por ciudad</td>
      </tr>
      <tr>
        <td>Colombia</td>
        <td>+57 (1) xxx xxxx</td>
        <td>Internacional</td>
        <td>Fijo (ejemplos) / según inventario</td>
      </tr>
      <tr>
        <td>República Dominicana</td>
        <td>+1 (809) xxx-xxxx</td>
        <td>Internacional</td>
        <td>Área según inventario</td>
      </tr>
      <tr>
        <td>México</td>
        <td>+52 (55) xxxx xxxx</td>
        <td>Internacional</td>
        <td>Ciudad/área según inventario</td>
      </tr>
    </tbody>
  </table>
  </div>
  <div class="notice">
    Si necesitas un país que no aparece aquí, indícanos el destino y si es fijo o móvil.
  </div>

  <div class="actions-row">
    <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar numeración</a>
    <a class="btn-secondary" href="index.php?controller=pages&action=tarifas">Ver tarifas</a>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
