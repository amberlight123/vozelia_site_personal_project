<?php
require_once __DIR__ . '/../models/Lead.php';

class ContactController
{
    public function send(): void
    {
        $data = [
            'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
            'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
            'phone' => isset($_POST['phone']) ? trim($_POST['phone']) : null,
            'company' => isset($_POST['company']) ? trim($_POST['company']) : null,
            'service' => isset($_POST['service']) ? trim($_POST['service']) : null,
            'pbx' => isset($_POST['pbx']) ? trim($_POST['pbx']) : null,
            'extensions' => isset($_POST['extensions']) ? trim($_POST['extensions']) : null,
            'concurrent_channels' => isset($_POST['concurrent_channels']) ? trim($_POST['concurrent_channels']) : null,
            'destinations' => isset($_POST['destinations']) ? trim($_POST['destinations']) : null,
            'subject' => isset($_POST['subject']) ? trim($_POST['subject']) : '',
            'message' => isset($_POST['message']) ? trim($_POST['message']) : '',
        ];

        // PILAR 4: presión. Si llega basura o incompleto, es un “incidente de calidad de entrada”.
        if ($data['name'] !== '' && $data['email'] !== '' && $data['message'] !== '') {
            $lead = Lead::create($data);
            Obs::metric('lead_created_total', 1);
            require __DIR__ . '/../views/contact/success.php';
            return;
        }

        Obs::metric('lead_rejected_total', 1);
        Obs::alert('LEAD_VALIDATION_FAIL', 'warning', 'Lead incompleto (faltan campos obligatorios)');

        $error = 'Completa los campos obligatorios (nombre, correo y mensaje).';
        require __DIR__ . '/../views/pages/contacto.php';
    }
}
