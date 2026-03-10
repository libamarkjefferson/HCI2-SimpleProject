<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartMessage = '';
$wishlistMessage = '';
$allowedCategories = ['all', 'vegetables', 'fruits', 'snacks', 'spreads'];
$selectedCategory = 'all';
if (isset($_GET['category']) && in_array($_GET['category'], $allowedCategories, true)) {
    $selectedCategory = $_GET['category'];
}

// Initialize wishlist if not exists
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Handle add to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $name = trim($_POST['product_name'] ?? '');
    $price = (float)($_POST['product_price'] ?? 0);
    $image = trim($_POST['product_image'] ?? '');
    
    $isInWishlist = false;
    foreach ($_SESSION['wishlist'] as $item) {
        if ($item['id'] == $id) {
            $isInWishlist = true;
            break;
        }
    }
    
    if (!$isInWishlist) {
        $_SESSION['wishlist'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
        ];
        $wishlistMessage = $name . ' added to wishlist!';
    } else {
        $wishlistMessage = $name . ' is already in your wishlist!';
    }
}

// Handle remove from wishlist
if (isset($_POST['remove_from_wishlist'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($item) use ($id) {
        return $item['id'] != $id;
    });
    $wishlistMessage = 'Removed from wishlist!';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && !isset($_POST['add_to_wishlist']) && !isset($_POST['remove_from_wishlist'])) {
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

    $cartMessage = $name !== '' ? $name . ' added to cart.' : 'Item added to cart.';
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Organic Store</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/webp" href="images/favicon.webp">
</head>
<body data-initial-category="<?php echo htmlspecialchars($selectedCategory); ?>">

<main class="products-page">
    <div class="products-header">
        <h1>Our Products</h1>
        <p>Browse our wide selection of high-quality products.</p>
        <?php if ($cartMessage): ?>
            <div class="cart-toast" role="status">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo htmlspecialchars($cartMessage); ?></span>
                <a href="cart.php" class="toast-link">View cart</a>
            </div>
        <?php endif; ?>
        <?php if ($wishlistMessage): ?>
            <div class="wishlist-toast" role="status">
                <i class="fa-solid fa-heart"></i>
                <span><?php echo htmlspecialchars($wishlistMessage); ?></span>
                <a href="profile.php?tab=wishlist" class="toast-link">View wishlist</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="products-filters">
        <div class="filter-group">
            <label for="filter-category">Category</label>
            <select id="filter-category">
                <option value="all" <?php echo $selectedCategory === 'all' ? 'selected' : ''; ?>>All</option>
                <option value="vegetables" <?php echo $selectedCategory === 'vegetables' ? 'selected' : ''; ?>>Vegetables</option>
                <option value="fruits" <?php echo $selectedCategory === 'fruits' ? 'selected' : ''; ?>>Fruits</option>
                <option value="snacks" <?php echo $selectedCategory === 'snacks' ? 'selected' : ''; ?>>Snacks</option>
                <option value="spreads" <?php echo $selectedCategory === 'spreads' ? 'selected' : ''; ?>>Spreads</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="filter-price">Price</label>
            <select id="filter-price">
                <option value="all">All</option>
                <option value="0-199">₱0 - ₱199</option>
                <option value="200-399">₱200 - ₱399</option>
                <option value="400-plus">₱400+</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="sort-by">Sort</label>
            <select id="sort-by">
                <option value="featured">Featured</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="name-asc">Name: A to Z</option>
                <option value="name-desc">Name: Z to A</option>
            </select>
        </div>
    </div>

    <div class="product-grid">
        <!-- Product 1 -->
        <div class="product-card" data-category="vegetables" data-price="450" data-name="Fresh Vegetables Box" data-description="Farm-fresh seasonal vegetables delivered daily. Includes a premium selection of organic vegetables sourced directly from certified organic farms. Each box is carefully packed to ensure maximum freshness and quality." data-image="images/vegetable.jpg" data-id="1" onclick="openProductModal(this)">
            <div class="product-card-header">
                <img src="images/vegetable.jpg" alt="Fresh Vegetables">
                <form method="post" action="products.php" class="wishlist-form" onclick="event.stopPropagation();">
                    <input type="hidden" name="product_id" value="1">
                    <input type="hidden" name="product_name" value="Fresh Vegetables Box">
                    <input type="hidden" name="product_price" value="450">
                    <input type="hidden" name="product_image" value="images/vegetable.jpg">
                    <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>Fresh Vegetables Box</h3>
            <p class="price">₱450.00</p>
            <p class="description">Farm-fresh seasonal vegetables delivered daily</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="Fresh Vegetables Box">
                <input type="hidden" name="product_price" value="450">
                <input type="hidden" name="product_image" value="images/vegetable.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 2 -->
        <div class="product-card" data-category="fruits" data-price="380" data-name="Fresh Strawberries" data-description="Sweet and juicy organic strawberries. Handpicked from our partner farms to ensure only the ripest, most flavorful berries reach your table. Rich in antioxidants and naturally sweet." data-image="images/strawberry.jpg" data-id="2" onclick="openProductModal(this)">
            <div class="product-card-header">
                <img src="images/strawberry.jpg" alt="Fresh Strawberries">
                <form method="post" action="products.php" class="wishlist-form" onclick="event.stopPropagation();">
                    <input type="hidden" name="product_id" value="2">
                    <input type="hidden" name="product_name" value="Fresh Strawberries">
                    <input type="hidden" name="product_price" value="380">
                    <input type="hidden" name="product_image" value="images/strawberry.jpg">
                    <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>Fresh Strawberries</h3>
            <p class="price">₱380.00</p>
            <p class="description">Sweet and juicy organic strawberries</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="2">
                <input type="hidden" name="product_name" value="Fresh Strawberries">
                <input type="hidden" name="product_price" value="380">
                <input type="hidden" name="product_image" value="images/strawberry.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 3 -->
        <div class="product-card" data-category="vegetables" data-price="150" data-name="Fresh Cucumber" data-description="Crisp and refreshing organic cucumbers. Grown without synthetic pesticides, these cucumbers are perfect for salads, sandwiches, or as a refreshing snack. Hydrating and packed with nutrients." data-image="images/freshcucumber.jpg" data-id="3" onclick="openProductModal(this)">
            <div class="product-card-header">
                <img src="images/freshcucumber.jpg" alt="Fresh Cucumber">
                <form method="post" action="products.php" class="wishlist-form">
                    <input type="hidden" name="product_id" value="3">
                    <input type="hidden" name="product_name" value="Fresh Cucumber">
                    <input type="hidden" name="product_price" value="150">
                    <input type="hidden" name="product_image" value="images/freshcucumber.jpg">
                    <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>Fresh Cucumber</h3>
            <p class="price">₱150.00</p>
            <p class="description">Crisp and refreshing organic cucumbers</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="3">
                <input type="hidden" name="product_name" value="Fresh Cucumber">
                <input type="hidden" name="product_price" value="150">
                <input type="hidden" name="product_image" value="images/freshcucumber.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 4 -->
        <div class="product-card" data-category="vegetables" data-price="200" data-name="Organic Potatoes" data-description="Fresh farm potatoes perfect for any meal. These versatile tubers are essential in any kitchen. Naturally grown with no added chemicals, ideal for boiling, frying, or mashing." data-image="images/potato.jpg" data-id="4" onclick="openProductModal(this)">
            <div class="product-card-header">
                <img src="images/potato.jpg" alt="Organic Potatoes">
                <form method="post" action="products.php" class="wishlist-form">
                    <input type="hidden" name="product_id" value="4">
                    <input type="hidden" name="product_name" value="Organic Potatoes">
                    <input type="hidden" name="product_price" value="200">
                    <input type="hidden" name="product_image" value="images/potato.jpg">
                    <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>Organic Potatoes</h3>
            <p class="price">₱200.00</p>
            <p class="description">Fresh farm potatoes perfect for any meal</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="4">
                <input type="hidden" name="product_name" value="Organic Potatoes">
                <input type="hidden" name="product_price" value="200">
                <input type="hidden" name="product_image" value="images/potato.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 5 -->
        <div class="product-card" data-category="snacks" data-price="320" data-name="Dried Mango" data-description="Sweet and chewy organic dried mango slices. A healthy snack made from ripe mango fruits. No added sugar or preservatives. Perfect for lunch boxes or on-the-go snacking." data-image="images/driedmango.webp" data-id="5" onclick="openProductModal(this)">
            <div class="product-card-header">
                <img src="images/driedmango.webp" alt="Dried Mango">
                <form method="post" action="products.php" class="wishlist-form">
                    <input type="hidden" name="product_id" value="5">
                    <input type="hidden" name="product_name" value="Dried Mango">
                    <input type="hidden" name="product_price" value="320">
                    <input type="hidden" name="product_image" value="images/driedmango.webp">
                    <button type="submit" name="add_to_wishlist" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>Dried Mango</h3>
            <p class="price">₱320.00</p>
            <p class="description">Sweet and chewy organic dried mango slices</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="5">
                <input type="hidden" name="product_name" value="Dried Mango">
                <input type="hidden" name="product_price" value="320">
                <input type="hidden" name="product_image" value="images/driedmango.webp">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 6 -->
        <div class="product-card" data-category="spreads" data-price="280" data-name="Guava Jam" data-description="Rich and tangy homemade organic guava jam. Crafted from fresh, ripe guavas picked at peak ripeness. Made without artificial preservatives or added colors. Perfect for breakfast toast, pastries, or as a delicious dessert topping." data-image="images/guava jam.jpg" data-id="6" onclick="openProductModal(this)">
            <img src="images/guava jam.jpg" alt="Guava Jam">
            <h3>Guava Jam</h3>
            <p class="price">₱280.00</p>
            <p class="description">Homemade organic guava jam, no preservatives</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="6">
                <input type="hidden" name="product_name" value="Guava Jam">
                <input type="hidden" name="product_price" value="280">
                <input type="hidden" name="product_image" value="images/guava jam.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 7 -->
        <div class="product-card" data-category="snacks" data-price="250" data-name="Kamote Chips" data-description="Crispy baked sweet potato chips lightly salted. A healthy alternative to regular potato chips made with real sweet potatoes. Baked to perfection with minimal oil and natural sea salt. Perfect for snacking anytime." data-image="images/kamotechips.webp" data-id="7" onclick="openProductModal(this)">
            <img src="images/kamotechips.webp" alt="Kamote Chips">
            <h3>Kamote Chips</h3>
            <p class="price">₱250.00</p>
            <p class="description">Crispy baked sweet potato chips lightly salted</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="7">
                <input type="hidden" name="product_name" value="Kamote Chips">
                <input type="hidden" name="product_price" value="250">
                <input type="hidden" name="product_image" value="images/kamotechips.webp">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 8 -->
        <div class="product-card" data-category="fruits" data-price="300" data-name="Fresh Mangoes" data-description="Sweet ripe mangoes harvested at peak flavor. Premium quality mangoes grown under ideal tropical conditions. These golden fruits are perfectly ripe and ready to eat. Delivered fresh to your doorstep packed carefully." data-image="images/mango.avif" data-id="8" onclick="openProductModal(this)">
            <img src="images/mango.avif" alt="Fresh Mangoes">
            <h3>Fresh Mangoes</h3>
            <p class="price">₱300.00</p>
            <p class="description">Sweet ripe mangoes harvested at peak flavor</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="8">
                <input type="hidden" name="product_name" value="Fresh Mangoes">
                <input type="hidden" name="product_price" value="300">
                <input type="hidden" name="product_image" value="images/mango.avif">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>

        <!-- Product 9 -->
        <div class="product-card" data-category="spreads" data-price="320" data-name="Strawberry Jam" data-description="Small-batch strawberry jam made with ripe berries. Handcrafted using only the finest organic strawberries and natural ingredients. No artificial additives or preservatives. Bursting with fresh strawberry flavor in every spoonful." data-image="images/strawberryjam.jpg" data-id="9" onclick="openProductModal(this)">
            <img src="images/strawberryjam.jpg" alt="Strawberry Jam">
            <h3>Strawberry Jam</h3>
            <p class="price">₱320.00</p>
            <p class="description">Small-batch strawberry jam made with ripe berries</p>
            <form method="post" action="products.php" onclick="event.stopPropagation();">
                <input type="hidden" name="product_id" value="9">
                <input type="hidden" name="product_name" value="Strawberry Jam">
                <input type="hidden" name="product_price" value="320">
                <input type="hidden" name="product_image" value="images/strawberryjam.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div id="productModal" class="product-modal">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <button class="modal-close" id="closeModal">
                <i class="fa-solid fa-times"></i>
            </button>
            
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modalImage" src="" alt="Product">
                </div>
                <div class="modal-info">
                    <h2 id="modalTitle"></h2>
                    <p class="modal-price" id="modalPrice"></p>
                    <p class="modal-description" id="modalDescription"></p>
                    
                    <div class="modal-actions">
                        <form id="modalAddToCart" method="post" action="products.php">
                            <input type="hidden" id="modalProductId" name="product_id">
                            <input type="hidden" id="modalProductName" name="product_name">
                            <input type="hidden" id="modalProductPrice" name="product_price">
                            <input type="hidden" id="modalProductImage" name="product_image">
                            <div class="quantity-selector">
                                <label for="modalQuantity">Quantity:</label>
                                <div class="quantity-controls">
                                    <button type="button" id="decreaseQty" class="qty-btn">-</button>
                                    <input type="number" id="modalQuantity" name="quantity" value="1" min="1" max="100">
                                    <button type="button" id="increaseQty" class="qty-btn">+</button>
                                </div>
                            </div>
                            <button type="submit" class="btn-modal-cart">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                        <form id="modalAddToWishlist" method="post" action="products.php">
                            <input type="hidden" id="modalWishlistId" name="product_id">
                            <input type="hidden" id="modalWishlistName" name="product_name">
                            <input type="hidden" id="modalWishlistPrice" name="product_price">
                            <input type="hidden" id="modalWishlistImage" name="product_image">
                            <button type="submit" name="add_to_wishlist" class="btn-modal-wishlist">
                                <i class="fa-regular fa-heart"></i> Add to Wishlist
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
// Product Modal Functions
function openProductModal(element) {
    const modal = document.getElementById('productModal');
    const productId = element.dataset.id;
    const productName = element.dataset.name;
    const productPrice = element.dataset.price;
    const productImage = element.dataset.image;
    const productDescription = element.dataset.description;

    // Populate modal
    document.getElementById('modalImage').src = productImage;
    document.getElementById('modalImage').alt = productName;
    document.getElementById('modalTitle').textContent = productName;
    document.getElementById('modalPrice').textContent = '₱' + parseFloat(productPrice).toFixed(2);
    document.getElementById('modalDescription').textContent = productDescription;

    // Set form fields
    document.getElementById('modalProductId').value = productId;
    document.getElementById('modalProductName').value = productName;
    document.getElementById('modalProductPrice').value = productPrice;
    document.getElementById('modalProductImage').value = productImage;

    document.getElementById('modalWishlistId').value = productId;
    document.getElementById('modalWishlistName').value = productName;
    document.getElementById('modalWishlistPrice').value = productPrice;
    document.getElementById('modalWishlistImage').value = productImage;

    // Reset quantity
    document.getElementById('modalQuantity').value = 1;

    // Show modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';

    // Highlight the product card
    document.querySelectorAll('.product-card').forEach(card => {
        card.classList.remove('highlighted');
    });
    element.classList.add('highlighted');
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';

    // Remove highlight
    document.querySelectorAll('.product-card').forEach(card => {
        card.classList.remove('highlighted');
    });
}

// Event listeners for modal
document.getElementById('closeModal').addEventListener('click', closeProductModal);
document.querySelector('.modal-backdrop').addEventListener('click', closeProductModal);

// Quantity controls
document.getElementById('decreaseQty').addEventListener('click', function(e) {
    e.preventDefault();
    const input = document.getElementById('modalQuantity');
    if (input.value > 1) input.value--;
});

document.getElementById('increaseQty').addEventListener('click', function(e) {
    e.preventDefault();
    const input = document.getElementById('modalQuantity');
    input.value++;
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProductModal();
    }
});

(() => {
    const toast = document.querySelector('.cart-toast');
    if (toast) {
        setTimeout(() => toast.classList.add('is-hidden'), 2000);
    }

    const categorySelect = document.getElementById('filter-category');
    const priceSelect = document.getElementById('filter-price');
    const sortSelect = document.getElementById('sort-by');
    const grid = document.querySelector('.product-grid');
    const cards = Array.from(document.querySelectorAll('.product-card'));

    const priceMatch = (price, filter) => {
        if (filter === 'all') return true;
        if (filter === '0-199') return price <= 199;
        if (filter === '200-399') return price >= 200 && price <= 399;
        if (filter === '400-plus') return price >= 400;
        return true;
    };

    const applyFilters = () => {
        const category = categorySelect.value;
        const priceFilter = priceSelect.value;
        const sortBy = sortSelect.value;

        const filtered = cards.filter(card => {
            const cardCategory = card.dataset.category;
            const cardPrice = parseFloat(card.dataset.price || '0');
            const matchesCategory = category === 'all' || cardCategory === category;
            const matchesPrice = priceMatch(cardPrice, priceFilter);
            return matchesCategory && matchesPrice;
        });

        const sorted = filtered.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price || '0');
            const priceB = parseFloat(b.dataset.price || '0');
            const nameA = a.dataset.name.toLowerCase();
            const nameB = b.dataset.name.toLowerCase();

            if (sortBy === 'price-asc') return priceA - priceB;
            if (sortBy === 'price-desc') return priceB - priceA;
            if (sortBy === 'name-asc') return nameA.localeCompare(nameB);
            if (sortBy === 'name-desc') return nameB.localeCompare(nameA);
            return 0;
        });

        grid.innerHTML = '';
        sorted.forEach(card => grid.appendChild(card));
    };

    [categorySelect, priceSelect, sortSelect].forEach(select => {
        select.addEventListener('change', applyFilters);
    });

    // Apply initial category from URL if present
    const initialCategory = document.body.dataset.initialCategory;
    if (initialCategory && categorySelect.querySelector(`option[value="${initialCategory}"]`)) {
        categorySelect.value = initialCategory;
    }

    applyFilters();
})();
</script>

<?php include 'footer.php'; ?>

</body>
</html>
