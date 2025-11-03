<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="container my-5">
  <h1 class="display-4 text-dark mb-4">Add New Product</h1>
  
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert">
      <ul class="mb-0 ps-3">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" action="index.php?page=products&action=add" novalidate>
    <div class="mb-3">
      <label for="name" class="form-label">Product Name</label>
      <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($old['name'] ?? '') ?>" placeholder="Enter product name" autofocus />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" id="description" name="description" rows="4" required placeholder="Enter product description"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price (USD)</label>
      <input type="number" class="form-control" step="0.01" min="0" id="price" name="price" required value="<?= htmlspecialchars($old['price'] ?? '') ?>" placeholder="e.g. 99.99" />
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Image URL</label>
      <input type="url" class="form-control" id="image" name="image" required value="<?= htmlspecialchars($old['image'] ?? '') ?>" placeholder="https://example.com/image.jpg" />
    </div>

    <button type="submit" class="btn btn-primary w-100 mt-3">Add Product</button>
  </form>

  <p class="mt-3">
    <a href="index.php?page=products" class="text-primary fw-bold">← Back to Products</a>
  </p>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
