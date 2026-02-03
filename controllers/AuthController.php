<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function showLogin() {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            Obs::event('login_success', 'info', ['role' => $user['role']], ['user_id' => (string)$user['id']]);

            // Contexto: un usuario real entra a operar, no a “ver productos”.
            if ($user['role'] === 'admin') {
                redirect('index.php?controller=admin&action=dashboard');
            }
            redirect('index.php?controller=user&action=profile');
        }

        Obs::metric('login_failed_total', 1);
        $error = 'Correo o contraseña incorrectos';
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister() {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function register() {
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';

        if (User::findByEmail($email)) {
            $error = 'El correo ya está registrado';
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        User::create($name, $email, $password, $phone, $address);
        Obs::event('register_success', 'info', [], ['email' => $email]);
        redirect('index.php?controller=auth&action=showLogin');
    }

    public function logout() {
        session_destroy();
        redirect('index.php?controller=pages&action=home');
    }
}
