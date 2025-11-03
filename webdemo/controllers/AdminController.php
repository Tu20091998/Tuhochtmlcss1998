<?php
class AdminController {
    private $productModel;
    private $userModel;
    private $orderModel;

    public function __construct() {
        require_once 'models/Product.php';
        require_once 'models/User.php';
        require_once 'models/Order.php';

        $this->productModel = new Product();
        $this->userModel = new User();
        $this->orderModel = new Order();
    }

    public function dashboard() {
        include 'views/admin/dashboard.php';
    }

    // --- PRODUCTS ---
    public function manageProducts() {
        $products = $this->productModel->getAll();
        include 'views/admin/products.php';
    }

    public function deleteProduct($id) {
        $this->productModel->delete($id);
        header('Location: index.php?page=admin&action=products');
        exit;
    }

    public function showAddProductForm() {
        include 'views/admin/product_add.php';
    }

    public function addProduct($data) {
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $price = floatval($data['price'] ?? 0);
        $image = trim($data['image'] ?? '');
        $this->productModel->create($name, $description, $price, $image);

        header('Location: index.php?page=admin&action=products');
        exit;
    }

    public function showUpdateProductForm($id) {
        $product = $this->productModel->find($id);
        include 'views/admin/product_edit.php';
    }

    public function updateProduct($id, $data) {
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $price = floatval($data['price'] ?? 0);
        $image = trim($data['image'] ?? '');
        $this->productModel->update($id, $name, $description, $price, $image);

        header('Location: index.php?page=admin&action=products');
        exit;
    }

    // --- USERS ---
    public function manageUsers() {
        $users = $this->userModel->getAll();
        include 'views/admin/users.php';
    }

    // --- ORDERS ---
    public function manageOrders() {
        $orders = $this->orderModel->getAll();
        include 'views/admin/orders.php';
    }

    public function updateOrderStatus($id, $status) {
        $this->orderModel->updateStatus($id, $status);
        header('Location: index.php?page=admin&action=orders');
        exit;
    }

    public function showUpdateOrderForm($id) {
        $order = $this->orderModel->getById($id); // Sửa getByUser -> getById
        include 'views/admin/update_order_status.php';
    }

    public function orderDetail($id) {
        $order = $this->orderModel->getById($id);
        $orderItems = $this->orderModel->getItemsByOrderId($id);

        if (!$order) {
            echo "Không tìm thấy đơn hàng";
            return;
        }

        include 'views/admin/order_detail.php';
    }
    public function manageComments() {
    require_once 'models/Comment.php';
    $model = new Comment();
    $comments = $model->getAll();
    include 'views/admin/comments.php';
}

public function toggleComment() {
    require_once 'models/Comment.php';
    $model = new Comment();

    if (isset($_GET['comment_id']) && isset($_GET['status'])) {
        $id = $_GET['comment_id'];
        $status = $_GET['status'];
        $model->updateStatus($id, $status);
    }
    header("Location: index.php?controller=admin&action=manageComments");
}

public function deleteComment() {
    require_once 'models/Comment.php';
    $model = new Comment();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $model->delete($id);
    }
    header("Location: index.php?controller=admin&action=manageComments");
}

}
