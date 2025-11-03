<?php
class Product {
    private $db;
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($name, $description, $price, $image) {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)  ");
        return $stmt->execute([$name, $description, $price, $image]);
    }
    public function update($id, $name, $description, $price, $image) {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $price, $image, $id]);
    }
    public function getPaginated($page = 1, $perPage = 9) {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->db->prepare("SELECT * FROM products LIMIT :offset, :perPage");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countAll() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM products");
        return $stmt->fetchColumn();
    }
    public function search($keyword) {
    $pdo = Database::getInstance()->getConnection();
    $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE :keyword OR description LIKE :keyword");
    $likeKeyword = "%" . $keyword . "%";
    $stmt->bindValue(':keyword', $likeKeyword, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
