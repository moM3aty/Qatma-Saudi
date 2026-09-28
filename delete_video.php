<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
if ($id) {
    $stmt = $pdo->prepare("SELECT video FROM videos WHERE id = ?");
    $stmt->execute([$id]);
    $video = $stmt->fetch();
    if ($video && !empty($video['video']) && strpos($video['video'], 'videos/') === 0 && file_exists($video['video'])) {
        @unlink($video['video']);
    }

    $stmt = $pdo->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: admin_videos.php?success=deleted');
exit;
?>