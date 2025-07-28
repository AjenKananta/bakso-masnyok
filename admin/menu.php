<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

redirectIfNotAdmin();

$pageTitle = "Kelola Menu";

// Tambah menu baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_menu'])) {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }
    
    $stmt = $pdo->prepare("INSERT INTO menu (name, description, price, image, is_featured) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $image, $is_featured]);
    
    header('Location: menu.php?success=1');
    exit();
}

// Hapus menu
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM menu WHERE id = ?")->execute([$id]);
    
    header('Location: menu.php?success=1');
    exit();
}

// Ambil semua menu
$stmt = $pdo->query("SELECT * FROM menu ORDER BY name");
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<section class="admin-menu">
    <h1>Kelola Menu</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert success">Menu berhasil diperbarui!</div>
    <?php endif; ?>
    
    <div class="admin-content">
        <div class="add-menu-form">
            <h2>Tambah Menu Baru</h2>
            <form action="menu.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nama Menu</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" id="price" name="price" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar</label>
                    <input type="file" id="image" name="image">
                </div>
                
                <div class="form-group checkbox">
                    <input type="checkbox" id="is_featured" name="is_featured">
                    <label for="is_featured">Menu Spesial</label>
                </div>
                
                <button type="submit" name="add_menu" class="btn">Tambah Menu</button>
            </form>
        </div>
        
        <div class="menu-list">
            <h2>Daftar Menu</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Spesial</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menuItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['description']); ?></td>
                            <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                            <td><?php echo $item['is_featured'] ? 'Ya' : 'Tidak'; ?></td>
                            <td>
                                <a href="edit_menu.php?id=<?php echo $item['id']; ?>" class="btn small">Edit</a>
                                <a href="menu.php?delete=<?php echo $item['id']; ?>" class="btn small danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>