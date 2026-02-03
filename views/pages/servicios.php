<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section-pad-sm" aria-label="Servicios">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Servicios</div>
      <h1 class="section-title">Soluciones de <span class="gradient-text">Voz IP</span> para empresas</h1>
      <p class="section-desc">Calidad de voz, control y escalabilidad en un stack listo para operar.</p>
    </div>
  </div>
</section>

<section class="section" id="trunk">
  <div class="section-head">
    <h2>Trunk SIP</h2>
    <p>Conecta tu PBX y gestiona canales simultáneos, enrutamiento y seguridad.</p>
  </div>

  <div class="two-col">
    <div class="card glass-card" style="border-radius:1.4rem">
      <h3>Incluye</h3>
      <ul class="list">
        <li>Canales simultáneos según necesidad</li>
        <li>Rutas de salida y reglas básicas</li>
        <li>Monitoreo y soporte de configuración</li>
      </ul>
    </div>
    <div class="card glass-card" style="border-radius:1.4rem">
      <h3>Ideal para</h3>
      <ul class="list">
        <li>PBX Asterisk/Issabel/3CX u otras centrales</li>
        <li>Call centers y operaciones con alto volumen</li>
        <li>Empresas multi-sucursal</li>
      </ul>
    </div>
  </div>
</section>

<section class="section" id="central">
  <div class="section-head">
    <h2>Central Virtual</h2>
    <p>Extensiones, IVR, colas y reportes en una solución administrable.</p>
  </div>

  <div class="feature-grid">
    <div class="feature glass-card" style="border-radius:1.4rem">
      <h3>Extensiones y softphones</h3>
      <p>Configura usuarios y dispositivos para oficina, home office o móviles.</p>
    </div>
    <div class="feature glass-card" style="border-radius:1.4rem">
      <h3>IVR y colas</h3>
      <p>Atención automática, horarios, colas por área y distribución de llamadas.</p>
    </div>
    <div class="feature glass-card" style="border-radius:1.4rem">
      <h3>Reportes</h3>
      <p>Visibilidad de uso, llamadas y métricas para supervisión operativa.</p>
    </div>
  </div>
</section>

<section class="section" id="numeracion">
  <div class="section-head">
    <h2>Numeración</h2>
    <p>Solicita DIDs nacionales e internacionales para presencia local en distintos países.</p>
  </div>

  <div class="card glass-card" style="border-radius:1.4rem">
    <div class="notice">
      <strong>Tip:</strong> Si ya tienes numeración, consulta opciones de portabilidad o migración.
    </div>
    <div class="actions-row">
      <a class="btn" href="index.php?controller=pages&action=numeracion">Ver países y ejemplos</a>
      <a class="btn-secondary" href="index.php?controller=pages&action=contacto#cotizar">Solicitar numeración</a>
    </div>
  </div>
</section>

<section class="section" aria-label="CTA">
  <div class="cta-inner glass-card" style="border-radius:1.6rem">
    <div>
      <h2>¿Te ayudamos a elegir?</h2>
      <p>Comparte tu escenario y te sugerimos la mejor configuración para tu empresa.</p>
    </div>
    <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Cotizar ahora</a>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
