<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$orderPlaced = false;
$paymentUsed = 'Cash on Delivery';

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['place_order'])
    && isset($_POST['payment_method'])
    && !empty($_SESSION['cart'])
) {
    $orderPlaced = true;
    $paymentUsed = $_POST['payment_method'] === 'gcash' ? 'GCash' : 'Cash on Delivery';
    $_SESSION['cart'] = [];
}

$cartItems = $_SESSION['cart'] ?? [];
$cartHasItems = !empty($cartItems);
$cartTotal = 0;
$selectedPaymentInput = $_POST['payment_method'] ?? $_GET['payment_method'] ?? 'cod';
$selectedPayment = $selectedPaymentInput === 'gcash' ? 'gcash' : 'cod';

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

    <?php if ($orderPlaced): ?>
        <div class="order-success" role="status">
            <div class="order-success-icon"><i class="fa-solid fa-check"></i></div>
            <div class="order-success-copy">
                <h2>Thank you! Order placed.</h2>
                <p>We received your order using <?php echo htmlspecialchars($paymentUsed); ?>. You will get updates soon.</p>
            </div>
            <div class="order-success-actions">
                <a class="btn-primary" href="products.php">Continue shopping</a>
                <a class="ghost-link" href="profile.php">Go to profile</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($cartHasItems): ?>
        <div class="cart-grid">
            <div class="cart-items">
                <?php foreach ($cartItems as $item): ?>
                    <?php $lineTotal = $item['price'] * $item['quantity']; $cartTotal += $lineTotal; ?>
                    <div class="cart-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="cart-item-info">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="cart-price">₱<?php echo number_format($item['price'], 2); ?> × <?php echo (int)$item['quantity']; ?></p>
                            <p class="cart-subtotal">Subtotal: ₱<?php echo number_format($lineTotal, 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <aside class="cart-summary">
                <form class="checkout-form" action="checkout.php" method="post">
                    <div class="summary-header">
                        <div>
                            <p class="eyebrow">Step 2 of 2</p>
                            <h2>Payment & Total</h2>
                        </div>
                        <span class="summary-badge">Secure</span>
                    </div>

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
                            <input type="radio" name="payment_method" value="cod" <?php echo $selectedPayment === 'cod' ? 'checked' : ''; ?>>
                            <span class="payment-radio" aria-hidden="true"></span>
                            <div class="payment-visual">
                                <span class="payment-icon cod"><i class="fa-solid fa-truck-fast"></i></span>
                                <div class="payment-copy">
                                    <span class="payment-title">Cash on Delivery</span>
                                    <span class="payment-note">Pay when your order arrives</span>
                                </div>
                            </div>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="gcash" <?php echo $selectedPayment === 'gcash' ? 'checked' : ''; ?>>
                            <span class="payment-radio" aria-hidden="true"></span>
                            <div class="payment-visual">
                                <span class="payment-icon wallet"><i class="fa-solid fa-wallet"></i></span>
                                <div class="payment-copy">
                                    <span class="payment-title">GCash</span>
                                    <span class="payment-note">Instant wallet checkout</span>
                                </div>
                            </div>
                        </label>
                    </fieldset>

                    <p class="summary-note">You can still review delivery details on the next step.</p>
                    <button class="btn-checkout" type="submit" name="place_order" value="1">Place Order</button>
                </form>
            </aside>
        </div>
    <?php endif; ?>

    <?php if (!$cartHasItems): ?>
        <a class="btn-checkout" href="products.php" style="max-width: 320px; display: inline-block;">Back to Products</a>
    <?php endif; ?>
</main>

</body>
</html>
