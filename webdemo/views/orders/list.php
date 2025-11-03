<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container py-5">
  <h1 class="mb-4">Your Orders</h1>

  <?php if (isset($_SESSION['order_success'])): ?>
    <div class="alert alert-success" role="alert" aria-live="polite">
      <?= htmlspecialchars($_SESSION['order_success']) ?>
    </div>
    <?php unset($_SESSION['order_success']); ?>
  <?php endif; ?>

  <?php if (empty($orders)): ?>
    <div class="alert alert-info" role="alert">
      You have not placed any orders yet. <a href="index.php?page=products" class="alert-link">Start shopping</a>.
    </div>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <h2 class="card-title">
          Order #<?= $order['id'] ?> 
          <small class="text-muted" style="font-weight: normal; font-size: 0.9rem;">
            placed on <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?>
          </small>
        </h2>

        <!-- Trạng thái đơn hàng -->
        <p>
          Status: 
          <?php if ($order['status'] === 'pending'): ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php elseif ($order['status'] === 'completed'): ?>
            <span class="badge bg-success">Completed</span>
          <?php elseif ($order['status'] === 'cancelled'): ?>
            <span class="badge bg-danger">Cancelled</span>
          <?php else: ?>
            <span class="badge bg-secondary"><?= htmlspecialchars($order['status']) ?></span>
          <?php endif; ?>
        </p>

        <table class="table table-bordered mt-3" aria-label="Order Items">
          <thead class="table-light">
            <tr>
              <th>Product</th>
              <th style="width: 80px;">Quantity</th>
              <th style="width: 100px;">Price</th>
              <th style="width: 110px;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($order['items'] as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td><?= (int)$item['quantity'] ?></td>
              <td>$<?= number_format($item['price'], 2) ?></td>
              <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p class="text-end fw-bold fs-5 mt-3">Order Total: $<?= number_format($order['total'], 2) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
