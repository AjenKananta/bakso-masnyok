<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

redirectIfNotAdmin();

$pageTitle = "Kelola Pengguna";

// Tambah pengguna baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password, $role]);
    
    header('Location: users.php?success=1');
    exit();
}

// Hapus pengguna
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Jangan izinkan menghapus admin utama
    if ($id != 1) {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
    }
    
    header('Location: users.php?success=1');
    exit();
}

// Ambil semua pengguna
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
?>

<section class="admin-users">
    <h1>Kelola Pengguna</h1>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert success">Pengguna berhasil diperbarui!</div>
    <?php endif; ?>
    
    <div class="admin-content">
        <div class="add-user-form">
            <h2>Tambah Pengguna Baru</h2>
            <form action="users.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <button type="submit" name="add_user" class="btn">Tambah Pengguna</button>
            </form>
        </div>
        
        <div class="users-list">
            <h2>Daftar Pengguna</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo ucfirst($user['role']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <?php if ($user['id'] != 1): ?>
                                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn small">Edit</a>
                                    <a href="users.php?delete=<?php echo $user['id']; ?>" class="btn small danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>