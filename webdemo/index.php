<?php
session_start();
date_default_timezone_set('UTC');

require_once __DIR__ . '/database/Database.php';

// Autoload classes
spl_autoload_register(function ($class) {
    foreach (['controllers/', 'models/'] as $dir) {
        $file = __DIR__ . '/' . $dir . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

function redirect($url) {
    header("Location: $url");
    exit;
}

// Lấy tham số từ URL
$page = $_GET['page'] ?? 'products';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

// Khởi tạo controller
$authController    = new AuthController();
$productController = new ProductController();
$cartController    = new CartController();
$orderController   = new OrderController();
$adminController   = new AdminController();

// Routing
switch ($page) {
    case 'login':
        ($_SERVER['REQUEST_METHOD'] === 'POST') ? $authController->login($_POST) : $authController->showLogin();
        break;

    case 'register':
        ($_SERVER['REQUEST_METHOD'] === 'POST') ? $authController->register($_POST) : $authController->showRegister();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'products':
        switch ($action) {
            case 'add':
                if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
                ($_SERVER['REQUEST_METHOD'] === 'POST') ? $productController->addProduct($_POST) : $productController->showAddForm();
                break;

            case 'detail':
                if ($id) $productController->showDetail($id);
                break;

            case 'search':
                $productController->searchFilter();
                break;

            case 'update':
                if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
                if ($id) {
                    ($_SERVER['REQUEST_METHOD'] === 'POST') ?
                        $productController->updateProduct($id, $_POST) :
                        $productController->showUpdateForm($id);
                }
                break;

            case 'delete':
                if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
                if ($id) {
                    ($_SERVER['REQUEST_METHOD'] === 'POST') ?
                        $adminController->deleteProduct($id) :
                        $productController->showDeleteConfirmation($id);
                }
                break;

            default:
                $keyword = $_GET['q'] ?? null;
                $productController->showList(trim($keyword));
                break;
        }
        break;

    case 'cart':
        switch ($action) {
            case 'add':
                if ($id) $cartController->add($id);
                break;

            case 'remove':
                if ($id) $cartController->remove($id);
                break;

            case 'checkout':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $orderController->placeOrder($_POST);
                }
                break;

            default:
                $cartController->showCart();
                break;
        }
        break;

    case 'orders':
        $orderController->showOrders();
        break;
    case 'comment':
    require_once 'controllers/CommentController.php';
    $commentController = new CommentController();

    switch ($action) {
        case 'addComment':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $commentController->addComment();
            }
            break;

        case 'manage':
            $commentController->manage();
            break;

        case 'toggleStatus':
            $commentController->toggleStatus();
            break;
    }
    break;


    case 'admin':
        switch ($action) {
            case 'products':
                $adminController->manageProducts();
                break;

            case 'users':
                $adminController->manageUsers();
                break;

            case 'orders':
                $adminController->manageOrders();
                break;

            case 'delete_product':
                if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
                if ($id) $adminController->deleteProduct($id);
                break;
            
            case 'update_product':
                if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
                if ($id) {
                    ($_SERVER['REQUEST_METHOD'] === 'POST') ?
                        $adminController->updateProduct($id, $_POST) :
                        $adminController->showUpdateProductForm($id);
                }
                break;
            case 'comments':
    $adminController->manageComments();
    break;

            
            case 'orderDetail':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            $adminController->orderDetail($id);
            break;

            case 'updateOrderStatus':
        if (!isset($_SESSION['user_id'])) redirect("index.php?page=login");
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? null;
            $adminController->updateOrderStatus($id, $status);
        } else {
            $adminController->showUpdateOrderForm($id);
        }
    break;
            

            default:
                $adminController->dashboard();
                break;
        }
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
