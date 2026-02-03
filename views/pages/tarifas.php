<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section-pad-sm" aria-label="Tarifas">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Tarifas</div>
      <h1 class="section-title">Guía de costos y <span class="gradient-text">modalidades</span></h1>
      <p class="section-desc">
        Presentamos una guía en formato de tabla. Para la cotización final se valida el escenario (volumen, destinos,
        numeración y canales simultáneos).
      </p>
    </div>
  </div>
</section>

<div class="tabs" data-tabs>
  <button class="tab-btn is-active" type="button" data-tab="nacional">Nacionales</button>
  <button class="tab-btn" type="button" data-tab="internacional">Internacionales</button>
  <button class="tab-btn" type="button" data-tab="soluciones">Soluciones</button>
</div>

<section class="tab-panel is-active" data-tab-panel="nacional">
  <div class="card glass-card" style="border-radius:1.4rem">
    <div class="notice">
      <strong>Nota:</strong> Valores referenciales. Se confirman al momento de cotizar.
    </div>
    <div class="table-wrap">
<table class="table">
      <thead>
        <tr>
          <th>Servicio</th>
          <th>Unidad</th>
          <th>Modalidad</th>
          <th>Observaciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Llamadas a fijos (Panamá)</td>
          <td>Minuto</td>
          <td>Prepago / Mensual</td>
          <td>Según plan y volumen</td>
        </tr>
        <tr>
          <td>Llamadas a móviles (Panamá)</td>
          <td>Minuto</td>
          <td>Prepago / Mensual</td>
          <td>Según plan y volumen</td>
        </tr>
        <tr>
          <td>Numeración DID (Panamá)</td>
          <td>Mensual</td>
          <td>Contrato</td>
          <td>Disponibilidad por área</td>
        </tr>
      </tbody>
    </table>
</div>
    <div class="actions-row">
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar cotización</a>
      <a class="btn-secondary" href="index.php?controller=pages&action=numeracion">Ver numeración</a>
    </div>
  </div>
</section>

<section class="tab-panel" data-tab-panel="internacional">
  <div class="card glass-card" style="border-radius:1.4rem">
    <div class="section-head">
      <h2>Internacionales</h2>
      <p>Ejemplos de destinos comunes. Para el listado completo, consulta por tu país.</p>
    </div>

    <div class="table-wrap">
<table class="table">
      <thead>
        <tr>
          <th>Destino</th>
          <th>Tipo</th>
          <th>Unidad</th>
          <th>Notas</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Estados Unidos</td>
          <td>Fijo / Móvil</td>
          <td>Minuto</td>
          <td>Tarifa según terminación</td>
        </tr>
        <tr>
          <td>Colombia</td>
          <td>Fijo / Móvil</td>
          <td>Minuto</td>
          <td>Tarifa según terminación</td>
        </tr>
        <tr>
          <td>España</td>
          <td>Fijo / Móvil</td>
          <td>Minuto</td>
          <td>Tarifa según terminación</td>
        </tr>
        <tr>
          <td>Rep. Dominicana</td>
          <td>Fijo / Móvil</td>
          <td>Minuto</td>
          <td>Tarifa según terminación</td>
        </tr>
      </tbody>
    </table>
</div>

    <div class="notice">
      ¿No ves tu destino? Te cotizamos el país y el tipo de terminación (fijo/móvil) que necesitas.
    </div>
  </div>
</section>

<section class="tab-panel" data-tab-panel="soluciones">
  <div class="pricing-grid">
    <div class="pricing glass-card" style="border-radius:1.6rem">
      <div class="pricing-top">
        <h3>Trunk SIP</h3>
        <p>Para centrales existentes. Canales según tu operación.</p>
      </div>
      <ul class="list">
        <li>Canales simultáneos escalables</li>
        <li>Enrutamiento y reglas básicas</li>
        <li>Soporte de implementación</li>
      </ul>
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Cotizar Trunk</a>
    </div>

    <div class="pricing is-featured glass-card" style="border-radius:1.6rem">
      <div class="pricing-badge">Recomendado</div>
      <div class="pricing-top">
        <h3>Central Virtual</h3>
        <p>Extensiones, IVR y colas. Ideal para equipos distribuidos.</p>
      </div>
      <ul class="list">
        <li>Extensiones y softphones</li>
        <li>IVR, colas y horarios</li>
        <li>Reportes básicos</li>
      </ul>
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Cotizar Central</a>
    </div>

    <div class="pricing glass-card" style="border-radius:1.6rem">
      <div class="pricing-top">
        <h3>Numeración</h3>
        <p>Presencia local en distintos países con DIDs.</p>
      </div>
      <ul class="list">
        <li>DIDs por país / ciudad (según disponibilidad)</li>
        <li>Activación guiada</li>
        <li>Portabilidad (según caso)</li>
      </ul>
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar DIDs</a>
    </div>
  </div>

  <div class="cta" style="margin-top:1.25rem">
    <div class="cta-inner glass-card" style="border-radius:1.6rem">
      <div>
        <h2>¿Quieres la tabla completa?</h2>
        <p>Te compartimos el listado por país y tipo de terminación, según tu necesidad.</p>
      </div>
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Pedir listado</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
