<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle add, increment, decrement in one place
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $action = $_POST['action'] ?? 'add';

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($action === 'increment' && isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } elseif ($action === 'decrement' && isset($_SESSION['cart'][$id])) {
        $newQty = $_SESSION['cart'][$id]['quantity'] - 1;
        if ($newQty < 1) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $newQty;
        }
    } else {
        // Default add-to-cart submission
        $name = trim($_POST['product_name'] ?? '');
        $price = (float)($_POST['product_price'] ?? 0);
        $image = trim($_POST['product_image'] ?? '');
        $quantity = max(1, (int)($_POST['quantity'] ?? 1));

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'quantity' => $quantity,
            ];
        }
    }

    header('Location: cart.php');
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
    <title>Cart | Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<main class="cart-page">
    <div class="cart-header">
        <h1>Your Cart</h1>
        <?php if ($cartHasItems): ?>
            <p>Review your picks before checkout.</p>
        <?php else: ?>
            <p>You haven’t added any products to your cart yet.</p>
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
                                    <form method="post" action="cart.php" class="qty-form">
                                        <input type="hidden" name="product_id" value="<?php echo (int)$item['id']; ?>">
                                        <input type="hidden" name="action" value="decrement">
                                        <button type="submit" class="qty-btn" aria-label="Decrease quantity">-</button>
                                    </form>
                                    <span class="qty-value" aria-live="polite"><?php echo (int)$item['quantity']; ?></span>
                                    <form method="post" action="cart.php" class="qty-form">
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
                <form action="checkout.php" method="get" class="checkout-form">
                    <h2>Order Summary</h2>
                    <div class="cart-summary-row">
                        <span>Items</span>
                        <span>₱<?php echo number_format($cartTotal, 2); ?></span>
                    </div>
                    <div class="cart-summary-row total">
                        <span>Total</span>
                        <span>₱<?php echo number_format($cartTotal, 2); ?></span>
                    </div>

                    <fieldset class="payment-options">
                        <legend>Payment Method</legend>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span class="payment-radio" aria-hidden="true"></span>
                            <div class="payment-visual">
                                <span class="payment-icon cod"><i class="fa-solid fa-truck-fast"></i></span>
                                <div class="payment-copy">
                                    <span class="payment-title">Cash on Delivery</span>
                                    <span class="payment-note">Settle up when the rider arrives</span>
                                </div>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="gcash">
                            <span class="payment-radio" aria-hidden="true"></span>
                            <div class="payment-visual">
                                <span class="payment-icon wallet"><i class="fa-solid fa-wallet"></i></span>
                                <div class="payment-copy">
                                    <span class="payment-title">GCash</span>
                                    <span class="payment-note">Pay instantly from your wallet</span>
                                </div>
                            </div>
                        </label>
                    </fieldset>

                    <button type="submit" class="btn-checkout">Go to Checkout</button>
                </form>
            </aside>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
