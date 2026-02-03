<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
class OrderController {
    private function ensureCart() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            redirect('index.php?controller=product&action=list');
        }
    }
    public function checkout() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $this->ensureCart();
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
        require __DIR__ . '/../views/orders/checkout.php';
    }
    public function place() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $this->ensureCart();
        $pdo = getConnection();
        $pdo->beginTransaction();
        try {
            $total = 0;
            foreach ($_SESSION['cart'] as $productId => $qty) {
                $product = Product::findById($productId);
                if ($product) {
                    $total += $product['price'] * $qty;
                }
            }
            $orderId = Order::create($_SESSION['user_id'], $total);
            foreach ($_SESSION['cart'] as $productId => $qty) {
                $product = Product::findById($productId);
                if ($product) {
                    $unitPrice = $product['price'];
                    $sub = $unitPrice * $qty;
                    OrderItem::create($orderId, $productId, $qty, $unitPrice, $sub);
                }
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            require __DIR__ . '/../views/orders/success.php';
        } catch (Exception $e) {
            $pdo->rollBack();
            if (class_exists('Obs')) {
                Obs::event('order_place_error', 'error', [], ['message' => $e->getMessage()]);
                Obs::alert('ORDER_PLACE_ERROR', 'warning', 'Error al procesar el pedido');
            }
            http_response_code(500);
            echo 'Error al procesar el pedido. Ref: ' . htmlspecialchars(Obs::requestId());
        }
    }
    public function history() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $orders = Order::byUser($_SESSION['user_id']);
        require __DIR__ . '/../views/orders/history.php';
    }
}
