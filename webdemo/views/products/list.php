<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="py-5 bg-light">
  <div class="container" style="max-width: 1200px;">
    <h1 class="mb-5 fw-bold text-center">Our Products</h1>
    <div class="row g-4">
      <?php foreach ($products as $product): ?>
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
            <a href="index.php?page=products&action=detail&id=<?= $product['id'] ?>" class="text-decoration-none text-reset">
              <div class="ratio ratio-4x3 bg-white overflow-hidden">
                <img src="<?= htmlspecialchars($product['image']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>" 
                     class="img-fluid object-fit-cover w-100 h-100 hover-scale" loading="lazy">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title fw-bold text-truncate" title="<?= htmlspecialchars($product['name']) ?>">
                  <?= htmlspecialchars($product['name']) ?>
                </h5>
                <p class="card-text text-muted flex-grow-1 text-truncate" title="<?= htmlspecialchars($product['description']) ?>">
                  <?= htmlspecialchars($product['description']) ?>
                </p>
                <div class="fw-semibold fs-5 text-primary mt-2">$<?= number_format($product['price'], 2) ?></div>
              </div>
            </a>
            <form method="POST" action="index.php?page=cart&action=add&id=<?= $product['id'] ?>" class="p-3">
              <button type="submit" class="btn btn-gradient w-100 fw-semibold shadow-sm">
                Add to Cart
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
      <div class="col-12">
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center flex-wrap gap-1">
            <?php if ($currentPage > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?page=products&p=<?= $currentPage - 1 ?>">&laquo; Previous</a>
              </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                <a class="page-link" href="?page=products&p=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
              <li class="page-item">
                <a class="page-link" href="?page=products&p=<?= $currentPage + 1 ?>">Next &raquo;</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</section>

<style>
/* Image hover scale */
.hover-scale {
  transition: transform 0.3s ease;
}
.hover-scale:hover, .hover-scale:focus {
  transform: scale(1.05);
}

/* Card lift effect */
.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 25px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}

/* Gradient button */
.btn-gradient {
  background: linear-gradient(135deg, #0d9488, #14b8a6);
  color: #fff;
  border: none;
  transition: background 0.3s ease, transform 0.2s ease;
}
.btn-gradient:hover, .btn-gradient:focus {
  background: linear-gradient(135deg, #14b8a6, #0d9488);
  transform: scale(1.05);
  box-shadow: 0 8px 24px rgba(20, 184, 166, 0.7);
  outline: none;
}

/* Truncate multiple lines for description */
.text-truncate {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2; 
  -webkit-box-orient: vertical;
}
</style>

<?php require __DIR__ . '/../layout/footer.php'; ?>
