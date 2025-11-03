<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-success mb-4">Chi tiết đơn hàng #<?= $order['id'] ?></h2>
    <p><strong>Người đặt:</strong> <?= $order['user_id'] ?></p>
    <p><strong>Ngày đặt:</strong> <?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></p>
    <p><strong>Trạng thái:</strong> 
        <?php
$statusLabels = [
    'pending'   => 'Chờ xử lý',
    'confirmed' => 'Đã xác nhận',
    'completed' => 'Hoàn tất'
];
$status = isset($order['status']) ? $order['status'] : null;
echo isset($statusLabels[$status]) ? $statusLabels[$status] : 'Không rõ';
?>

    </p>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><img src="uploads/<?= $item['image'] ?>" width="60"></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h5 class="text-end mt-3 text-danger">
                Tổng tiền: <?= number_format($order['total'], 0, ',', '.') ?>₫
            </h5>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
