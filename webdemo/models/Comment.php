<?php
class Comment {
    private $conn;

    public function __construct() {
        require_once __DIR__ . '/../database/Database.php';
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    // ✅ Lấy bình luận theo sản phẩm (chỉ hiện bình luận đã duyệt)
    public function getByProductId($product_id) {
        $stmt = $this->conn->prepare("
            SELECT c.comment_id, c.product_id, c.username, c.content, c.created_at 
            FROM comments c
            WHERE c.product_id = ? AND c.status = 1
            ORDER BY c.created_at DESC
        ");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Thêm bình luận (dùng username)
    public function add($product_id, $username, $content) {
        $stmt = $this->conn->prepare("
            INSERT INTO comments (product_id, username, content, created_at, status) 
            VALUES (?, ?, ?, NOW(), 1)
        ");
        return $stmt->execute([$product_id, $username, $content]);
    }

    // ✅ Lấy tất cả bình luận (cho admin)
    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT c.comment_id, c.product_id, c.username, c.content, c.status, c.created_at, 
                   p.name AS product_name
            FROM comments c
            JOIN products p ON c.product_id = p.id
            ORDER BY c.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Cập nhật trạng thái (ẩn/hiện)
    public function updateStatus($commentId) {
        // Lấy trạng thái hiện tại
        $stmt = $this->conn->prepare("SELECT status FROM comments WHERE comment_id = ?");
        $stmt->execute([$commentId]);
        $current = $stmt->fetchColumn();

        // Đảo trạng thái
        $newStatus = ($current == 1) ? 0 : 1;

        $stmt = $this->conn->prepare("UPDATE comments SET status = ? WHERE comment_id = ?");
        return $stmt->execute([$newStatus, $commentId]);
    }

    // ✅ Xóa bình luận
    public function delete($comment_id) {
        $stmt = $this->conn->prepare("DELETE FROM comments WHERE comment_id = ?");
        return $stmt->execute([$comment_id]);
    }
}
