<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 class="text-center text-success mb-4">🧾 Quản lý đơn hàng</h2>

<div class="container">
  <div class="card shadow rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Người đặt</th>
              <th>Tổng tiền</th>
              <th>Ngày đặt</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require_once 'models/Order.php';
            $orderModel = new Order();
            $orders = $orderModel->getAll();

            $statusOptions = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'completed' => 'Hoàn tất',
                'cancelled' => 'Đã hủy'
            ];

            foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['user_id'] ?></td>
                    <td><?= number_format($order['total'], 0, ',', '.') ?>₫</td>
                    <td><?= date("d/m/Y H:i", strtotime($order['created_at'])) ?></td>
                    <td>
                        <span class="badge 
                            <?= $order['status'] == 0 ? 'bg-warning text-dark' : 
                               ($order['status'] == 1 ? 'bg-primary' : 'bg-success') ?>">
                            <?= $statusOptions[$order['status']] ?? 'Không xác định' ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?page=admin&action=updateOrderStatus&id=<?= $order['id'] ?>" 
                           class="btn btn-warning btn-sm">
                            Cập nhật trạng thái
                        </a>
                        <a href="index.php?page=admin&action=orderDetail&id=<?= $order['id'] ?>" 
                           class="btn btn-info btn-sm">
                            Xem
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
