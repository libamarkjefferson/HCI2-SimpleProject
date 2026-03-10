<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Handle profile update
$updateMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    if ($fullname && $email && $phone) {
        $_SESSION['user']['fullname'] = $fullname;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['phone'] = $phone;
        $_SESSION['user']['address'] = $address;
        $updateMessage = 'Profile updated successfully!';
    }
}

// Initialize wishlist if not exists
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Handle remove from wishlist
if (isset($_POST['remove_from_wishlist'])) {
    $id = (int)($_POST['remove_from_wishlist'] ?? 0);
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function($item) use ($id) {
        return $item['id'] != $id;
    });
    $_SESSION['wishlist'] = array_values($_SESSION['wishlist']);
}

include 'header.php';
?>

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
    <div class="profile-container">
        <!-- Profile Navigation Tabs -->
        <div class="profile-tabs">
            <button class="profile-tab-btn active" data-tab="settings">
                <i class="fa-solid fa-gear"></i> Profile Settings
            </button>
            <button class="profile-tab-btn" data-tab="wishlist">
                <i class="fa-solid fa-heart"></i> My Wishlist
            </button>
        </div>

        <!-- Profile Settings Section -->
        <section class="profile-tab-content active" id="settings-tab">
            <div class="profile-settings">
                <div class="profile-header-actions">
                    <h1><i class="fa-solid fa-user"></i> Profile Settings</h1>
                    <button id="editToggleBtn" class="btn-edit-toggle">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                    </button>
                </div>
                
                <?php if ($updateMessage): ?>
                    <div class="success-message">
                        <i class="fa-solid fa-circle-check"></i>
                        <?php echo htmlspecialchars($updateMessage); ?>
                    </div>
                <?php endif; ?>

                <!-- View Mode -->
                <div id="viewMode" class="profile-view-mode">
                    <div class="profile-info-grid">
                        <div class="profile-info-card">
                            <div class="info-icon">
                                <i class="fa-solid fa-user-circle"></i>
                            </div>
                            <div class="info-content">
                                <label>Full Name</label>
                                <p id="displayFullname"><?php echo htmlspecialchars($_SESSION['user']['fullname'] ?? 'Not set'); ?></p>
                            </div>
                        </div>

                        <div class="profile-info-card">
                            <div class="info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <label>Email Address</label>
                                <p id="displayEmail"><?php echo htmlspecialchars($_SESSION['user']['email'] ?? 'Not set'); ?></p>
                            </div>
                        </div>

                        <div class="profile-info-card">
                            <div class="info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <label>Phone Number</label>
                                <p id="displayPhone"><?php echo htmlspecialchars($_SESSION['user']['phone'] ?? 'Not set'); ?></p>
                            </div>
                        </div>

                        <div class="profile-info-card">
                            <div class="info-icon">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div class="info-content">
                                <label>Address</label>
                                <p id="displayAddress"><?php echo htmlspecialchars($_SESSION['user']['address'] ?? 'Not set'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="editMode" class="profile-edit-mode" style="display: none;">
                    <form method="post" action="profile.php" class="profile-form">
                        <div class="form-section">
                            <h3>Personal Information</h3>
                            <div class="form-group">
                                <label for="fullname">Full Name *</label>
                                <input 
                                    type="text" 
                                    id="fullname" 
                                    name="fullname" 
                                    value="<?php echo htmlspecialchars($_SESSION['user']['fullname'] ?? ''); ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="<?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="<?php echo htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="4"
                                    placeholder="Enter your delivery address"
                                ><?php echo htmlspecialchars($_SESSION['user']['address'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="update_profile" class="btn-update">
                                <i class="fa-solid fa-save"></i> Save Changes
                            </button>
                            <button type="button" id="cancelEditBtn" class="btn-cancel">
                                <i class="fa-solid fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Wishlist Section -->
        <section class="profile-tab-content" id="wishlist-tab">
            <div class="profile-wishlist">
                <h1><i class="fa-solid fa-heart"></i> My Wishlist</h1>
                
                <?php if (empty($_SESSION['wishlist'])): ?>
                    <div class="empty-message">
                        <i class="fa-solid fa-heart-crack"></i>
                        <p>Your wishlist is empty</p>
                        <p class="subtitle">Add items to your wishlist by clicking the heart icon on products</p>
                        <a href="products.php" class="btn-shop">
                            <i class="fa-solid fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <div class="wishlist-grid">
                        <?php foreach ($_SESSION['wishlist'] as $product): ?>
                            <div class="wishlist-item">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="wishlist-item-info">
                                    <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                                    <p class="wishlist-price">₱<?php echo number_format($product['price'], 2); ?></p>
                                    <div class="wishlist-actions">
                                        <form method="post" action="products.php" style="display: inline;">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['price']); ?>">
                                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                                            <button type="submit" class="btn-add-to-cart">
                                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                        <form method="post" action="profile.php" style="display: inline; flex: 1;">
                                            <input type="hidden" name="remove_from_wishlist" value="<?php echo htmlspecialchars($product['id']); ?>">
                                            <button type="submit" class="btn-remove">
                                                <i class="fa-solid fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php include 'footer.php'; ?>

<script>
// Tab switching
document.querySelectorAll('.profile-tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tabName = this.getAttribute('data-tab');
        
        // Remove active class from all buttons and contents
        document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.profile-tab-content').forEach(c => c.classList.remove('active'));
        
        // Add active class to clicked button and corresponding content
        this.classList.add('active');
        document.getElementById(tabName + '-tab').classList.add('active');
    });
});

// Profile Edit/View Mode Toggle
const viewMode = document.getElementById('viewMode');
const editMode = document.getElementById('editMode');
const editToggleBtn = document.getElementById('editToggleBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');

if (editToggleBtn) {
    editToggleBtn.addEventListener('click', function() {
        viewMode.style.display = 'none';
        editMode.style.display = 'block';
        editToggleBtn.style.display = 'none';
        window.scrollTo(0, 0);
    });
}

if (cancelEditBtn) {
    cancelEditBtn.addEventListener('click', function() {
        viewMode.style.display = 'block';
        editMode.style.display = 'none';
        editToggleBtn.style.display = 'flex';
    });
}
</script>

</body>
</html>
