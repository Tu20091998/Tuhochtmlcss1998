<?php include __DIR__ . '/../layout/header.php'; ?>


<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary">📦 Quản lý sản phẩm</h2>
      <?php if (isset($_SESSION['user_id'])): ?>
    <div class="flex justify-end space-x-4 mb-4">
        <a href="index.php?page=products&action=add" class="btn btn-primary" style="font-weight: 700; font-size: 1.125rem;">Add Product</a>
    </div>
<?php endif; ?>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Tên</th>
          <th>Giá</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once 'models/Product.php';
        $productModel = new Product();
        $products = $productModel->getAll();

        foreach ($products as $product) {
            echo "<tr>
                <td>{$product['id']}</td>
                <td>{$product['name']}</td>
                <td>" . number_format($product['price'], 0, ',', '.') . " đ</td>
                <td>
                    <a href='?page=admin&action=update_product&id={$product['id']}' class='btn btn-sm btn-warning me-1'>Sửa</a>
                    <a href='?page=admin&action=delete_product&id={$product['id']}' 
                       class='btn btn-sm btn-danger' 
                       onclick='return confirm(\"Bạn có chắc muốn xoá sản phẩm này?\")'>Xoá</a>
                </td>
            </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>

