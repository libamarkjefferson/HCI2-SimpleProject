<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<main class="profile-page">
    <header class="profile-header">
        <div>
            <p class="eyebrow">Account</p>
            <h1>Your Profile</h1>
            <p class="subhead">Manage your info, preferences, and wishlist.</p>
        </div>
        <a class="ghost-link" href="logout.php">Log out</a>
    </header>

    <section class="profile-grid">
        <div class="profile-card">
            <div class="card-header">
                <div>
                    <p class="eyebrow">Profile</p>
                    <h2>Profile settings</h2>
                </div>
                <span class="pill success">Verified</span>
            </div>
            <form class="profile-form">
                <div class="form-row">
                    <label for="full-name">Full name</label>
                    <input id="full-name" name="full-name" type="text" value="Your Name">
                </div>
                <div class="form-row">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="you@example.com">
                </div>
                <div class="form-row two-col">
                    <div>
                        <label for="phone">Phone</label>
                        <input id="phone" name="phone" type="tel" value="+63 900 000 0000">
                    </div>
                    <div>
                        <label for="location">Location</label>
                        <input id="location" name="location" type="text" value="Manila, PH">
                    </div>
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" value="">
                    <small class="hint">Leave blank to keep current password.</small>
                </div>
                <button type="button" class="btn-primary">Save changes</button>
            </form>
        </div>

        <div class="profile-card wishlist-card">
            <div class="card-header">
                <div>
                    <p class="eyebrow">Wishlist</p>
                    <h2>Saved items</h2>
                </div>
                <a class="ghost-link" href="wishlist.php">View all</a>
            </div>
            <div class="wishlist-list">
                <div class="wishlist-item">
                    <img src="images/strawberry.jpg" alt="Strawberries">
                    <div>
                        <p class="item-title">Fresh Strawberries</p>
                        <p class="item-price">₱380.00</p>
                    </div>
                    <div class="wishlist-actions">
                        <a href="products.php" class="link-small">View</a>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="2">
                            <input type="hidden" name="product_name" value="Fresh Strawberries">
                            <input type="hidden" name="product_price" value="380">
                            <input type="hidden" name="product_image" value="images/strawberry.jpg">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-inline">Add to cart</button>
                        </form>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="images/driedmango.jpg" alt="Dried Mango">
                    <div>
                        <p class="item-title">Dried Mango</p>
                        <p class="item-price">₱320.00</p>
                    </div>
                    <div class="wishlist-actions">
                        <a href="products.php" class="link-small">View</a>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="5">
                            <input type="hidden" name="product_name" value="Dried Mango">
                            <input type="hidden" name="product_price" value="320">
                            <input type="hidden" name="product_image" value="images/driedmango.jpg">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-inline">Add to cart</button>
                        </form>
                    </div>
                </div>

                <div class="wishlist-item">
                    <img src="images/guava jam.jpg" alt="Guava Jam">
                    <div>
                        <p class="item-title">Guava Jam</p>
                        <p class="item-price">₱280.00</p>
                    </div>
                    <div class="wishlist-actions">
                        <a href="products.php" class="link-small">View</a>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="6">
                            <input type="hidden" name="product_name" value="Guava Jam">
                            <input type="hidden" name="product_price" value="280">
                            <input type="hidden" name="product_image" value="images/guava jam.jpg">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-inline">Add to cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>
