<?php require __DIR__ . '/../layout/header.php'; ?>

<style>
    .gradient-header-green {
        background: linear-gradient(135deg, #00b36b 0%, #28a745 100%);
    }
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        border-color: #28a745;
    }
    .btn-green-gradient {
        background: linear-gradient(135deg, #00c97b 0%, #28a745 100%);
        border: none;
        color: white;
        transition: 0.3s ease-in-out;
    }
    .btn-green-gradient:hover {
        opacity: 0.92;
        transform: translateY(-1px);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card card-modern">
                <div class="card-header text-white gradient-header-green rounded-top">
                    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Sửa sản phẩm</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control rounded-pill px-4 py-2" 
                                   value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá (VNĐ)</label>
                            <input type="number" name="price" id="price" class="form-control rounded-pill px-4 py-2" 
                                   value="<?= $product['price'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh (URL)</label>
                            <input type="text" name="image" id="image" class="form-control rounded-pill px-4 py-2"
                                   value="<?= htmlspecialchars($product['image']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control rounded-4 px-4 py-3"
                                      rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-green-gradient btn-lg rounded-pill">
                                <i class="bi bi-check-circle me-1"></i> Cập nhật sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
