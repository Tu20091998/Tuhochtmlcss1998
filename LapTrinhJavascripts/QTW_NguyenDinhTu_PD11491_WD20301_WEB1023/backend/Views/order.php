<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin</title>
    <link rel="stylesheet" href="../Css/orders.css"> <!-- CSS riêng cho admin -->
</head>
<body>
    <div class="container">
        <h2>Quản lý đơn hàng</h2> <!-- Đổi tiêu đề -->
        
        <!-- Phần thông báo (giữ nguyên) -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (empty($orders)): ?>
            <div class="alert info">Không có đơn hàng nào</div>
        <?php else: ?>
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Khách hàng</th> <!-- Thêm cột mới -->
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['order_id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</td>
                        
                        <td>
                            <form action="../Controllers/BaseController.php?action=order_update_status" method="POST">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <?php
                                    $statuses = ['Chờ xử lý', 'Đang giao hàng', 'Đã giao hàng', 'Đã hủy', 'Hoàn trả'];
                                    foreach ($statuses as $status) {
                                        $selected = ($order['status'] == $status) ? 'selected' : '';
                                        echo "<option value=\"$status\" $selected>$status</option>";
                                    }
                                    ?>
                                </select>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($order['user_id'] ?? 'Khách vãng lai') ?></td> <!-- Hiển thị tên KH -->
                        <td class="actions">
                            <a href="../Controllers/BaseController.php?action=order_detail&id=<?= $order['order_id'] ?>" 
                                class="btn detail">Chi tiết</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>