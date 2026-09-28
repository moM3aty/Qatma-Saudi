<?php
require 'config.php';

// جلب المنتجات
$stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
$products = $stmt->fetchAll();

// جلب الفيديوهات
$stmt = $pdo->query("SELECT * FROM videos ORDER BY sort_order ASC, id ASC");
$videos = $stmt->fetchAll();
$videosCount = count($videos);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <!-- Basic -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title (مهم جدًا) -->
    <title>قطمة السعودية | تسالي وقرمشة لذيذة بأفضل الأسعار</title>

    <!-- SEO Description -->
    <meta name="description" content="قطمة السعودية تقدم أفضل أنواع التسالي والقرمشة في السعودية بجودة عالية وطعم مميز. اكتشف عالم السناكس اللذيذة الآن واطلب بسهولة.">

    <!-- Keywords -->
    <meta name="keywords" content="قطمة السعودية, تسالي, سناكس, بطاطس مقرمشة, مكسرات, شبس, snacks saudi arabia, chips, crunchy snacks">

    <!-- Author -->
    <meta name="author" content="قطمة السعودية">

    <!-- Robots -->
    <meta name="robots" content="index, follow">

    <!-- Canonical -->
    <link rel="canonical" href="https://www.katma-sa.com/">

    <!-- Open Graph -->
    <meta property="og:title" content="قطمة السعودية | عالم القرمشة">
    <meta property="og:description" content="أفضل تسالي وسناكس في السعودية بطعم لا يقاوم.">
    <meta property="og:image" content="https://www.katma-sa.com/images/cover.jpg">
    <meta property="og:url" content="https://www.katma-sa.com/">
    <meta property="og:type" content="website">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="قطمة السعودية">
    <meta name="twitter:description" content="تسالي لذيذة وسناكس بجودة عالية في السعودية.">
    <meta name="twitter:image" content="https://www.katma-sa.com/images/cover.jpg">

    <!-- Geo Target -->
    <meta name="geo.region" content="SA">
    <meta name="geo.placename" content="Saudi Arabia">

<meta name="google-site-verification" content="O72ItroF_xg-5y8sRK3lXGOdbIZAyn0BV4Bq6vHHYfg" />    <!-- Favicon -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Schema (Product/Brand) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Brand",
      "name": "قطمة السعودية",
      "url": "https://www.katma-sa.com",
      "logo": "https://www.katma-sa.com/logo.png",
      "description": "علامة تجارية تقدم أفضل أنواع التسالي والسناكس في السعودية."
    }
    </script>
