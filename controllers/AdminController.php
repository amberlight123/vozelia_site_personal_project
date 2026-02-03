<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Lead.php';

class AdminController {
    private function ensureAdmin() {
        if (!is_admin()) {
            redirect('index.php?controller=product&action=list');
        }
    }

    public function dashboard() {
        $this->ensureAdmin();
        $orders = Order::all();
        $products = Product::allAdmin();
        // Presión: backlog de leads y SLA vencidos
        $leads = Lead::all();
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function leads() {
        $this->ensureAdmin();
        $leads = Lead::all();
        require __DIR__ . '/../views/admin/leads.php';
    }

    public function markLeadFirstResponse() {
        $this->ensureAdmin();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id > 0) {
            Lead::markFirstResponse($id);
        }
        redirect('index.php?controller=admin&action=leads');
    }

    public function products() {
        $this->ensureAdmin();
        $products = Product::allAdmin();
        require __DIR__ . '/../views/admin/products.php';
    }

    public function productForm() {
        $this->ensureAdmin();
        $categories = Category::all();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = null;
        if ($id > 0) {
            $product = Product::findById($id);
        }
        require __DIR__ . '/../views/admin/product_form.php';
    }

    public function saveProduct() {
        $this->ensureAdmin();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $data = [
            'category_id' => (int)$_POST['category_id'],
            'name' => trim($_POST['name']),
            'slug' => trim($_POST['slug']),
            'description' => trim($_POST['description']),
            'price' => (float)$_POST['price'],
            'stock' => (int)$_POST['stock'],
            'image' => trim($_POST['image']),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];
        if ($id > 0) {
            Product::update($id, $data);
        } else {
            Product::create($data);
        }
        redirect('index.php?controller=admin&action=products');
    }

    public function deleteProduct() {
        $this->ensureAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            Product::delete($id);
        }
        redirect('index.php?controller=admin&action=products');
    }

    public function orders() {
        $this->ensureAdmin();
        $orders = Order::all();
        require __DIR__ . '/../views/admin/orders.php';
    }

    public function updateOrderStatus() {
        $this->ensureAdmin();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : 'pending';
        if ($id > 0) {
            Order::updateStatus($id, $status);
        }
        redirect('index.php?controller=admin&action=orders');
    }

    public function users() {
        $this->ensureAdmin();
        $users = User::all();
        require __DIR__ . '/../views/admin/users.php';
    }
}
