<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$pageTitle = "Beranda";
$content = getPageContent('home');

require_once 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Bakso Terlezat di Kota</h1>
        <p>Nikmati kelezatan bakso dengan racikan bumbu spesial warisan keluarga</p>
        <a href="menu.php" class="btn">Lihat Menu</a>
    </div>
</section>

<section class="featured-menu">
    <h2>Menu Spesial</h2>
    <div class="menu-grid">
        <?php foreach (getFeaturedMenuItems() as $item): ?>
            <div class="menu-item">
                <img src="assets/images/<?= $item['image'] ?? 'default.jpg' ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p><?= htmlspecialchars($item['description']) ?></p>
                <span class="price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="about-section">
    <div class="about-content">
        <h2>Tentang Kami</h2>
        <?= $content['content'] ?? '<p>Bakso Mas Nyok berdiri sejak 1995 dengan komitmen menyajikan bakso berkualitas tinggi.</p>' ?>
        <a href="branches.php" class="btn">Lihat Cabang Kami</a>
    </div>
    <div class="about-image">
        <img src="assets/images/about.jpg" alt="Tentang Bakso Mas Nyok">
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>