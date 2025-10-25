
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="../Css/common.css">
    <link rel="stylesheet" href="../Css/carts.css">
    
</head>
<body>
    <?php if (isset($_SESSION['success'])): ?>
        <div><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <div class="cart-container">

        <h1>🛒 Danh sách giỏ hàng của người dùng</h1>
        <?php if (empty($cartItems)) : ?>
            <p>Danh sách trống</p>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã giỏ</th>
                        <th>Người dùng</th>
                        <th>Mã SP</th>
                        <th>Số lượng</th>
                        <th>Ngày thêm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalPrice = 0; ?>
                    <?php foreach ($cartItems as $cart) : ?>
                        <tr>
                            <td><?php echo $cart["cart_id"]; ?></td>
                            <td><?php echo $cart["user_id"]; ?></td>
                            <td><?php echo $cart["product_id"]; ?></td>
                            <td><span style="margin: 0 10px;"><?php echo $cart["quantity"]; ?></span></td>
                            <td><?php echo $cart["date_added"]; ?></td>
                            <td><?php echo $cart["name"]; ?></td>
                            <td><?php echo number_format($cart["price"], 0, ',', '.') . ' ₫'; ?></td>
                            <?php $totalPrice += $cart["price"] * $cart["quantity"]; ?>
                            <td><img src="<?php echo $cart["image"]; ?>" alt="Hình ảnh"></td>
                            <td><?php echo $cart["description"]; ?></td>
                            <td>
                                <form method="POST" action="../Controllers/BaseController.php?action=cart_remove_confirm">
                                    <input type="hidden" name="product_id" value="<?php echo $cart["product_id"]; ?>">
                                    <button type="submit" onclick="return confirm('Bạn có chắc muốn xoá không?')">🗑️ Xoá</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="total-price"><strong>Tổng tiền: </strong><?php echo number_format($totalPrice, 0, ',', '.'); ?> ₫</p>

            <form method="POST" style="text-align: center;" action="../Controllers/BaseController.php?action=order_confirm">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION["user_id"]; ?>">
                <button type="submit" class="confirm-order-btn" name="order_confirm" onclick="return confirm('Bạn có chắc chắn muốn đặt hàng?')">
                    ✅ Đặt hàng
                </button>
            </form>
                    
        <?php endif; ?>
    </div>
</body>
</html>

