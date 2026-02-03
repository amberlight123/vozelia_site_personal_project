<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Review.php';
class ProductController {
    public function list() {
        $categories = Category::all();
        $term = isset($_GET['q']) ? trim($_GET['q']) : '';
        if ($term !== '') {
            $products = Product::search($term);
        } else {
            $products = Product::allActive();
        }
        require __DIR__ . '/../views/products/list.php';
    }
    public function detail() {
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
        if (!$slug) {
            redirect('index.php?controller=product&action=list');
        }
        $product = Product::findBySlug($slug);
        if (!$product) {
            redirect('index.php?controller=product&action=list');
        }
        $reviews = Review::byProduct($product['id']);
        require __DIR__ . '/../views/products/detail.php';
    }
    public function addReview() {
        if (!is_logged_in()) {
            redirect('index.php?controller=auth&action=showLogin');
        }
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        if ($productId > 0 && $rating >= 1 && $rating <= 5) {
            Review::create($_SESSION['user_id'], $productId, $rating, $comment);
        }
        $product = Product::findById($productId);
        if ($product) {
            redirect('index.php?controller=product&action=detail&slug=' . urlencode($product['slug']));
        } else {
            redirect('index.php?controller=product&action=list');
        }
    }
}
