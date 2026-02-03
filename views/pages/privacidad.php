<?php require __DIR__ . '/../layout/header.php'; ?>

<?php
$brand = 'Vozelia';
$companyTitle = ctx()['business']['name'] ?? $brand;
$lastUpdate = date(' m/d/Y');
?>

<section class="section-pad-sm" aria-label="Política de Privacidad">
  <div class="container">
    <div style="max-width:900px">
      <div class="section-kicker">Legal</div>
      <h1 class="section-title">Política de <span class="gradient-text">Privacidad</span></h1>
      <p class="section-desc">
        En Vozelia tratamos datos personales para responder solicitudes, provisionar y operar servicios de voz IP, brindar soporte,
        facturar cuando corresponda y mantener la seguridad y continuidad del servicio.
      </p>
      <p class="muted" style="margin-top:1rem">
        <strong><?php echo htmlspecialchars($companyTitle); ?></strong> · Última actualización: <?php echo htmlspecialchars($lastUpdate); ?>
      </p>
    </div>
  </div>
</section>

<section class="section" aria-label="Contenido de privacidad">
  <div class="card glass-card" style="border-radius:1.4rem;max-width:900px;margin:0 auto">
    <h2>1. Responsable y contacto</h2>
    <p>
      El responsable del tratamiento de los datos personales recogidos a través de este sitio web y nuestros canales de contacto es
      <strong><?php echo htmlspecialchars($brand); ?></strong>, con operación en la República de Panamá.
      Para consultas de privacidad o ejercicio de derechos, escríbenos a
      <a class="text-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@vozelia.com.pa">info@vozelia.com.pa</a>.
    </p>

    <h2>2. Alcance</h2>
    <p>
      Esta Política aplica al uso de nuestro sitio web, formularios, comunicaciones comerciales, y a la prestación/soporte de nuestros
      servicios empresariales de voz IP (por ejemplo: Trunk SIP, numeración, central virtual y servicios asociados), cuando tratemos
      datos personales como parte de dichas actividades.
    </p>
    <p class="muted">
      En la República de Panamá, la protección de datos personales se rige por la Ley 81 de 2019 y su reglamentación. La Autoridad Nacional
      de Transparencia y Acceso a la Información (ANTAI), a través de su Dirección de Protección de Datos Personales, es la entidad competente
      en la materia.
    </p>

    <h2>3. Datos personales que tratamos</h2>
    <ul class="list">
      <li><strong>Datos de identificación y contacto:</strong> nombre, correo, teléfono, empresa, cargo, país/ciudad.</li>
      <li><strong>Datos de solicitud comercial:</strong> requerimientos técnicos, destinos de llamada, volumen estimado, mensajes y documentación que nos compartas.</li>
      <li><strong>Datos de cuenta y soporte (si aplica):</strong> usuario/rol, historial de tickets, configuraciones solicitadas, evidencias para diagnóstico.</li>
      <li><strong>Datos técnicos:</strong> dirección IP, navegador/dispositivo, páginas visitadas, tiempos de respuesta y eventos de seguridad.</li>
      <li><strong>Datos de tráfico y operación (si aplica):</strong> registros técnicos asociados a llamadas/sesiones (por ejemplo CDR y eventos de señalización) necesarios para operación, calidad, seguridad y facturación.</li>
      <li><strong>Grabaciones:</strong> si el servicio contratado habilita grabación, se procesan y almacenan según la configuración del cliente y la normativa aplicable.</li>
    </ul>

    <h2>4. Finalidades del tratamiento</h2>
    <ul class="list">
      <li>Atender consultas, solicitudes y cotizaciones.</li>
      <li>Provisionar, operar y administrar los servicios contratados.</li>
      <li>Monitorear desempeño, calidad (latencia, error rate, degradaciones) y continuidad del servicio.</li>
      <li>Brindar soporte, diagnóstico de incidentes y mejora continua.</li>
      <li>Seguridad: prevención de fraude, abuso, accesos no autorizados e investigación de eventos.</li>
      <li>Facturación, conciliación y cumplimiento de obligaciones contables/tributarias cuando corresponda.</li>
      <li>Cumplimiento de requerimientos legales o regulatorios aplicables.</li>
    </ul>

    <h2>5. Bases y legitimación</h2>
    <p>
      Tratamos datos personales según corresponda para: (i) gestionar medidas precontractuales (cotización) y/o ejecutar un contrato,
      (ii) cumplir obligaciones legales, (iii) atender un consentimiento cuando aplique, y/o (iv) proteger intereses legítimos vinculados
      a seguridad, continuidad operativa y mejora del servicio.
    </p>

    <h2>6. Encargados, proveedores y terceros</h2>
    <p>
      Podemos compartir datos con proveedores que nos prestan servicios necesarios para operar (por ejemplo: hosting, correo,
      monitoreo/observabilidad, herramientas de soporte), así como con operadores y socios de interconexión cuando sea necesario
      para el enrutamiento/terminación de comunicaciones. También podremos divulgar información ante requerimientos legales válidos
      de autoridades competentes.
    </p>

    <h2>7. Transferencias internacionales</h2>
    <p>
      Algunos proveedores tecnológicos pueden almacenar o procesar información fuera de Panamá. En esos casos, aplicamos medidas
      razonables para proteger los datos (por ejemplo, acuerdos con proveedores, controles de acceso y cifrado cuando corresponde).
    </p>

    <h2>8. Conservación</h2>
    <p>
      Conservamos los datos durante el tiempo necesario para las finalidades descritas y conforme a obligaciones legales aplicables.
      En términos generales: solicitudes comerciales se conservan por un periodo razonable para dar seguimiento; datos de operación
      (métricas, eventos y registros técnicos) se conservan por periodos acotados para diagnóstico, seguridad y facturación cuando aplica.
    </p>

    <h2>9. Derechos de los titulares</h2>
    <p>
      Puedes solicitar acceso, rectificación, actualización, oposición y supresión de tus datos, según la normativa aplicable en Panamá.
      Para ejercer tus derechos, contáctanos en
      <a class="text-link" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@vozelia.com.pa">info@vozelia.com.pa</a>.
      Si consideras que tu solicitud no fue atendida, podrás acudir ante la Dirección de Protección de Datos Personales de la ANTAI.
    </p>

    <h2>10. Seguridad</h2>
    <p>
      Implementamos medidas técnicas y organizativas razonables para proteger la información (controles de acceso, monitoreo,
      registro de eventos, respaldo y prácticas de seguridad). Aun así, ningún sistema es completamente inmune a riesgos.
    </p>

    <h2>11. Cookies y tecnologías similares</h2>
    <p>
      Utilizamos cookies y almacenamiento local para funciones esenciales (por ejemplo: sesión, seguridad y preferencias). Si en el futuro
      habilitamos analítica avanzada o marketing, informaremos sobre su uso y, cuando aplique, habilitaremos mecanismos de control.
    </p>

    <h2>12. Cambios a esta Política</h2>
    <p>
      Podremos actualizar esta Política para reflejar cambios operativos o legales. Publicaremos la versión vigente en esta misma página.
    </p>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
