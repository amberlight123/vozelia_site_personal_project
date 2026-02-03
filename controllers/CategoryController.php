<?php
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Product.php';
class CategoryController {
    public function list() {
        $categories = Category::all();
        require __DIR__ . '/../views/categories/list.php';
    }
    public function show() {
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
        if (!$slug) {
            redirect('index.php?controller=category&action=list');
        }
        $category = Category::findBySlug($slug);
        if (!$category) {
            redirect('index.php?controller=category&action=list');
        }
        $products = Product::byCategoryId($category['id']);
        require __DIR__ . '/../views/categories/show.php';
    }
}
