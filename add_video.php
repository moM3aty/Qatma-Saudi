<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $video_url_input = trim($_POST['video_url'] ?? '');
    $video = '';

    // الأولوية للرابط النصي
    if (!empty($video_url_input)) {
        $video = $video_url_input;
    }
    // لو مفيش رابط، نجرب رفع ملف
    elseif (isset($_FILES['video_file']) && $_FILES['video_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'videos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $ext = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
        $filename = 'video_' . time() . '.' . $ext;
        $targetFile = $uploadDir . $filename;
        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $targetFile)) {
            $video = $targetFile;
        } else {
            $error = 'فشل في رفع الفيديو';
        }
    } else {
        $error = 'الرجاء اختيار ملف فيديو أو إدخال رابط';
    }

    if (empty($error) && !empty($video)) {
        $stmt = $pdo->prepare("INSERT INTO videos (title, description, video, sort_order) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $video, $sort_order]);
        header('Location: admin_videos.php?success=added');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة فيديو جديد</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eef4fb 0%, #e3ecf7 100%);
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .form-container {
            background: white;
            border-radius: 24px;
            padding: 40px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 51, 102, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        .form-header {
            display: flex; align-items: center; gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f4f8;
        }
        .header-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #ff6600, #ff9900);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.5rem;
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
        }
        .form-header h1 { font-size: 1.6rem; color: #001d3d; font-weight: 900; }
        .form-header p { font-size: 0.9rem; color: #888; font-weight: 600; margin-top: 4px; }

        .form-group { margin-bottom: 22px; }
        .form-group label {
            display: block; margin-bottom: 8px;
            font-weight: 800; color: #001d3d; font-size: 0.92rem;
        }
        .form-group label i { color: #ff6600; margin-left: 6px; }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e8eef5;
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            color: #333;
            transition: 0.3s;
            outline: none;
            background: #fafbfd;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #ff6600;
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 102, 0, 0.1);
        }
        .form-group textarea { height: 90px; resize: vertical; line-height: 1.6; }

        .divider {
            display: flex; align-items: center; gap: 15px;
            margin: 25px 0;
            color: #999; font-weight: 700; font-size: 0.85rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e8eef5;
        }

        .file-upload {
            position: relative;
            border: 2px dashed #cfdae8;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            background: #fafbfd;
            transition: 0.3s;
            cursor: pointer;
            display: block;
        }
        .file-upload:hover { border-color: #ff6600; background: rgba(255, 102, 0, 0.03); }
        .file-upload input[type="file"] { display: none; }
        .file-upload i { font-size: 2rem; color: #ff6600; margin-bottom: 10px; display: block; }
        .file-upload p { font-weight: 700; color: #003366; font-size: 0.95rem; margin-bottom: 4px; }
        .file-upload span { font-size: 0.8rem; color: #999; font-weight: 600; }
        .file-name {
            display: none; margin-top: 12px;
            padding: 8px 14px;
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border-radius: 8px;
            font-size: 0.85rem; font-weight: 700;
        }
        .video-preview {
            display: none;
            margin-top: 15px;
            border-radius: 12px;
            overflow: hidden;
        }
        .video-preview video {
            width: 100%;
            max-height: 250px;
            background: #000;
            border-radius: 12px;
        }
        .hint {
            font-size: 0.8rem;
            color: #ff6600;
            font-weight: 700;
            margin-top: 6px;
            display: flex; align-items: center; gap: 6px;
        }

        .form-actions {
            display: flex; gap: 12px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #f0f4f8;
            flex-wrap: wrap;
        }
        .btn {
            padding: 14px 32px;
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
            font-weight: 800; font-size: 0.95rem;
            border: none; cursor: pointer;
            text-decoration: none;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px;
            transition: 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
            flex: 1;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(255, 102, 0, 0.5); }
        .btn-secondary { background: #eef2f7; color: #003366; }
        .btn-secondary:hover { background: #dde6f0; }

        @media (max-width: 600px) {
            .form-container { padding: 25px 20px; }
            .form-header h1 { font-size: 1.3rem; }
            .form-actions { flex-direction: column-reverse; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="header-icon"><i class="fas fa-video"></i></div>
            <div>
                <h1>إضافة فيديو جديد</h1>
                <p>ارفع ملف فيديو أو أدخل رابط مباشر</p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label><i class="fas fa-heading"></i> عنوان الفيديو (يظهر كتعليق أسفل الفيديو)</label>
                <input type="text" name="title" placeholder="مثال: نكهة تشعل الحواس" required>
            </div>

            <div class="form-group">
                <label><i class="fas fa-align-right"></i> وصف الفيديو</label>
                <textarea name="description" placeholder="وصف قصير يظهر تحت الفيديو..." required></textarea>
            </div>

            <div class="form-group">
                <label><i class="fas fa-sort-numeric-up"></i> ترتيب الظهور</label>
                <input type="number" name="sort_order" placeholder="0" value="0" min="0">
                <div class="hint"><i class="fas fa-info-circle"></i> الأرقام الأصغر تظهر أولاً</div>
            </div>

            <div class="divider">اختر طريقة رفع الفيديو</div>

            <div class="form-group">
                <label><i class="fas fa-cloud-upload-alt"></i> رفع ملف فيديو (MP4)</label>
                <label class="file-upload" for="videoInput">
                    <input type="file" name="video_file" id="videoInput" accept="video/mp4,video/webm">
                    <i class="fas fa-file-video"></i>
                    <p>اضغط لاختيار ملف فيديو</p>
                    <span>MP4 أو WEBM</span>
                    <div class="file-name" id="fileName"></div>
                </label>
                <div class="video-preview" id="videoPreview">
                    <video controls></video>
                </div>
            </div>

            <div class="divider">أو</div>

            <div class="form-group">
                <label><i class="fas fa-link"></i> رابط الفيديو (اختياري)</label>
                <input type="text" name="video_url" placeholder="مثال: videos/vid1.mp4 أو رابط مباشر">
                <div class="hint"><i class="fas fa-info-circle"></i> لو دخلت رابط، سيتم تجاهل الملف المرفوع</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ الفيديو</button>
                <a href="admin_videos.php" class="btn btn-secondary"><i class="fas fa-times"></i> إلغاء</a>
            </div>
        </form>
    </div>

    <script>
        const input = document.getElementById('videoInput');
        const fileName = document.getElementById('fileName');
        const preview = document.getElementById('videoPreview');
        const previewVid = preview.querySelector('video');

        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                fileName.style.display = 'inline-block';
                fileName.textContent = '✓ ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB)';

                const url = URL.createObjectURL(file);
                previewVid.src = url;
                preview.style.display = 'block';
            }
        });

        <?php if ($error): ?>
        Swal.fire({
            icon: 'error',
            title: 'حدث خطأ',
            text: '<?php echo $error; ?>',
            confirmButtonText: 'حسناً',
            confirmButtonColor: '#ff6600'
        });
        <?php endif; ?>
    </script>
</body>
</html>