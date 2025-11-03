<?php
class OrderController {
    private $orderModel;
    private $productModel;

    public function __construct() {
        require_once 'models/Order.php';
        require_once 'models/Product.php';
        $this->orderModel = new Order();
        $this->productModel = new Product();
    }

    // --- USER: Đặt hàng ---
    public function placeOrder($data) {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if (empty($_SESSION['cart'])) {
            $_SESSION['order_error'] = "Your cart is empty.";
            header("Location: index.php?page=cart");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $cart = $_SESSION['cart'];

        $total = 0;
        $items = [];

        foreach ($cart as $product_id => $qty) {
            $product = $this->productModel->find($product_id);
            if (!$product) continue;

            $subtotal = $qty * $product['price'];
            $total += $subtotal;
            $items[] = [
                'product_id' => $product_id,
                'quantity' => $qty,
                'price' => $product['price'],
            ];
        }

        if (count($items) === 0) {
            $_SESSION['order_error'] = "No valid products in cart.";
            header("Location: index.php?page=cart");
            exit;
        }

        $order_id = $this->orderModel->create($user_id, $total, $items);

        unset($_SESSION['cart']);
        $_SESSION['order_success'] = "Order #$order_id placed successfully!";
        header("Location: index.php?page=orders");
        exit;
    }

    // --- USER: Xem đơn hàng ---
    public function showOrders() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
        $user_id = $_SESSION['user_id'];
        $orders = $this->orderModel->getByUser($user_id);
        require __DIR__ . '/../views/orders/list.php';
    }

    // --- ADMIN: Xem chi tiết đơn ---
    public function orderDetail() {
        if (!isset($_GET['id'])) {
            die("Thiếu ID đơn hàng");
        }

        $orderId = (int)$_GET['id'];
        $order = $this->orderModel->getById($orderId);
        $orderItems = $this->orderModel->getItemsByOrderId($orderId);

        include 'views/admin/order_detail.php';
    }

    // --- ADMIN: Cập nhật trạng thái đơn ---
    public function updateOrderStatus($id, $status) {
        $this->orderModel->updateStatus($id, $status);
        header('Location: index.php?page=admin&action=orders');
        exit;
    }

    // --- ADMIN: Form cập nhật trạng thái ---
    public function showUpdateOrderForm($id) {
        $order = $this->orderModel->getById($id);
        include 'views/admin/update_order_status.php';
    }
}
