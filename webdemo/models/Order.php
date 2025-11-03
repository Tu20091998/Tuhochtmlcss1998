<?php
class Order {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($user_id, $total, $items) {
    $this->db->beginTransaction();
    try {
        // Lưu đơn hàng với status mặc định là pending
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
        $stmt->execute([$user_id, $total]);
        $order_id = $this->db->lastInsertId();

        $stmtItem = $this->db->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
        );
        foreach ($items as $item) {
            $stmtItem->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        $this->db->commit();
        return $order_id;
    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}
    public function updateStatus($id, $status) {
    $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
    return $stmt->execute([$status, $id]);
}



    public function getByUser($user_id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $stmtItems = $this->db->prepare(
                "SELECT oi.*, p.name FROM order_items oi 
                 JOIN products p ON oi.product_id = p.id 
                 WHERE oi.order_id = ?"
            );
            $stmtItems->execute([$order['id']]);
            $order['items'] = $stmtItems->fetchAll();
        }
        return $orders;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM orders ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getItemsByOrderId($orderId)
{
    $stmt = $this->db->prepare("
        SELECT oi.*, p.name, p.image
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ");
    $stmt->execute([$orderId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
