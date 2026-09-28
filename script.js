document.addEventListener('DOMContentLoaded', () => {
    // ============================
    // Navbar & Sidebar & Smooth Scroll
    // ============================
    const navbar = document.getElementById('navbar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openBtn');
    const closeBtn = document.getElementById('closeBtn');
    const navLinks = document.querySelectorAll('.desktop-menu a, .sidebar-links a');
    const sections = document.querySelectorAll('section[id]');

    const toggleMenu = (isOpen) => {
        if (sidebar && overlay) {
            sidebar.classList.toggle('active', isOpen);
            overlay.classList.toggle('active', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        }
    };

    if (openBtn) openBtn.addEventListener('click', () => toggleMenu(true));
    if (closeBtn) closeBtn.addEventListener('click', () => toggleMenu(false));
    if (overlay) overlay.addEventListener('click', () => toggleMenu(false));

    document.querySelectorAll('.sidebar-links a').forEach(link => {
        link.addEventListener('click', () => toggleMenu(false));
    });

    const handleScroll = () => {
        const scrollY = window.pageYOffset;
        if (navbar) {
            if (scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }
        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 150;
            const sectionId = current.getAttribute('id');

            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                document.querySelector('.desktop-menu a[href*=' + sectionId + ']')?.classList.add('active');
            } else {
                document.querySelector('.desktop-menu a[href*=' + sectionId + ']')?.classList.remove('active');
            }
        });
    };

    window.addEventListener('scroll', handleScroll);

    // ============================
    // Reveal on scroll (Observer)
    // ============================
    const revealOnScroll = () => {
        const reveals = document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active-anim');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15
        });

        reveals.forEach(reveal => observer.observe(reveal));
    };

    revealOnScroll();

    // ============================
    // Smooth scroll for anchor links
    // ============================
    navLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // ============================
    // Video Showcase (Dynamic)
    // ============================
    const videos = document.querySelectorAll('.showcase-video');
    const captions = document.querySelectorAll('.caption');
    const progressLine = document.getElementById('progressLine');
    const currentNum = document.getElementById('currentNum');
    const masterPlay = document.getElementById('masterPlay');
    const masterMute = document.getElementById('masterMute');

    // لو مفيش فيديوهات أو عناصر مطلوبة، اخرج
    if (!videos.length || !masterPlay || !masterMute) return;

    let currentIdx = 0;
    let isPlaying = false;

    const switchVideo = (index) => {
        // إيقاف كل الفيديوهات
        videos.forEach(v => {
            v.classList.remove('active');
            v.pause();
            v.currentTime = 0;
        });
        captions.forEach(c => c.classList.remove('active'));

        // تفعيل الفيديو الحالي
        videos[index].classList.add('active');
        if (captions[index]) captions[index].classList.add('active');
        if (currentNum) currentNum.innerText = index + 1;

        // لو في وضع تشغيل، كمل
        if (isPlaying) {
            videos[index].play().catch(() => {});
        }

        // شريط التقدم
        videos[index].ontimeupdate = () => {
            const progress = (videos[index].currentTime / videos[index].duration) * 100 || 0;
            if (progressLine) progressLine.style.width = progress + '%';
        };

        // لما يخلص، روح للي بعده
        videos[index].onended = () => {
            currentIdx = (currentIdx + 1) % videos.length;
            switchVideo(currentIdx);
        };
    };

    // زر التشغيل الرئيسي
    masterPlay.addEventListener('click', () => {
        isPlaying = !isPlaying;
        if (isPlaying) {
            videos[currentIdx].play().catch(() => {});
            masterPlay.innerHTML = '<i class="fas fa-pause"></i>';
        } else {
            videos[currentIdx].pause();
            masterPlay.innerHTML = '<i class="fas fa-play"></i>';
        }
    });

    // زر الصوت
    masterMute.addEventListener('click', () => {
        const isMuted = videos[currentIdx].muted;
        videos.forEach(v => v.muted = !isMuted);
        masterMute.innerHTML = isMuted
            ? '<i class="fas fa-volume-up"></i>'
            : '<i class="fas fa-volume-mute"></i>';
    });

    // تشغيل أول فيديو
    switchVideo(0);
});