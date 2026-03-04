<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/webp" href="images/favicon.webp">
</head>
<body>

<header class="dashboard-navbar">
    <div class="navbar-container">
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <div class="logo">
            <a href="dashboard.php">
                <img src="images/logo.jpg" alt="Organic Store logo" class="logo-img">
                <img src="images/logo1.png" alt="Organic Store secondary logo" class="logo-img logo-img-secondary">              
            </a>
        </div>
        <nav class="nav-links">
            <a href="products.php">Products</a>
            <a href="profile.php">Profile</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="product-container">

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-left">
                <h1>Discover farm-fresh goodness, thoughtfully packed for you.</h1>
                <p>Shop premium organic produce, nutrient-rich staples, and clean-label favorites expertly handled to preserve quality and freshness.</p>
                <a href="products.php" class="btn-hero">Show Now <span>→</span></a>
            </div>
            <div class="hero-right">
                <img src="images/veg.webp" alt="Fresh Groceries">
            </div>
        </div>
    </section>

    <!-- Popular Categories Section -->
    <section class="category-section" aria-label="Popular categories">
        <div class="category-container">
            <div class="category-header">
                <h2>Popular categories</h2>
                <p class="category-subtitle">Fresh finds updated daily so you never miss your staples.</p>
            </div>
            <div class="category-grid">
                <a class="category-card" href="products.php?category=vegetables">
                    <span class="category-icon soft-green"><i class="fa-solid fa-carrot" aria-hidden="true"></i></span>
                    <div class="category-copy">
                        <h3>Vegetables</h3>
                        <p>Leafy greens, roots, and everyday staples.</p>
                    </div>
                </a>
                <a class="category-card" href="products.php?category=fruits">
                    <span class="category-icon soft-orange"><i class="fa-solid fa-apple-whole" aria-hidden="true"></i></span>
                    <div class="category-copy">
                        <h3>Fruits</h3>
                        <p>Seasonal picks and antioxidant powerhouses.</p>
                    </div>
                </a>
                <a class="category-card" href="products.php?category=snacks">
                    <span class="category-icon soft-pink"><i class="fa-solid fa-cookie-bite" aria-hidden="true"></i></span>
                    <div class="category-copy">
                        <h3>Snacks</h3>
                        <p>Cold-pressed blends for quick refreshment.</p>
                    </div>
                </a>
                <a class="category-card" href="products.php?category=spreads">
                    <span class="category-icon soft-lime"><i class="fa-solid fa-bread-slice" aria-hidden="true"></i></span>
                    <div class="category-copy">
                        <h3>Spreads</h3>
                        <p>Dry goods and staples with clean labels.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Value Props Section -->
    <section class="value-props" aria-label="Store benefits">
        <div class="value-props-container">
            <h2>Full Of Flavor, Not Bad Stuff</h2>
            <div class="value-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-seedling" aria-hidden="true"></i>
                    </div>
                    <h3>Certified Organic Harvest</h3>
                    <p>Produce and pantry goods sourced from accredited organic farms with full traceability from field to shelf.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-cubes" aria-hidden="true"></i>
                    </div>
                    <h3>No Synthetic Additives</h3>
                    <p>Formulated without artificial preservatives, dyes, or sweeteners to maintain the integrity of every ingredient.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-wheat-awn-circle-exclamation" aria-hidden="true"></i>
                    </div>
                    <h3>Allergen-Conscious Selection</h3>
                    <p>Gluten-free and soy-free options chosen to accommodate common dietary preferences without compromising flavor.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa-solid fa-shield-heart" aria-hidden="true"></i>
                    </div>
                    <h3>Ethically Raised Proteins</h3>
                    <p>Animal products sourced from partners adhering to humane practices, free from growth hormones and routine antibiotics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <h2 id="products">Browse Products</h2>

    <div class="product-grid">
        <!-- Product cards will go here -->
    </div>

</main>

</body>
</html>