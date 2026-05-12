<?php
// Start session if needed for the monitoring system (optional, but good practice)
session_start();

// Dynamic page variables
 $currentPage = basename($_SERVER['PHP_SELF']);
 $pageTitle = "About Us — Barangay Population Monitoring System";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg: #0a0f0d;
            --bg-secondary: #111a16;
            --fg: #e8efe9;
            --fg-muted: #8a9e90;
            --accent: #d4a843;
            --accent-glow: rgba(212, 168, 67, 0.25);
            --teal: #1a7a5c;
            --teal-deep: #0e4d38;
            --teal-light: #2aad82;
            --card: rgba(17, 30, 24, 0.85);
            --card-border: rgba(42, 173, 130, 0.15);
            --border: rgba(138, 158, 144, 0.12);
            --radius: 16px;
            --radius-sm: 10px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            scrollbar-width: thin;
            scrollbar-color: var(--teal) var(--bg);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--fg);
            overflow-x: hidden;
            line-height: 1.7;
        }

        /* ===== NAVBAR ===== */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 1rem 2rem;
            transition: all 0.4s ease;
            backdrop-filter: blur(0px);
        }

        nav.scrolled {
            background: rgba(10, 15, 13, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0.7rem 2rem;
        }

        .nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--fg);
        }

        .nav-brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--teal), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--bg);
            font-weight: 700;
        }

        .nav-brand-text {
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.02em;
        }

        .nav-brand-text span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--fg-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover { color: var(--fg); }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a.active { color: var(--accent); }
        .nav-links a.active::after { width: 100%; }

        .nav-cta {
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            color: #fff !important;
            padding: 0.55rem 1.4rem;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s !important;
        }

        .nav-cta::after { display: none !important; }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 122, 92, 0.4);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px;
        }

        .hamburger span {
            width: 26px;
            height: 2.5px;
            background: var(--fg);
            border-radius: 4px;
            transition: all 0.3s;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #hero-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 80%, transparent 0%, var(--bg) 72%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 860px;
            padding: 2rem;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(212, 168, 67, 0.1);
            border: 1px solid rgba(212, 168, 67, 0.25);
            color: var(--accent);
            padding: 0.45rem 1.2rem;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            animation: fadeUp 0.8s ease forwards;
            opacity: 0;
        }

        .hero-badge i { font-size: 0.75rem; }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: clamp(2.8rem, 6vw, 5.2rem);
            line-height: 1.08;
            letter-spacing: -0.025em;
            margin-bottom: 1.5rem;
            animation: fadeUp 0.8s 0.15s ease forwards;
            opacity: 0;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, var(--accent), #e8c76a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-title .teal-text {
            background: linear-gradient(135deg, var(--teal-light), #3dd9a0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.15rem;
            color: var(--fg-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.75;
            animation: fadeUp 0.8s 0.3s ease forwards;
            opacity: 0;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            animation: fadeUp 0.8s 0.45s ease forwards;
            opacity: 0;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            color: #fff;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(26, 122, 92, 0.4);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: transparent;
            color: var(--fg);
            padding: 0.85rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border: 1.5px solid var(--border);
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            border-color: var(--teal-light);
            color: var(--teal-light);
            background: rgba(42, 173, 130, 0.06);
        }

        .hero-scroll {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: var(--fg-muted);
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            animation: float 2.5s ease-in-out infinite;
        }

        .hero-scroll i { font-size: 1rem; }

        /* ===== SECTIONS COMMON ===== */
        section {
            padding: 6rem 2rem;
            position: relative;
        }

        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-label::before {
            content: '';
            width: 28px;
            height: 2px;
            background: var(--accent);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--fg-muted);
            font-size: 1.05rem;
            max-width: 580px;
            line-height: 1.75;
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== ABOUT SECTION ===== */
        .about-section {
            background: var(--bg-secondary);
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-top: 3rem;
        }

        .about-visual {
            position: relative;
        }

        .about-image-frame {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            aspect-ratio: 4/3;
            background: linear-gradient(135deg, var(--teal-deep), var(--bg));
        }

        .about-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.85;
        }

        .about-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(10, 15, 13, 0.6));
        }

        .about-float-card {
            position: absolute;
            bottom: -1.5rem;
            right: -1.5rem;
            background: var(--card);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(20px);
            border-radius: var(--radius-sm);
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .about-float-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
        }

        .about-float-text h4 {
            font-size: 1.4rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
        }

        .about-float-text p {
            font-size: 0.78rem;
            color: var(--fg-muted);
        }

        .about-text h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .about-text p {
            color: var(--fg-muted);
            margin-bottom: 1.2rem;
            line-height: 1.8;
        }

        .about-text p strong {
            color: var(--fg);
        }

        .about-checklist {
            list-style: none;
            margin-top: 1.5rem;
        }

        .about-checklist li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.9rem;
            color: var(--fg-muted);
            font-size: 0.95rem;
        }

        .about-checklist li i {
            color: var(--teal-light);
            margin-top: 0.3rem;
            font-size: 0.85rem;
        }

        /* ===== FEATURES SECTION ===== */
        .features-section {
            background: var(--bg-secondary);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: var(--card);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 2rem;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 0;
            background: linear-gradient(180deg, transparent, rgba(26, 122, 92, 0.06));
            transition: height 0.5s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: rgba(42, 173, 130, 0.3);
        }

        .feature-card:hover::after { height: 100%; }

        .feature-card > * { position: relative; z-index: 1; }

        .feature-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--teal-deep), var(--teal));
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            color: #fff;
            margin-bottom: 1.3rem;
        }

        .feature-card:nth-child(2) .feature-icon {
            background: linear-gradient(135deg, #6b4c1e, var(--accent));
        }

        .feature-card h3 {
            font-size: 1.12rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }

        .feature-card p {
            color: var(--fg-muted);
            font-size: 0.9rem;
            line-height: 1.7;
        }

        /* ===== FOOTER ===== */
        footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
            padding: 3rem 2rem 1.5rem;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .footer-brand p {
            color: var(--fg-muted);
            font-size: 0.9rem;
            margin-top: 0.8rem;
            line-height: 1.7;
            max-width: 300px;
        }

        .footer-col h5 {
            font-size: 0.82rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--fg);
            margin-bottom: 1rem;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 0.5rem;
        }

        .footer-col ul li a {
            color: var(--fg-muted);
            text-decoration: none;
            font-size: 0.88rem;
            transition: color 0.3s;
        }

        .footer-col ul li a:hover { color: var(--teal-light); }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--fg-muted);
            font-size: 0.82rem;
        }

        .footer-socials {
            display: flex;
            gap: 0.5rem;
        }

        .footer-socials a {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(42, 173, 130, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--fg-muted);
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-socials a:hover {
            background: var(--teal);
            color: #fff;
        }

        /* ===== BACK TO TOP ===== */
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 46px;
            height: 46px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            cursor: pointer;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(26, 122, 92, 0.4);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background: var(--teal-light);
            transform: translateY(-3px);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-8px); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hamburger { display: flex; }

            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: rgba(10, 15, 13, 0.97);
                backdrop-filter: blur(20px);
                padding: 1.5rem 2rem;
                border-bottom: 1px solid var(--border);
                gap: 1rem;
            }

            .about-grid { grid-template-columns: 1fr; gap: 2rem; }
            .features-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }

            .hero-actions { flex-direction: column; }
        }

        /* ===== REDUCED MOTION ===== */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .reveal { opacity: 1; transform: none; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" role="navigation" aria-label="Main navigation">
        <div class="nav-inner">
            <a href="index.php" class="nav-brand" aria-label="BPMS Home">
                <div class="nav-brand-icon"><i class="fas fa-city"></i></div>
                <div class="nav-brand-text">Barangay<span>PMS</span></div>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="#about" class="<?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>">About</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="index.php" class="nav-cta">Get Started</a></li>
            </ul>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero" id="hero">
        <canvas id="hero-canvas"></canvas>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="hero-badge"><i class="fas fa-shield-halved"></i> Official Government System</div>
            <h1 class="hero-title">
                Barangay<br>
                <span class="teal-text">Population</span> Monitoring<br>
                <span class="highlight">System</span>
            </h1>
            <p class="hero-desc">
                Empowering local governance through real-time demographic data, streamlined resident management, and data-driven decision-making for every barangay.
            </p>
            <div class="hero-actions">
                <a href="#about" class="btn-primary"><i class="fas fa-arrow-down"></i> Learn More</a>
                <a href="#features" class="btn-outline"><i class="fas fa-compass"></i> Explore Features</a>
            </div>
        </div>
        <div class="hero-scroll">
            <span>Scroll</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="about-section" id="about">
        <div class="section-inner">
            <div class="reveal">
                <span class="section-label">About the System</span>
                <h2 class="section-title">Serving Communities<br>Through Data</h2>
            </div>
            <div class="about-grid">
                <div class="about-visual reveal">
                    <div class="about-image-frame">
                        <img src="https://picsum.photos/seed/barangay-office/600/450.jpg" alt="Barangay Hall" loading="lazy">
                        <div class="about-image-overlay"></div>
                    </div>
                    <div class="about-float-card">
                        <div class="about-float-icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>
                <div class="about-text reveal">
                    <h3>What is the Barangay Population Monitoring System?</h3>
                    <p>
                        The <strong>Barangay Population Monitoring System (BPMS)</strong> is a centralized digital platform designed to collect, organize, and analyze population data at the barangay level. 
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section" id="features">
        <div class="section-inner">
            <div class="reveal" style="text-align:center;">
                <span class="section-label" style="justify-content:center;">Core Features</span>
                <h2 class="section-title">Built for Modern Governance</h2>
                <p class="section-subtitle" style="margin:0 auto;">Comprehensive tools designed to simplify population management and enhance community service delivery.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card reveal">
                    <div class="feature-icon"><i class="fas fa-database"></i></div>
                    <h3>Resident Database</h3>
                    <p>Centralized repository of resident records with contact details, and login history.</p>
                </div>
                <div class="feature-card reveal">
                    <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Demographic Analytics</h3>
                    <p>Interactive dashboards displaying resident statistics, and population density.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="nav-brand" aria-label="BPMS Home">
                        <div class="nav-brand-icon"><i class="fas fa-city"></i></div>
                        <div class="nav-brand-text">Barangay<span>PMS</span></div>
                    </a>
                    <p>Empowering local governance through data-driven population monitoring and community management solutions.</p>
                </div>
                <div class="footer-col">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#features">Features</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Resources</h5>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">User Guide</a></li>
                        <li><a href="#">Data Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h5>Contact</h5>
                    <ul>
                        <li><a href="#"><i class="fas fa-map-marker-alt" style="width:16px;"></i> Barangay Hall</a></li>
                        <li><a href="mailto:chooksterchookie@gmail.com"><i class="fas fa-envelope" style="width:16px;"></i> chooksterchookie@gmail.com</a></li>
                        <li><a href="tel:+63288881234"><i class="fas fa-phone" style="width:16px;"></i> (09) 9999-0000</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?php echo date("Y"); ?> Barangay Population Monitoring System. All rights reserved.</span>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        /* ===== HERO CANVAS — Network Node Animation ===== */
        (function() {
            const canvas = document.getElementById('hero-canvas');
            const ctx = canvas.getContext('2d');
            let width, height, nodes, mouse;
            const NODE_COUNT = 80;
            const CONNECTION_DIST = 160;

            mouse = { x: -9999, y: -9999 };

            function resize() {
                width = canvas.width = canvas.offsetWidth;
                height = canvas.height = canvas.offsetHeight;
            }

            function createNodes() {
                nodes = [];
                for (let i = 0; i < NODE_COUNT; i++) {
                    nodes.push({
                        x: Math.random() * width,
                        y: Math.random() * height,
                        vx: (Math.random() - 0.5) * 0.6,
                        vy: (Math.random() - 0.5) * 0.6,
                        radius: Math.random() * 2.5 + 1,
                        color: Math.random() > 0.7 ? 'rgba(212,168,67,' : 'rgba(42,173,130,'
                    });
                }
            }

            function draw() {
                ctx.clearRect(0, 0, width, height);

                for (let i = 0; i < nodes.length; i++) {
                    for (let j = i + 1; j < nodes.length; j++) {
                        const dx = nodes[i].x - nodes[j].x;
                        const dy = nodes[i].y - nodes[j].y;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < CONNECTION_DIST) {
                            const alpha = (1 - dist / CONNECTION_DIST) * 0.15;
                            ctx.beginPath();
                            ctx.strokeStyle = 'rgba(42,173,130,' + alpha + ')';
                            ctx.lineWidth = 0.8;
                            ctx.moveTo(nodes[i].x, nodes[i].y);
                            ctx.lineTo(nodes[j].x, nodes[j].y);
                            ctx.stroke();
                        }
                    }
                }

                for (const node of nodes) {
                    const mdx = node.x - mouse.x;
                    const mdy = node.y - mouse.y;
                    const mdist = Math.sqrt(mdx * mdx + mdy * mdy);
                    if (mdist < 200) {
                        const force = (200 - mdist) / 200 * 0.015;
                        node.vx += mdx * force;
                        node.vy += mdy * force;
                    }

                    node.x += node.vx;
                    node.y += node.vy;
                    node.vx *= 0.995;
                    node.vy *= 0.995;

                    if (node.x < -20) node.x = width + 20;
                    if (node.x > width + 20) node.x = -20;
                    if (node.y < -20) node.y = height + 20;
                    if (node.y > height + 20) node.y = -20;

                    ctx.beginPath();
                    ctx.arc(node.x, node.y, Math.max(0.5, node.radius), 0, Math.PI * 2);
                    ctx.fillStyle = node.color + '0.7)';
                    ctx.fill();
                }

                requestAnimationFrame(draw);
            }

            window.addEventListener('resize', () => { resize(); });
            canvas.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                mouse.x = e.clientX - rect.left;
                mouse.y = e.clientY - rect.top;
            });
            canvas.addEventListener('mouseleave', () => {
                mouse.x = -9999;
                mouse.y = -9999;
            });

            resize();
            createNodes();
            draw();
        })();

        /* ===== NAVBAR SCROLL ===== */
        const navbar = document.getElementById('navbar');
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY;
            if (scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            if (scrollY > 600) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        /* ===== HAMBURGER ===== */
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('open');
            const spans = hamburger.querySelectorAll('span');
            if (navLinks.classList.contains('open')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px,5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px,-5px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
                const spans = hamburger.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });

        /* ===== SCROLL REVEAL ===== */
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        revealElements.forEach(el => revealObserver.observe(el));

        /* ===== SMOOTH SCROLL FOR ANCHOR LINKS ===== */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>