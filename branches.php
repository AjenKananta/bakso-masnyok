<?php
require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$pageTitle = "Cabang Kami";

require_once 'includes/header.php';
?>

<section class="branches-section">
    <h1>Cabang Bakso Mas Nyok</h1>
    
    <div class="branches-list">
        <?php foreach (getAllBranches() as $branch): ?>
            <div class="branch-card">
                <img src="assets/images/<?= $branch['image'] ?? 'branch-default.jpg' ?>" alt="<?= htmlspecialchars($branch['name']) ?>">
                <div class="branch-details">
                    <h3><?= htmlspecialchars($branch['name']) ?></h3>
                    <p><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($branch['address']) ?></p>
                    <p><i class="fas fa-phone"></i> <?= htmlspecialchars($branch['phone']) ?></p>
                    <p><i class="fas fa-clock"></i> <?= htmlspecialchars($branch['opening_hours']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="branch-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.81956135000001!3d-6.194741999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTEnNDEuMSJTIDEwNsKwNDknMTAuNCJF!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>