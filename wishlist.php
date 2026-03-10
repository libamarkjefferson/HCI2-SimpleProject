<?php
session_start();
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Handle remove from wishlist
if (isset($_POST['remove_from_wishlist'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($item) use ($id) {
        return $item['id'] != $id;
    });
    $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist | Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/webp" href="images/favicon.webp">
</head>
<body>

<main class="wishlist-page">
    <div class="wishlist-container">
        <h1><i class="fa-solid fa-heart"></i> My Wishlist</h1>
        
        <?php if (empty($_SESSION['wishlist'])): ?>
            <div class="empty-message">
                <i class="fa-solid fa-heart-crack"></i>
                <p>Your wishlist is empty</p>
                <p class="subtitle">Add items to your wishlist by clicking the heart icon on products</p>
                <a href="products.php" class="btn-shop">
                    <i class="fa-solid fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="wishlist-grid">
                <?php foreach ($_SESSION['wishlist'] as $product): ?>
                    <div class="wishlist-item">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="wishlist-item-info">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p class="wishlist-price">₱<?php echo number_format($product['price'], 2); ?></p>
                            <div class="wishlist-actions">
                                <form method="post" action="products.php" style="display: inline; flex: 1;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                                    <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-to-cart">
                                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                                <form method="post" action="wishlist.php" style="display: inline; flex: 1;">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <button type="submit" name="remove_from_wishlist" class="btn-remove">
                                        <i class="fa-solid fa-trash"></i> Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>

</body>
</html>
