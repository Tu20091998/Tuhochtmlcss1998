<?php
class CartController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add($product_id) {
        $product = $this->productModel->find($product_id);
        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            exit;
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
        header("Location: index.php?page=cart");
        exit;
    }

    public function remove($product_id) {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        header("Location: index.php?page=cart");
        exit;
    }

    public function showCart() {
        $items = [];
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            $product = $this->productModel->find($product_id);
            if ($product) {
                $product['quantity'] = $qty;
                $product['subtotal'] = $qty * $product['price'];
                $items[] = $product;
                $total += $product['subtotal'];
            }
        }
        require __DIR__ . '/../views/cart/view.php';
    }
}
