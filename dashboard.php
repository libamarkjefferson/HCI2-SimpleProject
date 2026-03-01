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
    <link rel="icon" type="image/png" href="assets/favicon.png">
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
            <a href="dashboard.php">Organic Store</a>
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
                <h1>Experience curated organic essentials, delivered with care</h1>
                <p>Explore rigorously sourced fruits, vegetables, and pantry staples prepared for same-day dispatch to protect peak freshness.</p>
                <a href="products.php" class="btn-hero">Show Now <span>→</span></a>
            </div>
            <div class="hero-right">
                <img src="images/vegetable.webp" alt="Fresh Groceries">
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