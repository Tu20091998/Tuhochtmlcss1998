<?php include __DIR__ . '/../layout/header.php'; ?>

<h2 class="text-center text-success mb-4">💬 Quản lý bình luận</h2>

<div class="container">
  <div class="card shadow rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Sản phẩm</th>
              <th>Người dùng</th>
              <th>Nội dung</th>
              <th>Trạng thái</th>
              <th>Ngày tạo</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($comments)): ?>
              <?php foreach ($comments as $c): ?>
                <tr>
                  <td><?= $c['comment_id'] ?></td>
                  <td><?= htmlspecialchars($c['product_name']) ?></td>
                  <td><?= htmlspecialchars($c['username']) ?></td>
                  <td><?= nl2br(htmlspecialchars($c['content'])) ?></td>
                  <td>
                    <?= $c['status'] == 1 
                        ? '<span class="badge bg-success">Hiện</span>' 
                        : '<span class="badge bg-secondary">Ẩn</span>' ?>
                  </td>
                  <td><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                  <td>
                    <!-- Ẩn/Hiện -->
                    <a href="index.php?page=comment&action=toggleStatus&comment_id=<?= $c['comment_id'] ?>"
                       class="btn btn-sm <?= $c['status'] == 1 ? 'btn-warning' : 'btn-success' ?>"
                       onclick="return confirm('Bạn có chắc chắn muốn <?= $c['status'] == 1 ? 'ẩn' : 'hiện' ?> bình luận này?');">
                       <?= $c['status'] == 1 ? 'Ẩn' : 'Hiện' ?>
                    </a>

                    <!-- Xóa -->
                    <a href="index.php?page=comment&action=delete&comment_id=<?= $c['comment_id'] ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
                       🗑 Xóa
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7">Chưa có bình luận nào.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
