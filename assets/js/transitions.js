<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seamless Page Transitions</title>
    <style>
        /* ==========================================
           FADE TRANSITION EFFECT
           ========================================== */
        
        /* Overlay untuk transisi */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }

        .page-transition-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Loading spinner */
        .transition-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ==========================================
           SLIDE TRANSITION EFFECT
           ========================================== */
        
        .page-transition-slide {
            position: fixed;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            transition: left 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-transition-slide.active {
            left: 0;
        }

        /* ==========================================
           CURTAIN TRANSITION EFFECT
           ========================================== */
        
        .page-transition-curtain {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-transition-curtain.active {
            height: 100%;
        }

        /* ==========================================
           ZOOM TRANSITION EFFECT
           ========================================== */
        
        body.page-transitioning {
            overflow: hidden;
        }

        .page-content {
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        body.zoom-out .page-content {
            transform: scale(0.9);
            opacity: 0;
        }

        /* ==========================================
           SMOOTH SCROLL BEHAVIOR
           ========================================== */
        
        html {
            scroll-behavior: smooth;
        }

        /* ==========================================
           FADE IN ANIMATION FOR PAGE LOAD
           ========================================== */
        
        body {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* ==========================================
           NAVIGATION HOVER EFFECTS
           ========================================== */
        
        .navbar-nav .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #667eea;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after {
            width: 80%;
        }

        /* ==========================================
           CARD HOVER ANIMATIONS
           ========================================== */
        
        .card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* ==========================================
           BUTTON ANIMATIONS
           ========================================== */
        
        .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn:active {
            transform: scale(0.95);
        }

        /* ==========================================
           SCROLL REVEAL ANIMATIONS
           ========================================== */
        
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal-left.active {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal-right.active {
            opacity: 1;
            transform: translateX(0);
        }

        /* ==========================================
           STAGGER ANIMATION
           ========================================== */
        
        .stagger-item {
            opacity: 0;
            transform: translateY(30px);
            animation: staggerIn 0.6s ease forwards;
        }

        @keyframes staggerIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
        .stagger-item:nth-child(5) { animation-delay: 0.5s; }
        .stagger-item:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>

<!-- Overlay untuk transisi (pilih salah satu) -->
<div class="page-transition-overlay">
    <div class="transition-spinner"></div>
</div>

<!-- ATAU gunakan slide transition -->
<!-- <div class="page-transition-slide"></div> -->

<!-- ATAU gunakan curtain transition -->
<!-- <div class="page-transition-curtain"></div> -->

<script>
// ==========================================
// MAIN TRANSITION SCRIPT
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    
    // Pilih semua link internal (kecuali yang memiliki class 'no-transition')
    const links = document.querySelectorAll('a:not(.no-transition):not([target="_blank"])');
    const overlay = document.querySelector('.page-transition-overlay');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Cek apakah link internal
            if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
                e.preventDefault();
                
                // Tambahkan class active untuk memulai animasi
                overlay.classList.add('active');
                document.body.classList.add('page-transitioning');
                
                // Tunggu animasi selesai, lalu redirect
                setTimeout(() => {
                    window.location.href = href;
                }, 400); // Sesuaikan dengan durasi transisi CSS
            }
        });
    });
    
    // Hapus overlay saat halaman selesai loading
    window.addEventListener('load', function() {
        overlay.classList.remove('active');
        document.body.classList.remove('page-transitioning');
    });
});

// ==========================================
// SCROLL REVEAL ANIMATION
// ==========================================

function reveal() {
    const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    
    reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < windowHeight - elementVisible) {
            element.classList.add('active');
        }
    });
}

window.addEventListener('scroll', reveal);
reveal(); // Panggil sekali saat load

// ==========================================
// SMOOTH SCROLL TO SECTION
// ==========================================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        if (href !== '#' && document.querySelector(href)) {
            e.preventDefault();
            
            const target = document.querySelector(href);
            const offsetTop = target.offsetTop - 80; // 80px untuk navbar
            
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// ==========================================
// PAGE LOAD ANIMATION
// ==========================================

window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});

// ==========================================
// PRELOADER (OPTIONAL)
// ==========================================

function initPreloader() {
    const preloader = document.createElement('div');
    preloader.className = 'page-transition-overlay active';
    preloader.innerHTML = '<div class="transition-spinner"></div>';
    document.body.appendChild(preloader);
    
    window.addEventListener('load', function() {
        setTimeout(() => {
            preloader.classList.remove('active');
            setTimeout(() => {
                preloader.remove();
            }, 400);
        }, 500);
    });
}

// Uncomment untuk mengaktifkan preloader
// initPreloader();

// ==========================================
// ALTERNATIVE: ZOOM TRANSITION
// ==========================================

function initZoomTransition() {
    const links = document.querySelectorAll('a:not(.no-transition):not([target="_blank"])');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                e.preventDefault();
                
                document.body.classList.add('zoom-out');
                
                setTimeout(() => {
                    window.location.href = href;
                }, 500);
            }
        });
    });
}

// Uncomment untuk menggunakan zoom transition
// initZoomTransition();

</script>

</body>
</html>