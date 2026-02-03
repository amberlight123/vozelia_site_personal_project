<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="section-pad-sm" aria-label="Contacto">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Contacto</div>
      <h1 class="section-title">Te respondemos con una propuesta <span class="gradient-text">clara</span></h1>
      <p class="section-desc">Cuéntanos tu necesidad y te ayudamos a elegir el servicio correcto.</p>
    </div>
  </div>
</section>

<section class="two-col">
  <div class="card glass-card" style="border-radius:1.4rem">
    <h2>Información</h2>
    <p class="muted">Si ya tienes PBX, indica la plataforma y la cantidad de extensiones / canales simultáneos.</p>

    <div class="info-list">
      <div class="info-item">
        <div class="info-k">Correo</div>
        <div class="info-v"><a class="text-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@vozelia.com.pa">info@vozelia.com.pa</a></div>
      </div>
      <div class="info-item">
        <div class="info-k">Horario</div>
        <div class="info-v">Lun–Vie, 8:00–17:00</div>
      </div>
      <div class="info-item">
        <div class="info-k">Cobertura</div>
        <div class="info-v">Panamá + destinos internacionales</div>
      </div>
    </div>

    <div class="notice" style="margin-top:1rem">
      <strong>Tip:</strong> Para una cotización rápida, incluye destinos (país/ciudad) y si es fijo o móvil.
    </div>
  </div>

  <div class="card glass-card" style="border-radius:1.4rem" id="cotizar">
    <h2>Formulario de cotización</h2>

    <?php if (isset($error) && $error): ?>
      <div class="notice" role="alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?controller=contact&action=send" class="form">
      <div class="form-grid">
        <label>Nombre <span class="req">*</span>
          <input type="text" name="name" required>
        </label>

        <label>Correo <span class="req">*</span>
          <input type="email" name="email" required>
        </label>

        <label>Teléfono
          <input type="tel" name="phone" placeholder="+507 ...">
        </label>

        <label>Empresa
          <input type="text" name="company" placeholder="Nombre de la empresa">
        </label>

        <label>Servicio
          <select name="service">
            <option value="">Seleccionar</option>
            <option value="Trunk SIP">Trunk SIP</option>
            <option value="Numeración (DID)">Numeración (DID)</option>
            <option value="PBX / Telefonía IP">PBX / Telefonía IP</option>
            <option value="Conectividad / Internet">Conectividad / Internet</option>
            <option value="Otro">Otro</option>
          </select>
        </label>

        <label>PBX actual
          <input type="text" name="pbx" placeholder="Ej.: 3CX / Issabel / Avaya / Cisco">
        </label>

        <label>Extensiones
          <input type="number" min="0" name="extensions" placeholder="Ej.: 20">
        </label>

        <label>Canales simultáneos
          <input type="number" min="0" name="concurrent_channels" placeholder="Ej.: 5">
        </label>
      </div>

      <label>Destinos (país/ciudad + fijo/móvil)
        <input type="text" name="destinations" placeholder="Ej.: Panamá (fijo/móvil), USA (móvil), España (fijo)">
      </label>

      <label>Asunto
        <input type="text" name="subject" placeholder="Ej.: Cotización Trunk SIP">
      </label>

      <label>Mensaje <span class="req">*</span>
        <textarea name="message" required placeholder="Describe tu escenario: volumen estimado, horarios, numeración, etc."></textarea>
      </label>

      <button type="submit" class="btn">Enviar</button>
      <p class="muted" style="margin-top:.75rem">Al enviar, aceptas que usemos estos datos únicamente para responder tu solicitud.</p>
    </form>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
