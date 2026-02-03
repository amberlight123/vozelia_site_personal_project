<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="hero-modern" aria-label="Portada">
  <div class="hero-bg" aria-hidden="true">
    <div class="hero-grid"></div>
    <div class="orb o1 animate-blob"></div>
    <div class="orb o2 animate-blob" style="animation-delay:1.2s"></div>
    <div class="orb o3 animate-blob" style="animation-delay:2.2s"></div>
  </div>

  <div class="container" style="position:relative;z-index:1;text-align:center">
    <div class="badge animate-fade-in-up">
      <span class="dot" aria-hidden="true"></span>
      <span>Operador autorizado en Panamá</span>
    </div>

    <h1 class="hero-headline animate-fade-in-up stagger-2">
      Moderniza tus comunicaciones con
      <span class="gradient-text"> Voz IP</span>
    </h1>

    <p class="hero-lead animate-fade-in-up stagger-3" style="margin-left:auto;margin-right:auto">
      Telefonía nacional e internacional, Central Telefónica Virtual y soluciones para operadores.
      Calidad de voz, métricas claras y soporte local.
    </p>

    <div class="cta-actions animate-fade-in-up stagger-4">
      <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar información</a>
      <a class="btn-outline" href="tel:310-0869">310-0VOZ</a>
    </div>

    <div class="pill-row animate-fade-in-up stagger-5" aria-label="Beneficios">
      <span class="pill-item"><svg class="pill-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg> SIP e IAX2</span>
      <span class="pill-item"><svg class="pill-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 3v18"/><path d="M3 12h18"/></svg> Escalable</span>
      <span class="pill-item"><svg class="pill-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 21s-7-4.4-7-11a7 7 0 0 1 14 0c0 6.6-7 11-7 11z"/></svg> Soporte local</span>
    </div>
  </div>

  <div class="wave" aria-hidden="true">
    <svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
      <path fill="rgba(128,176,79,.08)" d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,181.3C672,192,768,160,864,138.7C960,117,1056,107,1152,122.7C1248,139,1344,181,1392,202.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
  </div>
</section>

<section id="services" class="section-pad bg-soft" aria-label="Servicios">
  <div class="container">
    <div style="text-align:center;max-width:860px;margin:0 auto 2.4rem">
      <div class="section-kicker">Nuestros servicios</div>
      <h2 class="section-title">Soluciones completas de <span class="gradient-text">telecomunicaciones</span></h2>
      <p class="section-desc">Desde telefonía básica hasta infraestructura para operadores, una oferta pensada para empresas de todos los tamaños.</p>
    </div>

    <div class="grid" style="grid-template-columns:repeat(auto-fit, minmax(260px, 1fr));gap:1.25rem">
      <article class="service-card animate-fade-in-up" style="animation-delay:0ms">
        <div class="inner hover-lift">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.08 4.18 2 2 0 0 1 4.06 2h3a2 2 0 0 1 2 1.72c.12.86.3 1.7.54 2.5a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.58-1.06a2 2 0 0 1 2.11-.45c.8.24 1.64.42 2.5.54A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <h3 class="service-title">Telefonía Nacional e Internacional</h3>
          <div class="service-sub">Compatible con la gran mayoría de fabricantes</div>
          <p class="service-text">Conecta tus dispositivos con enlaces SIP o IAX2 y empieza a ahorrar con tarifas competitivas.</p>
          <ul class="service-list">
            <li><i aria-hidden="true"></i> Protocolo SIP e IAX2</li>
            <li><i aria-hidden="true"></i> Portabilidad numérica</li>
            <li><i aria-hidden="true"></i> Calidad de voz HD</li>
            <li><i aria-hidden="true"></i> Soporte 24/7</li>
          </ul>
        </div>
      </article>

      <article class="service-card animate-fade-in-up" style="animation-delay:150ms">
        <div class="inner hover-lift">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 0 0-7 7v3a7 7 0 0 0 14 0V9a7 7 0 0 0-7-7Z"/><path d="M5 14v2a7 7 0 0 0 14 0v-2"/><path d="M8 21h8"/></svg>
          </div>
          <h3 class="service-title">Central Telefónica Virtual</h3>
          <div class="service-sub">Todas las funcionalidades a un precio asequible</div>
          <p class="service-text">Una centralita completa en la nube, sin inversión en hardware ni mantenimiento.</p>
          <ul class="service-list">
            <li><i aria-hidden="true"></i> Operadora automática</li>
            <li><i aria-hidden="true"></i> Buzón de voz al correo</li>
            <li><i aria-hidden="true"></i> Informe de llamadas</li>
            <li><i aria-hidden="true"></i> Panel de control</li>
            <li><i aria-hidden="true"></i> Grabaciones</li>
          </ul>
        </div>
      </article>

      <article class="service-card animate-fade-in-up" style="animation-delay:300ms">
        <div class="inner hover-lift">
          <div class="service-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9 21v-7h6v7"/></svg>
          </div>
          <h3 class="service-title">Wholesale</h3>
          <div class="service-sub">Infraestructura para Voz IP</div>
          <p class="service-text">Soluciones a medida para operadores, mayoristas y revendedores con interconexión dedicada.</p>
          <ul class="service-list">
            <li><i aria-hidden="true"></i> Para operadores</li>
            <li><i aria-hidden="true"></i> Para mayoristas</li>
            <li><i aria-hidden="true"></i> Para revendedores</li>
            <li><i aria-hidden="true"></i> Infraestructura dedicada</li>
            <li><i aria-hidden="true"></i> Interconexión</li>
          </ul>
        </div>
      </article>
    </div>

    <div style="text-align:center;margin-top:2.2rem">
      <a class="btn-outline" href="index.php?controller=pages&action=servicios">Ver detalle de servicios</a>
    </div>
  </div>
