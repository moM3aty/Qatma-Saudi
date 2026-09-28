document.addEventListener('DOMContentLoaded', () => {
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
    navLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId.startsWith('#')) {
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
});
document.addEventListener('DOMContentLoaded', () => {
    const contactObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active-anim');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal-up, .reveal-right, .reveal-left').forEach(el => {
        contactObserver.observe(el);
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const videos = document.querySelectorAll('.showcase-video');
    const captions = document.querySelectorAll('.caption');
    const progressLine = document.getElementById('progressLine');
    const currentNum = document.getElementById('currentNum');
    const masterPlay = document.getElementById('masterPlay');
    const masterMute = document.getElementById('masterMute');
    let currentIdx = 0;
    let isPlaying = false;
    const switchVideo = (index) => {
        videos.forEach(v => { v.classList.remove('active'); v.pause(); v.currentTime = 0; });
        captions.forEach(c => c.classList.remove('active'));

        videos[index].classList.add('active');
        captions[index].classList.add('active');
        currentNum.innerText = index + 1;

        if (isPlaying) {
            videos[index].play();
        }
        videos[index].ontimeupdate = () => {
            const progress = (videos[index].currentTime / videos[index].duration) * 100;
            progressLine.style.width = progress + '%';
        };

        videos[index].onended = () => {
            currentIdx = (currentIdx + 1) % videos.length;
            switchVideo(currentIdx);
        };
    };
    masterPlay.addEventListener('click', () => {
        isPlaying = !isPlaying;
        if (isPlaying) {
            videos[currentIdx].play();
            masterPlay.innerHTML = '<i class="fas fa-pause"></i>';
        } else {
            videos[currentIdx].pause();
            masterPlay.innerHTML = '<i class="fas fa-play"></i>';
        }
    });
    masterMute.addEventListener('click', () => {
        const isMuted = videos[currentIdx].muted;
        videos.forEach(v => v.muted = !isMuted);
        masterMute.innerHTML = isMuted ? '<i class="fas fa-volume-up"></i>' : '<i class="fas fa-volume-mute"></i>';
    });
    switchVideo(0);
});