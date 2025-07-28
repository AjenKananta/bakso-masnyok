<?php
function getPageContent($page) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM content WHERE page = ?");
        $stmt->execute([$page]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Return default content if error occurs
        return [
            'title' => 'Welcome',
            'content' => '<p>Default content</p>'
        ];
    }
}

function getAllMenuItems() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM menu ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFeaturedMenuItems() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM menu WHERE is_featured = TRUE LIMIT 3");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllBranches() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM branches ORDER BY name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>