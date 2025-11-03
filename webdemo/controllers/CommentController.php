<?php
class CommentController {
    // ✅ Thêm bình luận
    public function addComment() {
        session_start();
        if (!isset($_SESSION['username'])) {   // kiểm tra username trong session
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/Comment.php';
            $commentModel = new Comment();

            $product_id = $_POST['product_id'];
            $username   = $_SESSION['username'];   // lấy username từ session
            $content    = $_POST['content'];

            if (!empty($content)) {
                $commentModel->add($product_id, $username, $content);
            }

            // Quay lại trang chi tiết sản phẩm
            header("Location: index.php?controller=product&action=showDetail&id=" . $product_id);
            exit();
        }
    }

    // ✅ Admin quản lý bình luận
    public function manage() {
        require_once 'models/Comment.php';
        $commentModel = new Comment();
        $comments = $commentModel->getAll();
        include 'views/admin/comments.php';
    }

    // ✅ Ẩn/hiện bình luận
    public function toggleStatus() {
    if (isset($_GET['comment_id'])) {
        require_once 'models/Comment.php';
        $commentModel = new Comment();

        $comment_id = $_GET['comment_id'];

        // lấy status hiện tại từ DB
        $comments = $commentModel->getAll();
        $currentStatus = null;
        foreach ($comments as $c) {
            if ($c['comment_id'] == $comment_id) {
                $currentStatus = $c['status'];
                break;
            }
        }

        // nếu tìm thấy thì đảo trạng thái
        if ($currentStatus !== null) {
            $newStatus = ($currentStatus == 1) ? 0 : 1;
            $commentModel->updateStatus($comment_id, $newStatus);
        }
    }

    header("Location: index.php?controller=comment&action=manage");
    exit();
}

}
