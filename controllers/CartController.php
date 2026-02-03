<?php
require_once __DIR__ . '/../models/Product.php';
class CartController {
    private function initCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }
    public function view() {
        $this->initCart();
        $items = [];
        $total = 0;
        foreach ($_SESSION['cart'] as $productId => $qty) {
            $product = Product::findById($productId);
            if ($product) {
                $sub = $product['price'] * $qty;
                $total += $sub;
                $items[] = [
                    'product' => $product,
                    'qty' => $qty,
                    'subtotal' => $sub
                ];
            }
        }
        require __DIR__ . '/../views/cart/view.php';
    }
    public function add() {
        $this->initCart();
        $id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($id > 0 && $qty > 0) {
            if (!isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id] = 0;
            }
            $_SESSION['cart'][$id] += $qty;
        }
        redirect('index.php?controller=cart&action=view');
    }
    public function remove() {
        $this->initCart();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        redirect('index.php?controller=cart&action=view');
    }
    public function clear() {
        $_SESSION['cart'] = [];
        redirect('index.php?controller=cart&action=view');
    }
}
