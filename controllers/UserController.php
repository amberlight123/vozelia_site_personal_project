<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Address.php';
class UserController {
    public function profile() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $user = User::findById($_SESSION['user_id']);
        if (!$user) {
        session_destroy();
        redirect('index.php?controller=auth&action=showLogin');
}

        require __DIR__ . '/../views/user/profile.php';
    }
    public function updateProfile() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        User::updateProfile($_SESSION['user_id'], $name, $phone, $address);
        redirect('index.php?controller=user&action=profile');
    }
    public function addresses() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $addresses = Address::byUser($_SESSION['user_id']);
        require __DIR__ . '/../views/user/addresses.php';
    }
    public function addAddress() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $label = isset($_POST['label']) ? trim($_POST['label']) : '';
        $address = isset($_POST['address']) ? trim($_POST['address']) : '';
        if ($label !== '' && $address !== '') {
            Address::create($_SESSION['user_id'], $label, $address);
        }
        redirect('index.php?controller=user&action=addresses');
    }
    public function deleteAddress() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            Address::delete($id, $_SESSION['user_id']);
        }
        redirect('index.php?controller=user&action=addresses');
    }
}
