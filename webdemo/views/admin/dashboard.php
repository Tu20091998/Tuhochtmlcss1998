<?php include __DIR__ . '/../layout/header.php'; ?>


<div class="container py-5">
  <h2 class="mb-5 text-center fw-bold text-gradient">🌐 Trang quản trị Admin</h2>

  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg rounded-4 border-0">
        <div class="card-body p-4">
          <div class="list-group list-group-flush">
            <a href="?page=admin&action=products" class="list-group-item list-group-item-action admin-link d-flex align-items-center py-3 fs-5">
              <span class="me-3 fs-4 text-success">📦</span> Quản lý sản phẩm
            </a>
            <a href="?page=admin&action=users" class="list-group-item list-group-item-action admin-link d-flex align-items-center py-3 fs-5">
              <span class="me-3 fs-4 text-info">👤</span> Quản lý người dùng
            </a>
            <a href="?page=admin&action=orders" class="list-group-item list-group-item-action admin-link d-flex align-items-center py-3 fs-5">
              <span class="me-3 fs-4 text-warning">🧾</span> Quản lý đơn hàng
            </a>
            <!-- ✅ Thêm mục Quản lý bình luận -->
            <a href="?page=admin&action=comments" class="list-group-item list-group-item-action admin-link d-flex align-items-center py-3 fs-5">
              <span class="me-3 fs-4 text-danger">💬</span> Quản lý bình luận
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php include __DIR__ . '/../layout/footer.php'; ?>
