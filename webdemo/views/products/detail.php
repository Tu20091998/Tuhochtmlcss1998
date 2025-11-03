<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container py-5">

  <!-- Nút quay lại -->
  <div class="mb-4">
    <a href="javascript:history.back()" class="btn btn-outline-secondary">
      ⬅ Quay lại
    </a>
  </div>

  <!-- Chi tiết sản phẩm -->
  <div class="row g-4 mb-5">
    <!-- Ảnh sản phẩm -->
    <div class="col-md-6 text-center">
      <div class="card border-0 shadow-lg rounded-4">
        <img src="<?= htmlspecialchars($product['image']) ?>" 
             alt="<?= htmlspecialchars($product['name']) ?>" 
             class="img-fluid rounded-4 p-3" style="max-height: 450px; object-fit: contain;">
      </div>
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="col-md-6">
      <h1 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="text-muted fs-5" style="white-space: pre-wrap;">
        <?= nl2br(htmlspecialchars($product['description'])) ?>
      </p>
      <div class="fw-bold fs-2 text-success mb-4">
        $<?= number_format($product['price'], 2) ?>
      </div>

      <!-- Form thêm vào giỏ hàng với tăng giảm số lượng -->
      <form method="POST" action="index.php?page=cart&action=add&id=<?= $product['id'] ?>" class="d-flex align-items-center gap-2 mb-3">
        <div class="input-group" style="width: 140px;">
          <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
          <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1">
          <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
        </div>
        <button type="submit" class="btn btn-success flex-grow-1">
          🛒 Thêm vào giỏ hàng
        </button>
      </form>
    </div>
  </div>

  <!-- Bình luận -->
  <div class="card shadow-lg rounded-4 p-4">
    <h3 class="mb-4">💬 Bình luận</h3>

    <!-- Form thêm bình luận -->
    <?php if (isset($_SESSION['user_id'])): ?>
      <form method="POST" action="index.php?page=comment&action=addComment" class="mb-4">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <textarea name="content" required placeholder="Viết bình luận..." class="form-control mb-2" rows="3"></textarea>
        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
      </form>
    <?php else: ?>
      <p><a href="index.php?page=login" class="text-decoration-none">Đăng nhập</a> để bình luận</p>
    <?php endif; ?>

    <!-- Danh sách bình luận -->
    <div class="list-group">
      <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
          <div class="list-group-item list-group-item-action mb-2 rounded-3 shadow-sm">
            <div class="d-flex justify-content-between">
              <strong class="text-dark"><?= htmlspecialchars($comment['username']) ?></strong>
              <small class="text-muted"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></small>
            </div>
            <p class="mb-0"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-light">Chưa có bình luận nào.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- JS tăng giảm số lượng -->
<script>
const decreaseBtn = document.getElementById('decrease');
const increaseBtn = document.getElementById('increase');
const quantityInput = document.getElementById('quantity');

decreaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    if (current > 1) quantityInput.value = current - 1;
});

increaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    quantityInput.value = current + 1;
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
