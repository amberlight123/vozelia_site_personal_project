<?php
require_once __DIR__ . '/../models/Subscription.php';
class SubscriptionController {
    public function form() {
        require __DIR__ . '/../views/subscription/form.php';
    }
    public function subscribe() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        if ($email !== '') {
            Subscription::create($email);
            require __DIR__ . '/../views/subscription/success.php';
        } else {
            $error = 'Correo requerido';
            require __DIR__ . '/../views/subscription/form.php';
        }
    }
}
