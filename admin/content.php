<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

// Debugging - tampilkan data session
echo '<pre>'; print_r($_SESSION); echo '</pre>';

// Verifikasi admin
redirectIfNotAdmin();

$pageTitle = "Kelola Konten";

// Proses update konten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_content'])) {
    try {
        $stmt = $pdo->prepare("UPDATE content SET title = ?, content = ? WHERE page = ?");
        $stmt->execute([
            $_POST['title'],
            $_POST['content'],
            $_POST['page']
        ]);
        
        $_SESSION['success'] = "Konten berhasil diperbarui!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal update konten: " . $e->getMessage();
    }
    
    header("Location: content.php");
    exit();
}

// Ambil data konten
try {
    $stmt = $pdo->query("SELECT * FROM content");
    $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error mengambil konten: " . $e->getMessage());
}

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Tampilkan pesan error/success -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="container mt-4">
    <h2>Kelola Konten Website</h2>
    
    <div class="row">
        <?php foreach ($contents as $content): ?>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><?= ucfirst($content['page']) ?></h3>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="page" value="<?= $content['page'] ?>">
                        
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" class="form-control" 
                                   value="<?= htmlspecialchars($content['title']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Isi Konten</label>
                            <textarea name="content" class="form-control" rows="5" required><?= 
                                htmlspecialchars($content['content']) 
                            ?></textarea>
                        </div>
                        
                        <button type="submit" name="update_content" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>