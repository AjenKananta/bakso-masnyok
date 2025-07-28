<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

redirectIfNotAdmin();

$pageTitle = "Kelola Cabang";

// Tambah cabang baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_branch'])) {
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $opening_hours = $_POST['opening_hours'] ?? '';
    
    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../assets/images/';
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $image);
    }
    
    $stmt = $pdo->prepare("INSERT INTO branches (name, address, phone, email, opening_hours, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $address, $phone, $email, $opening_hours, $image]);
    
    header('Location: branches.php?success=1');
    exit();
}

// Hapus cabang
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM branches WHERE id = ?")->execute([$id]);
    
    header('Location: branches.php?success=1');
    exit();
}

// Ambil semua cabang
$stmt = $pdo->query("SELECT * FROM branches ORDER BY name");
$branches = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<section class="admin-branches">
    <h1>Kelola Cabang</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert success">Cabang berhasil diperbarui!</div>
    <?php endif; ?>
    
    <div class="admin-content">
        <div class="add-branch-form">
            <h2>Tambah Cabang Baru</h2>
            <form action="branches.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nama Cabang</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Telepon</label>
                    <input type="text" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <div class="form-group">
                    <label for="opening_hours">Jam Buka</label>
                    <input type="text" id="opening_hours" name="opening_hours">
                </div>
                
                <div class="form-group">
                    <label for="image">Gambar</label>
                    <input type="file" id="image" name="image">
                </div>
                
                <button type="submit" name="add_branch" class="btn">Tambah Cabang</button>
            </form>
        </div>
        
        <div class="branches-list">
            <h2>Daftar Cabang</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branches as $branch): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($branch['name']); ?></td>
                            <td><?php echo htmlspecialchars($branch['address']); ?></td>
                            <td><?php echo htmlspecialchars($branch['phone']); ?></td>
                            <td>
                                <a href="edit_branch.php?id=<?php echo $branch['id']; ?>" class="btn small">Edit</a>
                                <a href="branches.php?delete=<?php echo $branch['id']; ?>" class="btn small danger" onclick="return confirm('Yakin ingin menghapus cabang ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>