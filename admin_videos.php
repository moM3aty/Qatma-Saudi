<?php
require 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM videos ORDER BY sort_order ASC, id ASC");
$videos = $stmt->fetchAll();
$totalVideos = count($videos);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الفيديوهات | قطمة السعودية</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background: #f0f4f8; min-height: 100vh; display: flex; color: #1a1a2e; }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #001d3d 0%, #003366 100%);
            color: white;
            padding: 30px 20px;
            position: fixed;
            top: 0; right: 0;
            height: 100vh;
            display: flex; flex-direction: column;
            transition: 0.4s;
            z-index: 1000;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding-bottom: 25px; margin-bottom: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-logo {
            width: 50px; height: 50px;
            background: linear-gradient(135deg, #ff6600, #ff9900);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.4);
        }
        .sidebar-brand h2 { font-size: 1.1rem; font-weight: 900; }
        .sidebar-brand span { display: block; font-size: 0.75rem; opacity: 0.6; font-weight: 600; }

        .nav-list { list-style: none; flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .nav-list a {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700; font-size: 0.95rem;
            transition: 0.3s;
        }
        .nav-list a i { font-size: 1.1rem; width: 22px; text-align: center; }
        .nav-list a:hover { background: rgba(255, 255, 255, 0.08); color: white; }
        .nav-list a.active {
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.35);
        }
        .nav-list a.logout { color: #ff6b7a; }
        .nav-list a.logout:hover { background: rgba(220, 53, 69, 0.15); color: #ff6b7a; }

        /* MAIN */
        .main { flex: 1; margin-right: 280px; padding: 30px 40px; min-height: 100vh; }

        .topbar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 35px; flex-wrap: wrap; gap: 15px;
        }
        .page-title h1 { font-size: 1.9rem; font-weight: 900; color: #001d3d; margin-bottom: 5px; }
        .page-title p { font-size: 0.9rem; color: #666; font-weight: 600; }
        .user-chip {
            display: flex; align-items: center; gap: 12px;
            background: white;
            padding: 10px 18px 10px 10px;
            border-radius: 50px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
        }
        .user-avatar {
            width: 42px; height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #003366, #001d3d);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 900; font-size: 1.1rem;
        }
        .user-info strong { display: block; font-size: 0.95rem; color: #001d3d; }
        .user-info span { font-size: 0.75rem; color: #888; font-weight: 600; }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 35px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            display: flex; align-items: center; gap: 18px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); }
        .stat-icon {
            width: 60px; height: 60px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: white;
        }
        .stat-icon.orange { background: linear-gradient(135deg, #ff6600, #ff9900); box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3); }
        .stat-icon.blue { background: linear-gradient(135deg, #003366, #0055aa); box-shadow: 0 8px 20px rgba(0, 51, 102, 0.3); }
        .stat-info .num { font-size: 1.8rem; font-weight: 900; color: #001d3d; line-height: 1; }
        .stat-info .lbl { font-size: 0.85rem; color: #888; font-weight: 700; margin-top: 5px; }

        /* ACTIONS BAR */
        .actions-bar {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; flex-wrap: wrap; gap: 15px;
        }
        .section-heading {
            font-size: 1.3rem; font-weight: 900; color: #001d3d;
            display: flex; align-items: center; gap: 10px;
        }
        .section-heading i { color: #ff6600; }
        .add-btn {
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            padding: 13px 26px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 800;
            display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 10px 25px rgba(255, 102, 0, 0.3);
            transition: 0.3s; font-size: 0.95rem;
        }
        .add-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(255, 102, 0, 0.5); }

        /* VIDEO GRID */
        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .video-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
        }
        .video-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }
        .video-preview {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            background: #000;
            overflow: hidden;
        }
        .video-preview video {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        .order-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #ff6600, #ff9900);
            color: white;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
            z-index: 2;
        }
        .video-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .video-body h3 {
            font-size: 1.1rem;
            font-weight: 900;
            color: #001d3d;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .video-body p {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.6;
            font-weight: 600;
            flex: 1;
            margin-bottom: 15px;
        }
        .video-actions {
            display: flex; gap: 8px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }
        .action-btn {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            gap: 6px;
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 800;
            transition: 0.3s;
            border: none;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
        }
        .action-btn.edit { background: linear-gradient(135deg, #ffc107, #ff9800); }
        .action-btn.edit:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(255, 193, 7, 0.5); }
        .action-btn.delete { background: linear-gradient(135deg, #dc3545, #c82333); }
        .action-btn.delete:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(220, 53, 69, 0.5); }

        .empty-state {
            padding: 70px 20px;
            text-align: center;
            color: #999;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }
        .empty-state i { font-size: 4rem; color: #ddd; margin-bottom: 20px; display: block; }
        .empty-state h3 { font-size: 1.3rem; color: #666; margin-bottom: 10px; font-weight: 800; }
        .empty-state p { font-size: 0.95rem; margin-bottom: 25px; }

        /* MOBILE */
        .mobile-toggle {
            display: none;
            position: fixed; top: 20px; right: 20px; z-index: 1100;
            width: 50px; height: 50px;
            border-radius: 14px;
            background: linear-gradient(135deg, #003366, #001d3d);
            color: white; border: none; font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        @media (max-width: 900px) {
            .sidebar { transform: translateX(100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-right: 0; padding: 80px 20px 30px; }
            .mobile-toggle { display: flex; align-items: center; justify-content: center; }
            .page-title h1 { font-size: 1.4rem; }
        }

        .swal2-popup { font-family: 'Cairo', sans-serif !important; border-radius: 20px !important; }
        .swal2-title { font-weight: 900 !important; color: #001d3d !important; }
    </style>
</head>
<body>
    <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-logo"><i class="fas fa-cookie-bite"></i></div>
            <div>
                <h2>قطمة السعودية</h2>
                <span>لوحة التحكم</span>
            </div>
        </div>
        <ul class="nav-list">
            <li><a href="admin.php"><i class="fas fa-th-large"></i> المنتجات</a></li>
            <li><a href="admin_videos.php" class="active"><i class="fas fa-video"></i> الفيديوهات</a></li>
            <li><a href="index.php" target="_blank"><i class="fas fa-globe"></i> عرض الموقع</a></li>
            <li><a href="add_product.php"><i class="fas fa-plus-circle"></i> إضافة منتج</a></li>
            <li style="margin-top: auto;"><a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</a></li>
        </ul>
    </aside>

    <main class="main">
        <div class="topbar">
            <div class="page-title">
                <h1>إدارة الفيديوهات 🎬</h1>
                <p>تحكم كامل في فيديوهات موقعك</p>
            </div>
            <div class="user-chip">
                <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?></div>
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>
                    <span>مدير النظام</span>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-video"></i></div>
                <div class="stat-info">
                    <div class="num"><?php echo $totalVideos; ?></div>
                    <div class="lbl">إجمالي الفيديوهات</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-play-circle"></i></div>
                <div class="stat-info">
                    <div class="num">مباشر</div>
                    <div class="lbl">حالة العرض</div>
                </div>
            </div>
        </div>

        <div class="actions-bar">
            <div class="section-heading"><i class="fas fa-film"></i> كل الفيديوهات</div>
            <a href="add_video.php" class="add-btn"><i class="fas fa-plus"></i> إضافة فيديو جديد</a>
        </div>

        <?php if (!empty($videos)): ?>
        <div class="videos-grid">
            <?php foreach ($videos as $v): ?>
            <div class="video-card">
                <div class="video-preview">
                    <span class="order-badge"># <?php echo $v['sort_order']; ?></span>
                    <video muted preload="metadata">
                        <source src="<?php echo htmlspecialchars($v['video']); ?>" type="video/mp4">
                    </video>
                </div>
                <div class="video-body">
                    <h3><?php echo htmlspecialchars($v['title']); ?></h3>
                    <p><?php echo htmlspecialchars($v['description']); ?></p>
                    <div class="video-actions">
                        <a href="edit_video.php?id=<?php echo $v['id']; ?>" class="action-btn edit"><i class="fas fa-pen"></i> تعديل</a>
                        <button type="button" class="action-btn delete delete-btn"
                            data-id="<?php echo $v['id']; ?>"
                            data-title="<?php echo htmlspecialchars($v['title']); ?>">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-video-slash"></i>
            <h3>لا توجد فيديوهات بعد</h3>
            <p>ابدأ بإضافة أول فيديو الآن</p>
            <a href="add_video.php" class="add-btn" style="display:inline-flex;"><i class="fas fa-plus"></i> إضافة فيديو</a>
        </div>
        <?php endif; ?>
    </main>

    <script>
        const toggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        if (toggle) toggle.addEventListener('click', () => sidebar.classList.toggle('open'));

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        const params = new URLSearchParams(window.location.search);
        const success = params.get('success');
        if (success === 'added') {
            Toast.fire({ icon: 'success', title: 'تم إضافة الفيديو بنجاح 🎬' });
            history.replaceState({}, '', 'admin_videos.php');
        } else if (success === 'updated') {
            Toast.fire({ icon: 'success', title: 'تم تعديل الفيديو بنجاح ✅' });
            history.replaceState({}, '', 'admin_videos.php');
        } else if (success === 'deleted') {
            Toast.fire({ icon: 'success', title: 'تم حذف الفيديو بنجاح 🗑️' });
            history.replaceState({}, '', 'admin_videos.php');
        }

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const title = this.dataset.title;

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    html: `سيتم حذف الفيديو:<br><strong style="color:#ff6600; font-size:1.1rem;">"${title}"</strong><br><span style="color:#999; font-size:0.85rem;">لا يمكن استرجاع الفيديو بعد الحذف</span>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash"></i> نعم، احذف',
                    cancelButtonText: 'إلغاء',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'جاري الحذف...',
                            text: 'الرجاء الانتظار',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        window.location.href = 'delete_video.php?id=' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>