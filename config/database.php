<?php
$host = 'railway';
$dbname = 'bakso_masnyok';  // Diubah ke nama database baru
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
