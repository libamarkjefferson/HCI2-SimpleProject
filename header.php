<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$cartCount = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $cartItem) {
        $cartCount += (int)($cartItem['quantity'] ?? 0);
    }
}
?>

<header class="dashboard-navbar">
    <div class="navbar-container">
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <div class="logo">
            <a href="dashboard.php">Organic Store</a>
        </div>
        <nav class="nav-links">
            <a href="products.php">Products</a>
            <a href="profile.php">Profile</a>
            <a href="cart.php" class="cart-link">
                <span class="cart-text">Cart</span>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge" aria-label="Items in cart"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>
