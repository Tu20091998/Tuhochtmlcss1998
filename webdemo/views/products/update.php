<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="index.php?page=products&action=update&id=<?php echo $product['id']; ?>" method="POST">
    <div>
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>
    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>
    <div>
        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    </div>
    <div>
        <label for="image">Image URL</label>
        <input type="text" name="image" id="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>
    </div>
    <button type="submit">Update Product</button>
</form>