</head>
<body>
    <div class="mobile-overlay" id="overlay"></div>
    <nav class="mobile-sidebar" id="sidebar">
        <div class="sidebar-header">
            <span class="sidebar-logo">قـطمة</span>
            <i class="fas fa-times" id="closeBtn"></i>
        </div>
        <ul class="sidebar-links">
            <li><a href="#home">الرئيسية</a></li>
            <li><a href="#about">من نحن</a></li>
            <li><a href="#products">منتجاتنا</a></li>
            <li><a href="#why-us">لماذا نحن</a></li>
            <li><a href="#contact">تواصل معنا</a></li>
        </ul>
    </nav>
    <header class="floating-nav" id="navbar">
        <div class="container nav-content">
            <div class="logo">
                <img src="images/image-removebg-preview.png" alt="لوجو قطمة">
                <span>قطمة السعودية</span>
            </div>
            <nav class="desktop-menu">
                <ul>
                    <li><a href="#home" class="active">الرئيسية</a></li>
                    <li><a href="#about">من نحن</a></li>
                    <li><a href="#products">منتجاتنا</a></li>
                    <li><a href="#why-us">لماذا تختارنا</a></li>
                    <li><a href="#contact">تواصل معنا</a></li>
                </ul>
            </nav>
            <div class="nav-actions">
                <a href="tel:+966501110836" class="call-btn d-none-mobile">
                 <i class="fas fa-phone-alt"></i>  501110836
                    
                </a>
                <div class="menu-toggle" id="openBtn">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    <section class="hero" id="home">
        <div class="hero-bg-anim"></div>
        <div class="hero-overlay"></div>
        <div class="container hero-container">
            <div class="hero-main-box">
                <h1 class="reveal-up">أهلاً بك في عالم <span>قطمة وقطميتوس</span></h1>
                <p class="reveal-up delay-1">نحن اصحاب العلامات التجاريه لمنتجات قطمه وقطميتوس وايفانو والمسجله في المملكه العربية السعودية من قبل هيئه الملكيه الفكريه. جودة تفوق الخيال وقرمشة تشعل حواسك في كل مكان.</p>
                <div class="hero-btns reveal-up delay-2">
                    <a href="#products" class="btn-orange">عرض منتجاتنا <i class="fas fa-chevron-left"></i></a>
                    <a href="#contact" class="btn-white">تواصل معنا الآن</a>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="mouse"></div>
        </div>
    </section>
    <section class="video-showcase" id="media">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="badge">عالمنا في لقطات</span>
            <h2 class="title-main">استمتع بـ <span>لحظات القرمشة</span></h2>
        </div>
        <?php if (!empty($videos)): ?>
        <div class="cinema-container reveal-up">
            <div class="video-frame">
                <div class="frame-top">
                    <div class="dots"><span></span><span></span><span></span></div>
                    <div class="vid-count">فيديو <span id="currentNum">1</span> / <?php echo $videosCount; ?></div>
                </div>
                <div class="video-wrapper">
                    <?php foreach ($videos as $index => $v): ?>
                    <video class="showcase-video <?php echo $index === 0 ? 'active' : ''; ?>" id="vid<?php echo $index + 1; ?>" muted playsinline>
                        <source src="<?php echo htmlspecialchars($v['video']); ?>" type="video/mp4">
                    </video>
                    <?php endforeach; ?>
                    <div class="video-controls-overlay">
                        <div class="play-trigger" id="masterPlay">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="mute-trigger" id="masterMute">
                            <i class="fas fa-volume-mute"></i>
                        </div>
                    </div>
                </div>
                <div class="frame-bottom">
                    <div class="progress-bar">
                        <div class="progress-inner" id="progressLine"></div>
                    </div>
                </div>
            </div>
            <div class="video-captions">
                <?php foreach ($videos as $index => $v): ?>
                <div class="caption <?php echo $index === 0 ? 'active' : ''; ?>" id="cap<?php echo $index + 1; ?>">
                    <h3><?php echo htmlspecialchars($v['title']); ?></h3>
                    <p><?php echo htmlspecialchars($v['description']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <div style="text-align:center; color:#fff; padding:60px 20px;">
            <i class="fas fa-video-slash" style="font-size:3rem; opacity:0.5; margin-bottom:15px; display:block;"></i>
            <p style="font-size:1.1rem;">لا توجد فيديوهات حالياً</p>
        </div>
        <?php endif; ?>
    </div>
    </section>
    <section class="about-premium" id="about">
    <div class="container about-wrapper">
                <div class="about-visual reveal-left">
            <div class="deco-circle"></div> 
            <div class="image-mask">
                <img src="images/WhatsApp Image 2026-05-09 at 2.12.01 PM.jpeg" alt="عن قطمة السعودية" class="about-img">
            </div>
            <div class="experience-badge">
                <span class="num">10+</span>
                <span class="txt">أعوم من التميز</span>
            </div>
        </div>
        <div class="about-info reveal-right">
            <div class="section-tag">قـصة الـنجاح</div>
            <h2 class="section-title">قطمة السعودية.. <span>رؤية عالمية</span> في قلب المملكة</h2>
            <p class="about-desc">
                نحن لسنا مجرد وكيل تجاري، بل نحن حلقة الوصل بين الطعم الأصيل والمستهلك السعودي الباحث عن التميز. بصفتنا <strong>الوكيل المعتمد لمنتجات قطمة وقطميتوس وإيفانو</strong>، نلتزم بتقديم تجربة استثنائية في كل قرمشة.
            </p>

            <ul class="about-features">
                <li>
                    <div class="icon-wrap"><i class="fas fa-shipping-fast"></i></div>
                    <div class="text-wrap">
                        <h4>تغطية لوجستية ذكية</h4>
                        <p>نصل بمنتجاتنا إلى أبعد نقطة في المملكة العربية السعودية بأعلى معايير الجودة.</p>
                    </div>
                </li>
                <li>
                    <div class="icon-wrap"><i class="fas fa-check-double"></i></div>
                    <div class="text-wrap">
                        <h4>معايير جودة عالمية</h4>
                        <p>نضمن سلامة ونضارة المنتجات لتصل إليكم طازجة وبنكهتها الأصلية دائماً.</p>
                    </div>
                </li>
            </ul>

            <div class="about-cta-box">
                <a href="#products" class="btn-primary-about">استكشف عالمنا</a>
                
            </div>
        </div>

    </div>
    </section>
    <section class="strategy-section" id="strategy">
    <div class="container">
        
        <div class="strategy-grid">
                <div class="strategy-card reveal-up">
                <div class="card-icon"><i class="fas fa-eye"></i></div>
                <h3>رؤيتنا</h3>
                <p>أن نكون الخيار الأول والوكيل الرائد في قطاع المقرمشات و الويفر بالمملكة، من خلال تقديم تجربة مذاق مبتكرة تلبي طموحات عملائنا وترتقي بمعايير الجودة العالمية.</p>
            </div>
            <div class="strategy-card reveal-up" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-bullseye"></i></div>
                <h3>رسالتنا</h3>
                <p>توفير أجود منتجات قطمة وقطميتوس وإيفانو لجميع مناطق المملكة عبر شبكة توزيع احترافية، وبناء شراكات مستدامة تحقق القيمة المضافة للمستهلك والشركاء على حد سواء.</p>
            </div>
            <div class="strategy-card reveal-up" style="transition-delay: 0.4s;">
                <div class="card-icon"><i class="fas fa-tasks"></i></div>
                <h3>أهدافنا</h3>
                <ul class="strategy-list">
                    <li>التوسع في شبكة التوزيع لتغطية كافة مدن المملكة.</li>
                    <li>تعزيز محفظة العلامات التجارية العالمية في السوق السعودي.</li>
                    <li>تحقيق أعلى مستويات الرضا والكفاءة التشغيلية.</li>
                </ul>
            </div>
        </div>
        <div class="vision-2030-container reveal-up">
            <div class="vision-centered-content">
        <img src="images/vision.jpeg" alt="رؤية المملكة 2030" class="vision-logo-img">
    </div>
    <div class="saudi-decoration"></div>
</div>
    </div>
    </section>
    <section class="products-section" id="products">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="badge">عالم القرمشة</span>
            <h2 class="title-glow">تشكيلة <span>منتجاتنا</span> الفاخرة</h2>
            <p class="section-p">من قلب مصانعنا إليكم.. نختار أجود المكونات لنقدم لكم نكهات لا تُقاوم ترضي جميع الأذواق.</p>
        </div>
        <div class="products-grid">
            <?php if (!empty($products)): ?>
                <?php $i = 0; foreach ($products as $product): $i++; ?>
                <div class="product-card reveal-up" style="transition-delay: <?php echo ($i * 0.1); ?>s;">
                    <div class="card-img">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    </div>
                    <div class="card-info">
                        <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="card-footer">
                            <span class="weight"><?php echo htmlspecialchars($product['weight']); ?></span>
                            <div class="saudi-made"><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($product['badge']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#fff; text-align:center; width:100%; grid-column: 1 / -1;">لا توجد منتجات حالياً</p>
            <?php endif; ?>
        </div>
    </div>
    </section>
    <section class="why-us-creative" id="why-us">
    <div class="dynamic-aurora"></div>

    <div class="container">
        <div class="why-header reveal-up">
            <h2 class="glow-title">لماذا نحن <span>الخيار الأول؟</span></h2>
            <p class="sub-text">نحن نبني جسوراً من الثقة والمذاق الأصيل، لنكون وجهتك الدائمة للتميز والقرمشة.</p>
        </div>

        <div class="why-grid-exclusive">
            <div class="why-card-item reveal-up" style="--clr:#ff6600;">
                <div class="card-glass"></div>
                <div class="content">
                    <div class="icon-box"><i class="fas fa-crown"></i></div>
                    <h3>وكيل معتمد وحصري</h3>
                    <p>نحن اصحاب العلامات التجاريه لمنتجات قطمه وقطميتوس وايفان والمسجله في المملكة العربية السعودية من  هيئه الملكيه الفكريه ونقوم بتضنيع منتجاتنا بعنايه  داخل المملكه العربيه السعوديه</p>
                </div>
            </div>
            <div class="why-card-item reveal-up" style="--clr:#00d2ff; transition-delay: 0.2s;">
                <div class="card-glass"></div>
                <div class="content">
                    <div class="icon-box"><i class="fas fa-shield-heart"></i></div>
                    <h3>معايير جودة صارمة</h3>
                    <p>نلتزم بأدق معايير سلامة الغذاء العالمية، لضمان وصول كل قطعة إليكم طازجة، مقرمشة، ومحضرة بعناية فائقة.</p>
                </div>
            </div>
            <div class="why-card-item reveal-up" style="--clr:#ff0055; transition-delay: 0.4s;">
                <div class="card-glass"></div>
                <div class="content">
                    <div class="icon-box"><i class="fas fa-map-location-dot"></i></div>
                    <h3>تغطية شاملة</h3>
                    <p>بأسطول لوجستي متطور، نصل إلى كافة أنحاء المملكة العربية السعودية لنلبي طلباتكم في أسرع وقت وبكفاءة عالية.</p>
                </div>
            </div>
            <div class="why-card-item reveal-up" style="--clr:#00ff88; transition-delay: 0.6s;">
                <div class="card-glass"></div>
                <div class="content">
                    <div class="icon-box"><i class="fas fa-handshake"></i></div>
                    <h3>شراكة استراتيجية</h3>
                    <p>نحن شريك النجاح لكبرى المتاجر، ونفخر بثقة آلاف المستهلكين الذين جعلونا جزءاً من لحظاتهم السعيدة يومياً.</p>
                </div>
            </div>
        </div>
    </div>
    </section>
    <section class="final-contact-section" id="contact">
    <div class="background-animation">
        <span></span><span></span><span></span><span></span>
    </div>
    
    <div class="container">
        <div class="contact-header reveal-up">
            <h2 class="ultra-title">لا تتردد في <span>مراسلتنا</span></h2>
            <p class="ultra-p">نحن دائماً بالقرب منك، لضمان وصول أفضل منتجات قطمة وقطميتوس إليك في أي مكان بالمملكة.</p>
        </div>

        <div class="cards-stack">
            <div class="contact-card whatsapp-card reveal-right">
                <div class="card-icon"><i class="fab fa-whatsapp"></i></div>
                <div class="card-text">
                    <h3>تواصل عبر الواتساب</h3>
                    <p>رد فوري على جميع استفساراتكم وطلباتكم</p>
                </div>
                <a href="https://wa.me/966501110836" class="card-action-btn">أرسل رسالة</a>
            </div>
            <div class="contact-card phone-card reveal-left">
                <div class="card-icon"><i class="fas fa-phone-alt"></i></div>
                <div class="card-text">
                    <h3>اتصال هاتفي مباشر</h3>
                    <p>تحدث معنا الآن: 501110836</p>
                </div>
                <a href="tel:+966501110836" class="card-action-btn">اتصل الآن</a>
            </div>
            <div class="contact-card location-card reveal-right">
                <div class="card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="card-text">
                    <h3>مقرنا الرئيسي</h3>
                    <p>المملكة العربية السعودية - تغطية شاملة لجميع المناطق</p>
                </div>
              <a href="https://www.google.com/maps/place/Al-takhasosy,+Al+Hamra+Umm+Al+Jud,+Makkah+Saudi+Arabia/@21.3999,39.706,17z/data=!4m6!3m5!1s0x15c219c5372310e7:0x5d3ab8e1b4e88337!8m2!3d21.3999349!4d39.7059838!16s%2Fg%2F1jkxrgwp1?hl=en&entry=ttu&g_ep=EgoyMDI2MDUwNi4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="card-action-btn">عرض الخريطة</a>            </div>
        </div>
        <footer class="exclusive-footer">
            <div class="footer-content">
                <p class="copyright">جميع الحقوق محفوظة لشركة قطمة السعودية © 2026</p>
                <p class="designer">تصميم وبرمجة <a href="https://www.facebook.com/share/17UzqgSwiu/" target="_blank">GMTWeb</a></p>
            </div>
        </footer>
    </div>
    </section>
    <div class="fixed-floating-btns">
    <a href="https://wa.me/966501110836" class="fab-btn wa-fab" target="_blank"><i class="fab fa-whatsapp"></i></a>
    <a href="tel:+966501110836" class="fab-btn call-fab"><i class="fas fa-phone-alt"></i></a>
    <a href="#products" class="fab-btn prod-fab"><i class="fas fa-th-large"></i></a>
    </div>
    <script src="script.js"></script>
</body>
</html>