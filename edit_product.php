<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: admin.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $badge = $_POST['badge'] ?? '';
    $image = $product['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'images/';
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $targetFile;
        } else {
            $error = 'فشل في رفع الصورة';
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare("UPDATE products SET title = ?, description = ?, image = ?, weight = ?, badge = ? WHERE id = ?");
        $stmt->execute([$title, $description, $image, $weight, $badge, $id]);
        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل منتج</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        h1 { color: #003366; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 700; color: #333; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Cairo', sans-serif; }
        .form-group textarea { height: 100px; resize: vertical; }
        .btn { padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 700; display: inline-block; border: none; cursor: pointer; }
        .btn-primary { background: #003366; color: white; }
        .btn-primary:hover { background: #002244; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .error { color: red; margin-bottom: 15px; }
        .current-img { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>تعديل منتج</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>عنوان المنتج</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
            </div>
            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label>الوزن</label>
                <input type="text" name="weight" value="<?php echo htmlspecialchars($product['weight']); ?>" required>
            </div>
            <div class="form-group">
                <label>نص الشارة</label>
                <input type="text" name="badge" value="<?php echo htmlspecialchars($product['badge']); ?>" required>
            </div>
            <div class="form-group">
                <label>الصورة (اتركها فارغة للإبقاء على الصورة الحالية)</label>
                <input type="file" name="image" accept="image/*">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="" class="current-img">
            </div>
            <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
            <a href="admin.php" class="btn btn-secondary">إلغاء</a>
        </form>
    </div>
</body>
</html>