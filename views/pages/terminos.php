<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
$brand = 'Vozelia';
$companyTitle = ctx()['business']['name'] ?? $brand;
$lastUpdate = date(' m/d/Y');
?>

<section class="section-pad-sm" aria-label="Términos y Condiciones">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Legal</div>
      <h1 class="section-title">Términos y <span class="gradient-text">Condiciones</span></h1>
      <p class="section-desc">
        Estos Términos regulan el acceso y uso del sitio web de Vozelia y, cuando aplique, las condiciones generales de contratación
        de servicios empresariales de voz IP (como Trunk SIP, numeración y soluciones relacionadas).
      </p>
      <p class="muted" style="margin-top:1rem">
        <strong><?php echo htmlspecialchars($companyTitle); ?></strong> · Última actualización: <?php echo htmlspecialchars($lastUpdate); ?>
      </p>
    </div>
  </div>
</section>

<section class="section" aria-label="Contenido de términos">
  <div class="card glass-card" style="border-radius:1.4rem;max-width:900px;margin:0 auto">
    <h2>1. Aceptación</h2>
    <p>
      Al acceder o utilizar este sitio web, aceptas estos Términos. Si contratas servicios con Vozelia, tu relación se regirá además por la
      propuesta comercial, el contrato y/o anexos que se suscriban, los cuales prevalecerán en caso de conflicto.
    </p>

    <h2>2. Definiciones</h2>
    <ul class="list">
      <li><strong>Cliente:</strong> persona natural o jurídica que solicita o contrata servicios.</li>
      <li><strong>Servicios:</strong> soluciones de voz IP y telecomunicaciones empresariales provistas por Vozelia (por ejemplo: Trunk SIP, DID/numeración, central virtual y soporte).</li>
      <li><strong>Red/Plataforma:</strong> infraestructura y sistemas utilizados para operar los Servicios (incluye interconexiones con terceros).</li>
    </ul>

    <h2>3. Uso del sitio web</h2>
    <p>
      El sitio web puede utilizarse para informarte sobre nuestros Servicios, solicitar una cotización, iniciar procesos de contratación, acceder a
      recursos de soporte y gestionar comunicaciones con Vozelia.
    </p>

    <h2>4. Cotizaciones y contratación</h2>
    <p>
      Las cotizaciones están sujetas a validación técnica (capacidad, cobertura, numeración y requisitos de interconexión) y a verificaciones
      comerciales y de seguridad. La activación de Servicios puede requerir documentación, verificación de identidad y condiciones de pago.
    </p>
    <p class="muted">
      Los Servicios se prestan conforme a la normativa aplicable en la República de Panamá y la regulación del sector telecomunicaciones;
      cuando corresponda, bajo el marco de supervisión de la Autoridad Nacional de los Servicios Públicos (ASEP).
    </p>

    <h2>5. Requisitos técnicos</h2>
    <ul class="list">
      <li>Conectividad a Internet estable y red local correctamente configurada.</li>
      <li>Equipo o software compatible (PBX, softphone o gateway), según el Servicio contratado.</li>
      <li>Buenas prácticas de seguridad (credenciales fuertes, control de acceso y segmentación de red) para evitar uso no autorizado.</li>
    </ul>

    <h2>6. Uso aceptable y prevención de fraude</h2>
    <p>
      Debes utilizar los Servicios de forma lícita y responsable. Está prohibido el uso para spam, fraude, suplantación, intentos de intrusión,
      tráfico malicioso, o cualquier actividad que degrade la red o afecte a terceros.
    </p>
    <p>
      Por seguridad operativa, Vozelia puede aplicar controles (por ejemplo: límites, bloqueos preventivos, validaciones y monitoreo de patrones)
      para mitigar fraudes y usos anómalos. Si detectamos actividad sospechosa, podremos suspender temporalmente el tráfico mientras se valida.
    </p>

    <h2>7. Calidad, mantenimiento y continuidad</h2>
    <p>
      Podemos realizar mantenimientos planificados y aplicar medidas para proteger la red y la estabilidad del servicio. La calidad puede verse
      afectada por factores fuera de nuestro control (conectividad del Cliente, configuración, rutas de terceros, congestión, entre otros).
      Los niveles de servicio (SLA), si se ofrecen, se detallarán en el contrato o anexo correspondiente.
    </p>

    <h2>8. Numeración y portabilidad (cuando aplique)</h2>
    <p>
      La disponibilidad de numeración (DID) y procesos de portabilidad dependen de cobertura, viabilidad técnica y requisitos aplicables.
      Los plazos pueden variar por validaciones y coordinaciones con terceros.
    </p>

    <h2>9. Llamadas de emergencia</h2>
    <p>
      Los servicios de voz IP pueden tener limitaciones en llamadas de emergencia (por ejemplo: ubicación o continuidad ante cortes de energía/Internet).
      Si tu operación requiere manejo de emergencias, debes definir un plan alterno y notificarlo durante la contratación.
    </p>

    <h2>10. Tarifas, facturación e impuestos</h2>
    <p>
      Las tarifas pueden ser recurrentes (mensualidad) y/o por consumo (minutos, canales, numeración, rutas). Los impuestos, cargos regulatorios o
      tasas aplicables se incluirán según corresponda. La facturación y condiciones de pago se especifican en la propuesta/contrato.
    </p>

    <h2>11. Suspensión y terminación</h2>
    <p>
      Podremos suspender o limitar el servicio por incumplimiento contractual, falta de pago, fraude, uso prohibido o riesgos de seguridad.
      La terminación se regirá por lo pactado en el contrato y sus anexos.
    </p>

    <h2>12. Propiedad intelectual</h2>
    <p>
      El sitio web, marcas, software y materiales asociados pertenecen a Vozelia o a sus licenciantes. No se permite copiar, modificar o distribuir
      sin autorización, salvo que la ley lo permita.
    </p>

    <h2>13. Privacidad</h2>
    <p>
      El tratamiento de datos personales se rige por nuestra <a class="text-link" href="index.php?controller=pages&action=privacidad">Política de Privacidad</a>.
      Si el Cliente procesa datos de terceros (por ejemplo: llamadas y grabaciones en un call center), el Cliente es responsable de informar y
      obtener las autorizaciones correspondientes.
    </p>

    <h2>14. Limitación de responsabilidad</h2>
    <p>
      En la medida permitida por la ley, Vozelia no será responsable por daños indirectos, incidentales o consecuentes (por ejemplo: pérdida de
      ganancias, interrupción del negocio, pérdida de datos) derivados del uso del sitio o de los Servicios. Cualquier límite específico podrá
      establecerse en el contrato.
    </p>

    <h2>15. Ley aplicable y jurisdicción</h2>
    <p>
      Estos Términos se rigen por las leyes de la República de Panamá. Salvo pacto distinto en contrato, las controversias se someterán a los
      tribunales competentes en Panamá.
    </p>

    <h2>16. Contacto</h2>
    <p>
      Para consultas relacionadas con estos Términos, puedes escribirnos a <a class="text-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@vozelia.com.pa">info@vozelia.com.pa</a>.
    </p>

    <div class="notice" style="margin-top:1.2rem">
      <strong>Seguridad operativa:</strong> si detectas llamadas no autorizadas, tráfico inusual o degradación, contáctanos de inmediato para contener el incidente.
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
