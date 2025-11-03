<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Cập nhật trạng thái đơn hàng</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="status" class="form-label fw-bold">Trạng thái đơn hàng:</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending">⏳ Chờ xử lý</option>
                        <option value="processing">🔄 Đang xử lý</option>
                        <option value="completed">✅ Hoàn thành</option>
                        <option value="cancelled">❌ Đã hủy</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="index.php?page=admin&action=orders" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
