<?php
class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

 public function showList() {
    $keyword = isset($_GET['q']) ? trim($_GET['q']) : null;
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = 9;
    $offset = ($currentPage - 1) * $limit;

    $pdo = Database::getInstance()->getConnection();

    $sql = "SELECT * FROM products";
    $countSql = "SELECT COUNT(*) FROM products";

    $likeKeyword = null;

    if (!empty($keyword)) {
        $sql .= " WHERE name LIKE :kw1 OR description LIKE :kw2";
        $countSql .= " WHERE name LIKE :kw1 OR description LIKE :kw2";
        $likeKeyword = '%' . $keyword . '%';
    }

    $sql .= " LIMIT $limit OFFSET $offset";

    // Truy vấn sản phẩm
    $stmt = $pdo->prepare($sql);
    if (!empty($keyword)) {
        $stmt->bindValue(':kw1', $likeKeyword, PDO::PARAM_STR);
        $stmt->bindValue(':kw2', $likeKeyword, PDO::PARAM_STR);
    }
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Đếm tổng sản phẩm
    $countStmt = $pdo->prepare($countSql);
    if (!empty($keyword)) {
        $countStmt->bindValue(':kw1', $likeKeyword, PDO::PARAM_STR);
        $countStmt->bindValue(':kw2', $likeKeyword, PDO::PARAM_STR);
    }
    $countStmt->execute();
    $totalProducts = $countStmt->fetchColumn();

    $totalPages = ceil($totalProducts / $limit);

    require 'views/products/list.php';
}





    public function searchFilter() {
    $keyword = isset($_GET['q']) ? trim($_GET['q']) : null;
    $this->showList($keyword);
    }


    public function showDetail($id) {
        $product = $this->productModel->find($id);
        if (!$product) {
            http_response_code(404);
            echo "Product not found";
            exit;
        }
        // Lấy danh sách bình luận của sản phẩm
    require_once __DIR__ . '/../models/Comment.php';
    $commentModel = new Comment();
    $comments = $commentModel->getByProductId($id);

    require __DIR__ . '/../views/products/detail.php';
    }

    public function showAddForm($errors = [], $old = []) {
        require __DIR__ . '/../views/products/add.php';
    }

    public function addProduct($data) {
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $price = trim($data['price'] ?? '');
        $image = trim($data['image'] ?? '');

        $errors = [];

        if (!$name) $errors[] = "Product name is required.";
        if (!$description) $errors[] = "Product description is required.";
        if (!$price || !is_numeric($price) || floatval($price) < 0) $errors[] = "Valid price is required.";
        if (!$image) $errors[] = "Image URL is required.";

        if ($errors) {
            $this->showAddForm($errors, $data);
            return;
        }

        $price = floatval($price);
        
        $inserted = $this->productModel->create($name, $description, $price, $image);

        if ($inserted) {
            header("Location: index.php?page=products");
            exit;
        } else {
            $errors[] = "Failed to add product, try again.";
            $this->showAddForm($errors, $data);
        }
    }

    public function search() {
        $results = [];
        $keyword = trim($_GET['q'] ?? ''); // Sử dụng 'q' để tương thích với URL

        if ($keyword) {
            $results = $this->productModel->search($keyword);
        }

        require_once __DIR__ . '/../views/products/search.php'; // Sửa đường dẫn
    }

    public function showUpdateForm($id){
        $product = $this->productModel->find($id);
        if (!$product) {
            $_SESSION['error'] = "Product not found.";
            header("Location: index.php?page=products");
            exit;
        }
        require __DIR__ . '/../views/products/update.php';
    }
    public function updateProduct($id, $data) {
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $price = trim($data['price'] ?? '');
        $image = trim($data['image'] ?? '');

        $errors = [];

        if (!$name) $errors[] = "Product name is required.";
        if (!$description) $errors[] = "Product description is required.";
        if (!$price || !is_numeric($price) || floatval($price) < 0) $errors[] = "Valid price is required.";
        if (!$image) $errors[] = "Image URL is required.";

        // Nếu có lỗi, hiển thị lại form với thông tin đã nhập
        if ($errors) {
            // Lấy thông tin sản phẩm để hiển thị lại
            $product = $this->productModel->find($id);
            require __DIR__ . '/../views/products/update.php';
            return;
        }

        $price = floatval($price);

        $updated = $this->productModel->update($id, $name, $description, $price, $image);

        if ($updated) {
            $_SESSION['message'] = "Product updated successfully.";
            header("Location: index.php?page=products");
            exit;
        } else {
            $errors[] = "Failed to update product, try again.";
            // Lấy thông tin sản phẩm để hiển thị lại
            $product = $this->productModel->find($id);
            require __DIR__ . '/../views/products/update.php';
        }
    }


}
