<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container py-5">
  <h1 class="mb-5 fw-bold text-center">Your Shopping Cart</h1>

  <?php if (empty($items)): ?>
    <div class="alert alert-info shadow-sm rounded-3 d-flex justify-content-center align-items-center" style="font-size: 1.15rem;">
      Your cart is empty. <a href="index.php?page=products" class="alert-link ms-2 fw-semibold">Browse products</a>.
    </div>
  <?php else: ?>
    <div class="table-responsive shadow rounded-4 overflow-hidden">
      <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
          <tr>
            <th>Product</th>
            <th style="width: 150px;">Quantity</th>
            <th style="width: 140px;">Price</th>
            <th style="width: 140px;">Subtotal</th>
            <th style="width: 80px;">Remove</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr class="align-middle">
            <td class="fw-semibold text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($item['name']) ?>">
              <?= htmlspecialchars($item['name']) ?>
            </td>
            <td class="text-center">
              <div class="d-flex align-items-center justify-content-center gap-1">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQty(this, -1)">-</button>
                <input type="number" name="quantity" value="<?= (int)$item['quantity'] ?>" min="1" class="form-control text-center qty-input" style="width:60px;" data-price="<?= $item['price'] ?>">
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="changeQty(this, 1)">+</button>
              </div>
            </td>
            <td class="fw-semibold text-primary fs-5 text-center">$<?= number_format($item['price'], 2) ?></td>
            <td class="fw-bold fs-5 text-center subtotal">$<?= number_format($item['subtotal'], 2) ?></td>
            <td class="text-center">
              <form method="POST" action="index.php?page=cart&action=remove&id=<?= $item['id'] ?>">
                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width:36px; height:36px;">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-end align-items-center mt-4">
      <span class="fs-4 fw-bold me-4 text-secondary">Total:</span>
      <span class="fs-2 fw-extrabold text-success" id="cart-total">$<?= number_format($total, 2) ?></span>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
      <form method="POST" action="index.php?page=cart&action=checkout" class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-lg btn-gradient px-5 shadow-lg rounded-5 fw-semibold">Place Order</button>
      </form>
    <?php else: ?>
      <div class="alert alert-warning rounded-4 shadow-sm mt-5 text-center fs-5">
        Please <a href="index.php?page=login" class="alert-link fw-semibold">login</a> to place your order.
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<style>
.btn-gradient {
  background: linear-gradient(135deg, #14b8a6, #0d9488);
  border: none; color: white; transition: background 0.3s ease, transform 0.2s ease;
}
.btn-gradient:hover, .btn-gradient:focus {
  background: linear-gradient(135deg, #0d9488, #14b8a6);
  box-shadow: 0 8px 24px rgba(20,184,166,0.85);
  outline: none;
}
</style>

<script>
function changeQty(btn, delta) {
  const input = btn.parentElement.querySelector('input[name="quantity"]');
  let val = parseInt(input.value);
  val = val + delta;
  if (val < 1) val = 1;
  input.value = val;

  // Cập nhật subtotal
  const price = parseFloat(input.dataset.price);
  const subtotalCell = input.closest('tr').querySelector('.subtotal');
  subtotalCell.textContent = '$' + (price * val).toFixed(2);

  // Cập nhật tổng tiền
  updateTotal();
}

function updateTotal() {
  let total = 0;
  document.querySelectorAll('.subtotal').forEach(cell => {
    total += parseFloat(cell.textContent.replace('$',''));
  });
  document.querySelector('#cart-total').textContent = '$' + total.toFixed(2);
}
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
