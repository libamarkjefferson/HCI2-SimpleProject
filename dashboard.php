<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$cartMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $name = trim($_POST['product_name'] ?? '');
    $price = (float)($_POST['product_price'] ?? 0);
    $image = trim($_POST['product_image'] ?? '');
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

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

    $isBuyNow = isset($_POST['buy_now']);
    if ($isBuyNow) {
        header('Location: checkout.php');
        exit();
    }

    $cartMessage = $name !== '' ? $name . ' added to cart.' : 'Item added to cart.';
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
    <section class="browse-products-section">
        <div class="browse-products-header">
            <h2><i class="fa-solid fa-shopping-bag"></i> Browse Products</h2>
            <p>Explore our featured organic collections</p>
            <?php if ($cartMessage): ?>
                <div class="cart-toast" role="status">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($cartMessage); ?></span>
                    <a href="cart.php" class="toast-link">View cart</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-grid">
            <!-- Product 1 - Fresh Vegetables Box -->
            <div class="product-card" data-category="vegetables" data-price="450" data-name="Fresh Vegetables Box">
                <img src="images/vegetable.jpg" alt="Fresh Vegetables Box">
                <h3>Fresh Vegetables Box</h3>
                <p class="price">₱450.00</p>
                <p class="description">Farm-fresh seasonal vegetables delivered daily</p>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="product_id" value="1">
                    <input type="hidden" name="product_name" value="Fresh Vegetables Box">
                    <input type="hidden" name="product_price" value="450">
                    <input type="hidden" name="product_image" value="images/vegetable.jpg">
                    <input type="hidden" name="quantity" value="1">
                    <div class="product-actions">
                        <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                    </div>
                </form>
            </div>

            <!-- Product 2 - Fresh Strawberries -->
            <div class="product-card" data-category="fruits" data-price="380" data-name="Fresh Strawberries">
                <img src="images/strawberry.jpg" alt="Fresh Strawberries">
                <h3>Fresh Strawberries</h3>
                <p class="price">₱380.00</p>
                <p class="description">Sweet and juicy organic strawberries</p>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="product_id" value="2">
                    <input type="hidden" name="product_name" value="Fresh Strawberries">
                    <input type="hidden" name="product_price" value="380">
                    <input type="hidden" name="product_image" value="images/strawberry.jpg">
                    <input type="hidden" name="quantity" value="1">
                    <div class="product-actions">
                        <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                    </div>
                </form>
            </div>

            <!-- Product 3 - Fresh Cucumber -->
            <div class="product-card" data-category="vegetables" data-price="150" data-name="Fresh Cucumber">
                <img src="images/freshcucumber.jpg" alt="Fresh Cucumber">
                <h3>Fresh Cucumber</h3>
                <p class="price">₱150.00</p>
                <p class="description">Crisp and refreshing organic cucumbers</p>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="product_id" value="3">
                    <input type="hidden" name="product_name" value="Fresh Cucumber">
                    <input type="hidden" name="product_price" value="150">
                    <input type="hidden" name="product_image" value="images/freshcucumber.jpg">
                    <input type="hidden" name="quantity" value="1">
                    <div class="product-actions">
                        <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                    </div>
                </form>
            </div>
                
            <!-- Product 4 - Dried Mango -->
            <div class="product-card" data-category="fruits" data-price="280" data-name="Dried Mango">
                <img src="images/driedmango.jpg" alt="Dried Mango">
                <h3>Dried Mango</h3>
                <p class="price">₱280.00</p>
                <p class="description">Crisp and delicious dried mango slices</p>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="product_id" value="4">
                    <input type="hidden" name="product_name" value="Dried Mango">
                    <input type="hidden" name="product_price" value="280">
                    <input type="hidden" name="product_image" value="images/driedmango.jpg">
                    <input type="hidden" name="quantity" value="1">
                    <div class="product-actions">
                        <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now"><i class="fa-solid fa-bag-shopping"></i> Buy Now</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="browse-all-btn">
            <a href="products.php" class="btn-primary">View All Products <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="testimonials-header">
            <h2><i class="fa-solid fa-quote-left"></i> What Our Customers Say</h2>
            <p>Join thousands of satisfied customers enjoying farm-fresh organic products</p>
        </div>

        <div class="testimonials-grid">
            <!-- Testimonial 1 -->
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text">"The quality of produce is exceptional! Everything arrives fresh and perfectly packaged. I've never been happier with my organic grocery shopping."</p>
                <div class="testimonial-author">
                    <img src="images/char.jpg" alt="Maria Santos" class="author-profile">
                    <div class="author-info">
                        <h4>Charlito Serenio</h4>
                        <p>Brgy. Santa Cruz Hilongos, Leyte</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text">"Excellent selection and fast delivery. The vegetables taste so fresh, my family has already noticed the difference. Highly recommended!"</p>
                <div class="testimonial-author">
                    <img src="images/bebe.jpg" alt="Juan Cruz" class="author-profile">
                    <div class="author-info">
                        <h4>Joshua Variacion</h4>
                        <p>Brgy. San Roque Hilongos, Leyte</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <p class="testimonial-text">"I love knowing exactly where my food comes from. The certified organic labels and traceability give me peace of mind for my family."</p>
                <div class="testimonial-author">
                    <img src="images/raffy.jpg" alt="Raffy Agravante" class="author-profile">
                    <div class="author-info">
                        <h4>Raffy Agravante</h4>
                        <p>Brgy. San Juan Hilongos, Leyte</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2><i class="fa-solid fa-envelope"></i> Stay Updated</h2>
                <p>Subscribe to our newsletter and get exclusive deals, fresh produce tips, and special offers delivered straight to your inbox.</p>
            </div>
            <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                <div class="form-group-newsletter">
                    <input 
                        type="email" 
                        placeholder="Enter your email address" 
                        required 
                        class="newsletter-input"
                        aria-label="Email address for newsletter"
                    >
                    <button type="submit" class="newsletter-btn">
                        Subscribe <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <div class="newsletter-message" id="newsletterMessage"></div>
                <p class="newsletter-privacy">
                    <i class="fa-solid fa-shield"></i>
                    We respect your privacy. Unsubscribe at any time.
                </p>
            </form>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<script>
function handleNewsletterSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const email = form.querySelector('.newsletter-input').value;
    const messageDiv = document.getElementById('newsletterMessage');
    
    // Simulate subscription
    messageDiv.textContent = '✓ Thank you for subscribing! Check your email for a special welcome offer.';
    messageDiv.classList.add('success');
    
    // Reset form after 2 seconds
    setTimeout(() => {
        form.reset();
        messageDiv.textContent = '';
        messageDiv.classList.remove('success');
    }, 3000);
}
</script>

</body>
</html>