<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$pageTitle = "Menu";

require_once 'includes/header.php';
?>

<section class="menu-section">
    <h1>Menu Bakso Mas Nyok</h1>
    
    <div class="menu-categories">
        <button class="category-btn active" data-category="all">Semua</button>
        <button class="category-btn" data-category="bakso">Bakso</button>
        <button class="category-btn" data-category="mie">Mie</button>
        <button class="category-btn" data-category="minuman">Minuman</button>
    </div>
    
    <div class="menu-items">
        <?php foreach (getAllMenuItems() as $item): 
            $category = strtolower(explode(' ', $item['name'])[0]);
        ?>
            <div class="menu-item" data-category="<?= $category ?>">
                <img src="assets/images/<?= $item['image'] ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <div class="menu-item-details">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                    <span class="price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>