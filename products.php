<?php
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
</head>
<body>

<main class="products-page">
    <div class="products-header">
        <h1>Our Products</h1>
        <p>Browse our wide selection of high-quality products.</p>
    </div>

    <div class="products-filters">
        <div class="filter-group">
            <label for="filter-category">Category</label>
            <select id="filter-category">
                <option value="all">All</option>
                <option value="vegetables">Vegetables</option>
                <option value="fruits">Fruits</option>
                <option value="snacks">Snacks</option>
                <option value="spreads">Spreads</option>
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
        <div class="product-card" data-category="vegetables" data-price="450" data-name="Fresh Vegetables Box">
            <img src="images/vegetable.jpg" alt="Fresh Vegetables">
            <h3>Fresh Vegetables Box</h3>
            <p class="price">₱450.00</p>
            <p class="description">Farm-fresh seasonal vegetables delivered daily</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="Fresh Vegetables Box">
                <input type="hidden" name="product_price" value="450">
                <input type="hidden" name="product_image" value="images/vegetable.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Product 2 -->
        <div class="product-card" data-category="fruits" data-price="380" data-name="Fresh Strawberries">
            <img src="images/strawberry.jpg" alt="Fresh Strawberries">
            <h3>Fresh Strawberries</h3>
            <p class="price">₱380.00</p>
            <p class="description">Sweet and juicy organic strawberries</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="2">
                <input type="hidden" name="product_name" value="Fresh Strawberries">
                <input type="hidden" name="product_price" value="380">
                <input type="hidden" name="product_image" value="images/strawberry.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Product 3 -->
        <div class="product-card" data-category="vegetables" data-price="150" data-name="Fresh Cucumber">
            <img src="images/cucumber.jpg" alt="Fresh Cucumber">
            <h3>Fresh Cucumber</h3>
            <p class="price">₱150.00</p>
            <p class="description">Crisp and refreshing organic cucumbers</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="3">
                <input type="hidden" name="product_name" value="Fresh Cucumber">
                <input type="hidden" name="product_price" value="150">
                <input type="hidden" name="product_image" value="images/cucumber.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Product 4 -->
        <div class="product-card" data-category="vegetables" data-price="200" data-name="Organic Potatoes">
            <img src="images/potato.jpg" alt="Organic Potatoes">
            <h3>Organic Potatoes</h3>
            <p class="price">₱200.00</p>
            <p class="description">Fresh farm potatoes perfect for any meal</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="4">
                <input type="hidden" name="product_name" value="Organic Potatoes">
                <input type="hidden" name="product_price" value="200">
                <input type="hidden" name="product_image" value="images/potato.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Product 5 -->
        <div class="product-card" data-category="snacks" data-price="320" data-name="Dried Mango">
            <img src="images/driedmango.jpg" alt="Dried Mango">
            <h3>Dried Mango</h3>
            <p class="price">₱320.00</p>
            <p class="description">Sweet and chewy organic dried mango slices</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="5">
                <input type="hidden" name="product_name" value="Dried Mango">
                <input type="hidden" name="product_price" value="320">
                <input type="hidden" name="product_image" value="images/driedmango.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>

        <!-- Product 6 -->
        <div class="product-card" data-category="spreads" data-price="280" data-name="Guava Jam">
            <img src="images/guava jam.jpg" alt="Guava Jam">
            <h3>Guava Jam</h3>
            <p class="price">₱280.00</p>
            <p class="description">Homemade organic guava jam, no preservatives</p>
            <form method="post" action="cart.php">
                <input type="hidden" name="product_id" value="6">
                <input type="hidden" name="product_name" value="Guava Jam">
                <input type="hidden" name="product_price" value="280">
                <input type="hidden" name="product_image" value="images/guava jam.jpg">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>
    </div>
</main>

<script>
(() => {
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

    applyFilters();
})();
</script>

</body>
</html>
