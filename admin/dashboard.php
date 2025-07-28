<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

redirectIfNotAdmin();

$pageTitle = "Admin Dashboard";

// Hitung jumlah data
$menuCount = $pdo->query("SELECT COUNT(*) FROM menu")->fetchColumn();
$branchesCount = $pdo->query("SELECT COUNT(*) FROM branches")->fetchColumn();
$usersCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

require_once '../includes/header.php';
?>

<section class="admin-dashboard">
    <h1>Dashboard Admin</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Menu</h3>
            <p><?php echo $menuCount; ?></p>
            <a href="menu.php" class="btn">Kelola Menu</a>
        </div>
        
        <div class="stat-card">
            <h3>Total Cabang</h3>
            <p><?php echo $branchesCount; ?></p>
            <a href="branches.php" class="btn">Kelola Cabang</a>
        </div>
        
        <div class="stat-card">
            <h3>Total Pengguna</h3>
            <p><?php echo $usersCount; ?></p>
            <a href="users.php" class="btn">Kelola Pengguna</a>
        </div>
    </div>
    
    <div class="recent-activity">
        <h2>Aktivitas Terakhir</h2>
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Aktivitas</th>
                    <th>Pengguna</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data aktivitas -->
                <tr>
                    <td>2023-05-15 10:30</td>
                    <td>Menambahkan menu baru</td>
                    <td>admin</td>
                </tr>
                <tr>
                    <td>2023-05-14 15:45</td>
                    <td>Memperbarui konten beranda</td>
                    <td>admin</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>