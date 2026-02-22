<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['product_id'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    if (isset($_SESSION['cart'][$id])) {
        $action = $_POST['action'];
        if ($action === 'increment') {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } elseif ($action === 'decrement') {
            $newQty = $_SESSION['cart'][$id]['quantity'] - 1;
            if ($newQty < 1) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id]['quantity'] = $newQty;
            }
        }
    }
    header('Location: checkout.php');
    exit();
}

$cartItems = $_SESSION['cart'] ?? [];
$cartHasItems = !empty($cartItems);
$cartTotal = 0;

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Organic Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main class="cart-page">
    <div class="cart-header">
        <h1>Checkout</h1>
        <?php if ($cartHasItems): ?>
            <p>Review your items before placing your order.</p>
        <?php else: ?>
            <p>Your cart is empty. Add products to proceed.</p>
        <?php endif; ?>
    </div>

    <?php if ($cartHasItems): ?>
        <div class="cart-grid">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <?php $lineTotal = $item['price'] * $item['quantity']; $cartTotal += $lineTotal; ?>
                    <div class="cart-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="cart-item-info">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="cart-line">
                                <p class="cart-price">₱<?php echo number_format($item['price'], 2); ?></p>
                                <div class="qty-control">
                                    <form method="post" action="checkout.php" class="qty-form">
                                        <input type="hidden" name="product_id" value="<?php echo (int)$item['id']; ?>">
                                        <input type="hidden" name="action" value="decrement">
                                        <button type="submit" class="qty-btn" aria-label="Decrease quantity">-</button>
                                    </form>
                                    <span class="qty-value" aria-live="polite"><?php echo (int)$item['quantity']; ?></span>
                                    <form method="post" action="checkout.php" class="qty-form">
                                        <input type="hidden" name="product_id" value="<?php echo (int)$item['id']; ?>">
                                        <input type="hidden" name="action" value="increment">
                                        <button type="submit" class="qty-btn" aria-label="Increase quantity">+</button>
                                    </form>
                                </div>
                            </div>
                            <p class="cart-subtotal">Subtotal: ₱<?php echo number_format($lineTotal, 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <aside class="cart-summary">
                <h2>Order Summary</h2>
                <div class="cart-summary-row">
                    <span>Items</span>
                    <span>₱<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span>₱<?php echo number_format($cartTotal, 2); ?></span>
                </div>
                <button class="btn-checkout" type="button" onclick="alert('Order placed! (stub)')">Place Order</button>
            </aside>
        </div>
    <?php endif; ?>

    <?php if (!$cartHasItems): ?>
        <a class="btn-checkout" href="products.php" style="max-width: 320px; display: inline-block;">Back to Products</a>
    <?php endif; ?>
</main>

</body>
</html>