</section>

<section class="stats-band" aria-label="Métricas">
  <div class="container" style="position:relative;z-index:1">
    <div class="grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1.2rem">
      <div class="stat animate-fade-in-up" style="animation-delay:0ms">
        <div class="num" data-countup data-value="96.4" data-suffix="%">0%</div>
        <div class="lbl">Uptime garantizado</div>
      </div>
      <div class="stat animate-fade-in-up" style="animation-delay:100ms">
        <div class="num" data-countup data-value="10" data-suffix="+">0+</div>
        <div class="lbl">Años de experiencia</div>
      </div>
      <div class="stat animate-fade-in-up" style="animation-delay:200ms">
        <div class="num" data-countup data-value="500" data-suffix="+">0+</div>
        <div class="lbl">Clientes satisfechos</div>
      </div>
      <div class="stat animate-fade-in-up" style="animation-delay:300ms">
        <div class="num" data-countup data-value="24" data-suffix="/7">0/7</div>
        <div class="lbl">Soporte técnico</div>
      </div>
    </div>
  </div>
</section>

<section id="about" class="section-pad" aria-label="Por qué elegirnos">
  <div class="container">
    <div class="about-grid">
      <div>
        <div class="section-kicker">¿Por qué elegirnos?</div>
        <h2 class="section-title">La experiencia que tu negocio <span class="gradient-text">necesita</span></h2>
        <p class="section-desc">
          Somos un operador autorizado por la Autoridad Nacional de los Servicios Públicos de Panamá.
          Con más de una década de experiencia, acompañamos implementaciones que buscan estabilidad,
          control y crecimiento.
        </p>

        <div class="about-features">
          <div class="about-card animate-fade-in-up" style="animation-delay:0ms">
            <div class="about-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <h3>Seguridad</h3>
            <p>Buenas prácticas de control y monitoreo para proteger tus comunicaciones.</p>
          </div>
          <div class="about-card animate-fade-in-up" style="animation-delay:100ms">
            <div class="about-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div>
            <h3>Baja latencia</h3>
            <p>Rutas optimizadas para llamadas claras y estables, con métricas.</p>
          </div>
          <div class="about-card animate-fade-in-up" style="animation-delay:200ms">
            <div class="about-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M12 7a4 4 0 1 0-8 0 4 4 0 0 0 8 0z"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <h3>Escalabilidad</h3>
            <p>Añade líneas y funcionalidades cuando tu operación lo requiera.</p>
          </div>
          <div class="about-card animate-fade-in-up" style="animation-delay:300ms">
            <div class="about-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 10h.01"/><path d="M12 10h.01"/><path d="M16 10h.01"/><path d="M21 16a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
            <h3>Soporte dedicado</h3>
            <p>Equipo local en Panamá listo para ayudarte cuando lo necesites.</p>
          </div>
        </div>
      </div>

      <div>
        <div class="rings">
          <div class="ring"></div>
          <div class="ring r2"></div>
          <div class="ring r3"></div>

          <div class="center-glass">
            <div class="box glass-card animate-float">
              <div class="big gradient-text">10+</div>
              <div class="muted" style="font-weight:800">Años conectando Panamá</div>
            </div>
          </div>

          <div class="float-badge b1 glass-card animate-float-delayed"><span style="font-weight:900">SIP &amp; IAX2</span></div>
          <div class="float-badge b2 glass-card animate-float"><span style="font-weight:900">HD Voice</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="pricing" class="section-pad-sm bg-soft" aria-label="Tarifas">
  <div class="container">
    <div style="text-align:center;max-width:860px;margin:0 auto 2.2rem">
      <div class="section-kicker">Tarifas</div>
      <h2 class="section-title">Planifica tu costo con <span class="gradient-text">transparencia</span></h2>
      <p class="section-desc">Revisa modalidades y ejemplos. Para escenarios específicos (PBX, extensiones, volumen), te asesoramos.</p>
    </div>

    <div class="pricing-grid">
      <div class="pricing glass-card hover-lift" style="border-radius:1.6rem">
        <div class="pricing-top">
          <h3 style="font-weight:900">Trunk SIP</h3>
          <p>Conecta tu PBX y escala canales simultáneos según demanda.</p>
        </div>
        <ul class="list" style="margin-top:1rem">
          <li>Rutas y seguridad</li>
          <li>Monitoreo y soporte</li>
          <li>Compatible con SIP/IAX2</li>
        </ul>
        <div class="actions-row">
          <a class="btn" href="index.php?controller=pages&action=tarifas">Ver tarifas</a>
        </div>
      </div>

      <div class="pricing glass-card hover-lift" style="border-radius:1.6rem;border:1px solid rgba(128,176,79,.35)">
        <div class="pricing-badge">Recomendado</div>
        <div class="pricing-top">
          <h3 style="font-weight:900">Central Virtual</h3>
          <p>Extensiones, IVR, colas y reportes sin invertir en hardware.</p>
        </div>
        <ul class="list" style="margin-top:1rem">
          <li>Grabaciones y métricas</li>
          <li>Multi-sucursal</li>
          <li>Panel de control</li>
        </ul>
        <div class="actions-row">
          <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar cotización</a>
        </div>
      </div>

      <div class="pricing glass-card hover-lift" style="border-radius:1.6rem">
        <div class="pricing-top">
          <h3 style="font-weight:900">Wholesale</h3>
          <p>Interconexión y capacidad para operadores y revendedores.</p>
        </div>
        <ul class="list" style="margin-top:1rem">
          <li>Infraestructura dedicada</li>
          <li>Escalado por volumen</li>
          <li>Acuerdos a medida</li>
        </ul>
        <div class="actions-row">
          <a class="btn-outline" href="index.php?controller=pages&action=contacto#cotizar">Hablar con ventas</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="contact" class="section-pad" aria-label="Contacto">
  <div class="container">
    <div class="cta-block glass-card">
      <div class="section-kicker">Comienza hoy</div>
      <h2 class="section-title">¿Listo para modernizar tus <span class="gradient-text">telecomunicaciones?</span></h2>
      <p class="section-desc" style="margin-left:auto;margin-right:auto;max-width:72ch">
        Cuéntanos tu escenario (PBX, extensiones, volumen) y te proponemos la opción ideal.
        También podemos coordinar una demostración.
      </p>
      <div class="cta-actions">
        <a class="btn" href="index.php?controller=pages&action=contacto#cotizar">Solicitar información</a>
        <a class="btn-outline" href="tel:310-0869">Llamar: 310-0VOZ</a>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
