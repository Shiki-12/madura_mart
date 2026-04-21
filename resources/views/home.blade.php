<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Madura Mart — Toko online kebutuhan harian lengkap dengan harga merakyat. Warung Madura versi digital, belanja mudah dan cepat.">
    <meta name="keywords" content="madura mart, warung madura, toko online, kebutuhan harian, belanja online, harga murah">

    <title>Madura Mart — Warung Madura Digital</title>
    <link rel="icon" type="image/png" href="{{ asset('images/pfp_mizuki.jpeg') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ============================================
           DESIGN TOKENS
           ============================================ */
        :root {
            --c-primary: #E8590C;
            --c-primary-dark: #C2410C;
            --c-primary-light: #FED7AA;
            --c-accent: #0D9488;
            --c-accent-dark: #0F766E;
            --c-accent-light: #CCFBF1;
            --c-dark: #1C1917;
            --c-dark-soft: #292524;
            --c-warm-gray: #44403C;
            --c-text: #1C1917;
            --c-text-muted: #78716C;
            --c-bg-warm: #FFFBEB;
            --c-bg-section: #FFF7ED;
            --c-surface: #FFFFFF;
            --c-border: #E7E5E4;
            --shadow-sm: 0 1px 3px rgba(28, 25, 23, 0.06), 0 1px 2px rgba(28, 25, 23, 0.04);
            --shadow-md: 0 4px 16px rgba(28, 25, 23, 0.08), 0 2px 4px rgba(28, 25, 23, 0.04);
            --shadow-lg: 0 12px 40px rgba(28, 25, 23, 0.12), 0 4px 12px rgba(28, 25, 23, 0.06);
            --shadow-xl: 0 20px 60px rgba(28, 25, 23, 0.15), 0 8px 20px rgba(28, 25, 23, 0.08);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --font-main: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        /* ============================================
           GLOBAL RESET & BASE
           ============================================ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            font-family: var(--font-main);
            color: var(--c-text);
            background: var(--c-surface);
            line-height: 1.7;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ============================================
           NAVBAR
           ============================================ */
        .mm-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 16px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mm-navbar.scrolled {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            padding: 10px 0;
        }

        .mm-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: #fff;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: color 0.4s;
        }

        .mm-navbar.scrolled .navbar-brand {
            color: var(--c-primary);
        }

        .mm-navbar .navbar-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: border-color 0.4s;
        }

        .mm-navbar.scrolled .navbar-brand img {
            border-color: var(--c-primary-light);
        }

        .mm-nav-links {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            padding: 0;
        }

        .mm-nav-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            transition: all 0.3s;
        }

        .mm-navbar.scrolled .mm-nav-links a {
            color: var(--c-warm-gray);
        }

        .mm-nav-links a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
        }

        .mm-navbar.scrolled .mm-nav-links a:hover {
            color: var(--c-primary);
            background: var(--c-primary-light);
        }

        /* Fix for dropdown menu items visibility */
        .mm-nav-links .dropdown-menu a.dropdown-item {
            color: var(--c-dark) !important;
            font-weight: 500;
            border-radius: var(--radius-sm);
        }
        
        .mm-nav-links .dropdown-menu a.dropdown-item:hover {
            color: var(--c-primary) !important;
            background-color: var(--c-bg-section) !important;
        }

        .mm-profile-toggle {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 600;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            transition: all 0.3s;
        }

        .mm-navbar.scrolled .mm-profile-toggle {
            color: var(--c-dark) !important; /* Black text when scrolled */
            background: rgba(0, 0, 0, 0.05);
        }

        .mm-nav-cta {
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            color: #fff !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
            border-radius: var(--radius-md) !important;
            transition: all 0.3s !important;
        }

        .mm-navbar.scrolled .mm-nav-cta {
            background: var(--c-primary) !important;
            border-color: var(--c-primary) !important;
            color: #fff !important;
        }

        .mm-nav-cta:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            transform: translateY(-1px);
        }

        .mm-navbar.scrolled .mm-nav-cta:hover {
            background: var(--c-primary-dark) !important;
            box-shadow: var(--shadow-md);
        }

        /* Mobile nav toggle */
        .mm-nav-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .mm-nav-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: #fff;
            margin: 6px 0;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .mm-navbar.scrolled .mm-nav-toggle span {
            background: var(--c-dark);
        }

        /* ============================================
           HERO SECTION
           ============================================ */
        .mm-hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: var(--c-dark);
        }

        .mm-hero-bg {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .mm-hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.55;
            filter: brightness(0.7);
        }

        .mm-hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            background:
                linear-gradient(180deg,
                    rgba(28, 25, 23, 0.45) 0%,
                    rgba(28, 25, 23, 0.2) 40%,
                    rgba(28, 25, 23, 0.6) 100%),
                linear-gradient(90deg,
                    rgba(232, 89, 12, 0.15) 0%,
                    rgba(13, 148, 136, 0.1) 100%);
        }

        .mm-hero-content {
            position: relative;
            z-index: 3;
            padding: 140px 0 100px;
        }

        .mm-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 28px;
            animation: fadeSlideUp 0.8s ease-out 0.2s backwards;
        }

        .mm-hero-badge i {
            color: var(--c-primary) !important;
            font-size: 0.8rem !important;
        }

        .mm-hero h1 {
            font-size: clamp(2.5rem, 5.5vw, 4.2rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 24px;
            animation: fadeSlideUp 0.8s ease-out 0.4s backwards;
        }

        .mm-hero h1 .text-gradient {
            background: linear-gradient(135deg, #FB923C, #F97316, #EA580C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mm-hero-subtitle {
            font-size: clamp(1.05rem, 1.8vw, 1.25rem);
            color: rgba(255, 255, 255, 0.75);
            max-width: 540px;
            line-height: 1.8;
            margin-bottom: 40px;
            font-weight: 400;
            animation: fadeSlideUp 0.8s ease-out 0.6s backwards;
        }

        .mm-hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeSlideUp 0.8s ease-out 0.8s backwards;
        }

        .mm-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--c-primary), var(--c-primary-dark));
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 16px 36px;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(232, 89, 12, 0.35);
        }

        .mm-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(232, 89, 12, 0.45);
            color: #fff;
        }

        .mm-btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1rem;
            padding: 15px 32px;
            border-radius: var(--radius-md);
            border: 2px solid rgba(255, 255, 255, 0.25);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .mm-btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.4);
            color: #fff;
        }

        /* Hero floating stats */
        .mm-hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeSlideUp 0.8s ease-out 1s backwards;
        }

        .mm-hero-stat h3 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
        }

        .mm-hero-stat p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
        }

        /* Scroll indicator */
        .mm-scroll-indicator {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 5;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            animation: floatBounce 2s ease-in-out infinite;
        }

        .mm-scroll-indicator .scroll-line {
            width: 1px;
            height: 40px;
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.4), transparent);
        }

        /* ============================================
           ABOUT SECTION
           ============================================ */
        .mm-about {
            padding: 120px 0;
            background: var(--c-surface);
            position: relative;
        }

        .mm-section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            color: var(--c-primary);
            margin-bottom: 20px;
        }

        .mm-section-label::before {
            content: '';
            width: 32px;
            height: 2px;
            background: var(--c-primary);
            border-radius: 2px;
        }

        .mm-section-title {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 800;
            color: var(--c-dark);
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 24px;
        }

        .mm-about-text {
            font-size: 1.1rem;
            color: var(--c-text-muted);
            line-height: 1.9;
            max-width: 560px;
        }

        .mm-about-card {
            background: linear-gradient(135deg, var(--c-bg-section), var(--c-bg-warm));
            border-radius: var(--radius-xl);
            padding: 48px;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--c-border);
        }

        .mm-about-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(232, 89, 12, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .mm-values-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .mm-value-item {
            display: flex;
            gap: 16px;
        }

        .mm-value-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            background: var(--c-surface);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }

        .mm-value-icon i {
            font-size: 1.15rem !important;
            color: var(--c-primary) !important;
        }

        .mm-value-item h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--c-dark);
            margin-bottom: 6px;
        }

        .mm-value-item p {
            font-size: 0.88rem;
            color: var(--c-text-muted);
            line-height: 1.6;
        }

        /* ============================================
           FEATURES SECTION
           ============================================ */
        .mm-features {
            padding: 120px 0;
            background: var(--c-bg-section);
            position: relative;
        }

        .mm-features-header {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 72px;
        }

        .mm-features-header .mm-section-label {
            justify-content: center;
        }

        .mm-features-header .mm-section-title {
            margin-bottom: 16px;
        }

        .mm-features-header p {
            font-size: 1.05rem;
            color: var(--c-text-muted);
            line-height: 1.8;
        }

        .mm-feature-card {
            background: var(--c-surface);
            border-radius: var(--radius-lg);
            padding: 44px 36px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--c-border);
            position: relative;
            overflow: hidden;
        }

        .mm-feature-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--c-primary), var(--c-accent));
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mm-feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: transparent;
        }

        .mm-feature-card:hover::after {
            transform: scaleX(1);
        }

        .mm-feature-icon {
            width: 68px;
            height: 68px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            position: relative;
        }

        .mm-feature-icon i {
            font-size: 1.6rem !important;
            position: relative;
            z-index: 2;
        }

        .mm-feature-icon.icon-orange {
            background: linear-gradient(135deg, #FFF7ED, #FFEDD5);
        }
        .mm-feature-icon.icon-orange i { color: var(--c-primary) !important; }

        .mm-feature-icon.icon-teal {
            background: linear-gradient(135deg, #F0FDFA, #CCFBF1);
        }
        .mm-feature-icon.icon-teal i { color: var(--c-accent) !important; }

        .mm-feature-icon.icon-amber {
            background: linear-gradient(135deg, #FFFBEB, #FEF3C7);
        }
        .mm-feature-icon.icon-amber i { color: #D97706 !important; }

        .mm-feature-icon.icon-rose {
            background: linear-gradient(135deg, #FFF1F2, #FFE4E6);
        }
        .mm-feature-icon.icon-rose i { color: #E11D48 !important; }

        .mm-feature-icon.icon-indigo {
            background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
        }
        .mm-feature-icon.icon-indigo i { color: #4F46E5 !important; }

        .mm-feature-icon.icon-emerald {
            background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
        }
        .mm-feature-icon.icon-emerald i { color: #059669 !important; }

        .mm-feature-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--c-dark);
            margin-bottom: 12px;
        }

        .mm-feature-card p {
            font-size: 0.95rem;
            color: var(--c-text-muted);
            line-height: 1.7;
        }

        /* ============================================
           CTA SECTION
           ============================================ */
        .mm-cta {
            padding: 120px 0;
            background: var(--c-surface);
            position: relative;
        }

        .mm-cta-box {
            background: linear-gradient(135deg, var(--c-dark) 0%, var(--c-dark-soft) 60%, #3C2415 100%);
            border-radius: var(--radius-xl);
            padding: 80px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .mm-cta-box::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(232, 89, 12, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .mm-cta-box::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .mm-cta-box h2 {
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            color: #fff;
            letter-spacing: -1px;
            margin-bottom: 16px;
            position: relative;
            z-index: 2;
        }

        .mm-cta-box p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.6);
            max-width: 480px;
            margin: 0 auto 40px;
            position: relative;
            z-index: 2;
        }

        .mm-cta-box .mm-btn-primary {
            position: relative;
            z-index: 2;
        }

        /* ============================================
           FOOTER
           ============================================ */
        .mm-footer {
            background: var(--c-dark);
            padding: 72px 0 0;
        }

        .mm-footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .mm-footer-brand h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mm-footer-brand h3 img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .mm-footer-brand p {
            font-size: 0.92rem;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.8;
            max-width: 320px;
        }

        .mm-footer-col h4 {
            color: #fff;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 20px;
        }

        .mm-footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mm-footer-col ul li {
            margin-bottom: 12px;
        }

        .mm-footer-col ul li a {
            color: rgba(255, 255, 255, 0.45);
            text-decoration: none;
            font-size: 0.92rem;
            transition: all 0.3s;
            font-weight: 400;
        }

        .mm-footer-col ul li a:hover {
            color: var(--c-primary);
            padding-left: 4px;
        }

        .mm-footer-socials {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .mm-footer-socials a {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.4);
            transition: all 0.3s;
            text-decoration: none;
        }

        .mm-footer-socials a i {
            font-size: 0.95rem !important;
            color: inherit !important;
        }

        .mm-footer-socials a:hover {
            background: var(--c-primary);
            color: #fff;
            transform: translateY(-2px);
        }

        .mm-footer-bottom {
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mm-footer-bottom p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.3);
            margin: 0;
        }

        .mm-footer-bottom a {
            color: rgba(255, 255, 255, 0.45);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .mm-footer-bottom a:hover {
            color: var(--c-primary);
        }

        /* ============================================
           ANIMATIONS
           ============================================ */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-8px); }
        }

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }
        .reveal-delay-5 { transition-delay: 0.5s; }
        .reveal-delay-6 { transition-delay: 0.6s; }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 991.98px) {
            .mm-nav-links-wrap {
                display: none;
            }

            .mm-nav-toggle {
                display: block;
            }

            .mm-hero-stats {
                gap: 24px;
            }

            .mm-hero-stat h3 {
                font-size: 1.4rem;
            }

            .mm-about,
            .mm-features,
            .mm-cta {
                padding: 80px 0;
            }

            .mm-values-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .mm-footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 36px;
            }
        }

        @media (max-width: 767.98px) {
            .mm-hero-stats {
                flex-direction: column;
                gap: 20px;
            }

            .mm-hero-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .mm-cta-box {
                padding: 52px 28px;
            }

            .mm-footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .mm-footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .mm-about-card {
                padding: 32px 24px;
            }
        }

        /* Mobile nav overlay */
        .mm-mobile-nav {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(28, 25, 23, 0.95);
            backdrop-filter: blur(20px);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .mm-mobile-nav.open {
            display: flex;
        }

        .mm-mobile-nav a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 1.3rem;
            font-weight: 600;
            padding: 16px 40px;
            border-radius: var(--radius-md);
            transition: all 0.3s;
        }

        .mm-mobile-nav a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
        }

        .mm-mobile-close {
            position: absolute;
            top: 24px;
            right: 24px;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 2rem;
            cursor: pointer;
            padding: 8px;
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════════
         TOAST NOTIFICATIONS
         ═══════════════════════════════════════════════ -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    <!-- ═══════════════════════════════════════════════
         NAVBAR
         ═══════════════════════════════════════════════ -->
    <nav class="mm-navbar" id="mainNavbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a href="{{ url('/') }}" class="navbar-brand" id="navbar-brand">
                    <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart">
                    Madura Mart
                </a>

                <div class="mm-nav-links-wrap d-none d-lg-flex">
                    <ul class="mm-nav-links">
                        <li><a href="{{ url('/') }}">Welcome</a></li>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ url('/mizuki') }}">Mizuki</a></li>
                        <li><a href="{{ url('/lagu') }}">Lagu</a></li>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 mm-profile-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(auth()->user()->picture)
                                        <img src="{{ asset('storage/' . auth()->user()->picture) }}" alt="Avatar" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover; border: 2px solid rgba(255,255,255,0.5);">
                                    @else
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark" style="width: 28px; height: 28px; font-weight: bold; font-size: 0.8rem;">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 rounded-3" aria-labelledby="navbarDropdown">
                                    <li class="px-3 py-2 text-muted small d-flex align-items-center gap-2 border-bottom mb-1">
                                        <span class="badge" style="background: var(--c-primary);">{{ ucfirst(auth()->user()->role) }}</span>
                                    </li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user-circle me-2 text-muted"></i> Profil Saya</a></li>
                                    @if(auth()->user()->role !== 'customer')
                                        <li><a class="dropdown-item py-2" href="{{ route('dashboard.index') }}"><i class="fas fa-chart-line me-2 text-muted"></i> Dashboard Admin</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger py-2"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="mm-nav-cta">
                                    <i class="fas fa-sign-in-alt" style="font-size:0.85rem!important;color:#fff!important;"></i>
                                    Masuk
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <button class="mm-nav-toggle d-lg-none" id="navToggle" aria-label="Toggle navigation">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Nav Overlay -->
    <div class="mm-mobile-nav" id="mobileNav">
        <button class="mm-mobile-close" id="mobileNavClose" aria-label="Close navigation">&times;</button>
        <a href="{{ url('/') }}" onclick="closeMobileNav()">Welcome</a>
        <a href="{{ route('home') }}" onclick="closeMobileNav()">Home</a>
        <a href="{{ url('/mizuki') }}" onclick="closeMobileNav()">Mizuki</a>
        <a href="{{ url('/lagu') }}" onclick="closeMobileNav()">Lagu</a>
        <a href="#beranda" onclick="closeMobileNav()">Beranda</a>
        <a href="#tentang" onclick="closeMobileNav()">Tentang Kami</a>
        <a href="#keunggulan" onclick="closeMobileNav()">Keunggulan</a>
        @auth
            <div class="d-flex align-items-center gap-3 mb-3 border-bottom border-secondary pb-3 w-100 justify-content-center">
                @if(auth()->user()->picture)
                    <img src="{{ asset('storage/' . auth()->user()->picture) }}" alt="Avatar" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-dark" style="width: 48px; height: 48px; font-weight: bold; font-size: 1.2rem;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="text-start">
                    <div style="font-weight: 700; color: #fff; font-size: 1.1rem;">{{ auth()->user()->name }}</div>
                    <div style="font-size: 0.8rem; color: var(--c-primary-light);">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <a href="{{ route('profile') }}">Profil Saya</a>
            @if(auth()->user()->role !== 'customer')
                <a href="{{ route('dashboard.index') }}">Dashboard Admin</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="w-100 text-center mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-75 rounded-pill"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
            </form>
        @else
            <a href="{{ route('login') }}" style="color:var(--c-primary);">Masuk</a>
            <a href="{{ route('register') }}">Daftar</a>
        @endauth
    </div>

    <!-- ═══════════════════════════════════════════════
         HERO SECTION
         ═══════════════════════════════════════════════ -->
    <section class="mm-hero" id="beranda">
        <div class="mm-hero-bg">
            <img src="{{ asset('images/hero-warung-madura.png') }}" alt="Warung Madura">
        </div>
        <div class="mm-hero-overlay"></div>

        <div class="container mm-hero-content">
            <div class="row">
                <div class="col-lg-7">
                    <div class="mm-hero-badge">
                        <i class="fas fa-store"></i>
                        Warung Madura Versi Digital
                    </div>

                    <h1>
                        Semua Kebutuhan<br>
                        Harian, <span class="text-gradient">Satu Klik</span> Saja.
                    </h1>

                    <p class="mm-hero-subtitle">
                        Madura Mart menghadirkan kelengkapan dan kehangatan Warung Madura ke layar Anda.
                        Belanja kebutuhan harian dengan harga merakyat, tanpa perlu keluar rumah.
                    </p>

                    <div class="mm-hero-actions">
                        @auth
                            <a href="{{ route('home') }}" class="mm-btn-primary" id="hero-cta-primary">
                                Mulai Belanja
                                <i class="fas fa-arrow-right" style="font-size:0.9rem!important;color:#fff!important;"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="mm-btn-primary" id="hero-cta-primary">
                                Daftar Gratis
                                <i class="fas fa-arrow-right" style="font-size:0.9rem!important;color:#fff!important;"></i>
                            </a>
                        @endauth
                        <a href="#tentang" class="mm-btn-outline" id="hero-cta-secondary">
                            <i class="fas fa-play-circle" style="font-size:1rem!important;color:rgba(255,255,255,0.9)!important;"></i>
                            Kenali Kami
                        </a>
                    </div>

                    <div class="mm-hero-stats">
                        <div class="mm-hero-stat">
                            <h3>500+</h3>
                            <p>Produk Tersedia</p>
                        </div>
                        <div class="mm-hero-stat">
                            <h3>24/7</h3>
                            <p>Layanan Nonstop</p>
                        </div>
                        <div class="mm-hero-stat">
                            <h3>50rb+</h3>
                            <p>Pelanggan Puas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mm-scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         ABOUT SECTION
         ═══════════════════════════════════════════════ -->
    <section class="mm-about" id="tentang">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <div class="reveal">
                        <span class="mm-section-label">Tentang Kami</span>
                        <h2 class="mm-section-title">
                            Semangat Warung Madura,<br>
                            Sentuhan Digital.
                        </h2>
                        <p class="mm-about-text">
                            Warung Madura telah lama menjadi bagian dari kehidupan masyarakat Indonesia—selalu ada,
                            selalu buka, dan selalu menyediakan apa yang Anda butuhkan. Madura Mart lahir untuk
                            meneruskan tradisi legendaris itu ke dunia digital.
                        </p>
                        <p class="mm-about-text" style="margin-top:16px;">
                            Kami percaya belanja kebutuhan harian seharusnya <strong>mudah, terjangkau, dan menyenangkan</strong>
                            — persis seperti mampir ke warung langganan Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="mm-about-card reveal reveal-delay-2">
                        <div class="mm-values-grid">
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <h4>Ramah & Terpercaya</h4>
                                    <p>Pelayanan hangat layaknya warung sendiri, didukung sistem yang transparan.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4>Selalu Sedia</h4>
                                    <p>Buka kapan saja, pesan kapan saja. Tidak ada kata kehabisan stok.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <div>
                                    <h4>Harga Jujur</h4>
                                    <p>Tanpa markup berlebihan. Harga yang wajar untuk semua kalangan.</p>
                                </div>
                            </div>
                            <div class="mm-value-item">
                                <div class="mm-value-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div>
                                    <h4>Produk Berkualitas</h4>
                                    <p>Dipilih langsung dari distributor terpercaya untuk menjaga mutu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FEATURES / KEUNGGULAN SECTION
         ═══════════════════════════════════════════════ -->
    <section class="mm-features" id="keunggulan">
        <div class="container">
            <div class="mm-features-header reveal">
                <span class="mm-section-label">Keunggulan Kami</span>
                <h2 class="mm-section-title">Kenapa Belanja di Madura Mart?</h2>
                <p>
                    Kami menggabungkan kenyamanan belanja online dengan kelengkapan dan keterjangkauan
                    khas Warung Madura yang sudah Anda kenal.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-1">
                        <div class="mm-feature-icon icon-orange">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        <h3>Kebutuhan Harian Lengkap</h3>
                        <p>Dari sembako, jajanan, minuman dingin, hingga perlengkapan rumah tangga — semua tersedia dalam satu tempat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-2">
                        <div class="mm-feature-icon icon-teal">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3>Harga Merakyat</h3>
                        <p>Harga bersaing tanpa biaya tersembunyi. Kami berkomitmen memberikan harga termurah untuk produk berkualitas.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-3">
                        <div class="mm-feature-icon icon-amber">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h3>Mudah & Cepat</h3>
                        <p>Proses pemesanan yang intuitif dan pengiriman cepat langsung ke depan pintu rumah Anda.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-4">
                        <div class="mm-feature-icon icon-rose">
                            <i class="fas fa-truck-fast"></i>
                        </div>
                        <h3>Pengiriman Andal</h3>
                        <p>Tim kurir kami siap mengantarkan pesanan dengan aman dan tepat waktu, setiap hari tanpa libur.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-5">
                        <div class="mm-feature-icon icon-indigo">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                        <h3>Belanja Aman</h3>
                        <p>Transaksi terjamin dengan sistem keamanan modern. Data pribadi Anda selalu terlindungi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="mm-feature-card reveal reveal-delay-6">
                        <div class="mm-feature-icon icon-emerald">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Layanan Pelanggan</h3>
                        <p>Tim kami selalu siap membantu pertanyaan dan keluhan Anda dengan respons cepat dan ramah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         CTA SECTION
         ═══════════════════════════════════════════════ -->
    <section class="mm-cta">
        <div class="container">
            <div class="mm-cta-box reveal">
                <h2>Siap Belanja Lebih Mudah?</h2>
                <p>Bergabung dengan ribuan pelanggan Madura Mart dan nikmati belanja kebutuhan harian tanpa repot.</p>
                @auth
                    <a href="{{ route('home') }}" class="mm-btn-primary" id="cta-bottom">
                        Belanja Sekarang
                        <i class="fas fa-arrow-right" style="font-size:0.9rem!important;color:#fff!important;"></i>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="mm-btn-primary" id="cta-bottom">
                        Buat Akun Gratis
                        <i class="fas fa-arrow-right" style="font-size:0.9rem!important;color:#fff!important;"></i>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════════════ -->
    <footer class="mm-footer">
        <div class="container">
            <div class="mm-footer-grid">
                <div class="mm-footer-brand">
                    <h3>
                        <img src="{{ asset('images/pfp_mizuki.jpeg') }}" alt="Madura Mart">
                        Madura Mart
                    </h3>
                    <p>
                        Warung Madura versi digital — menyediakan kebutuhan harian lengkap dengan harga merakyat dan pelayanan terpercaya.
                    </p>
                    <div class="mm-footer-socials">
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <div class="mm-footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#keunggulan">Keunggulan</a></li>
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                    </ul>
                </div>

                <div class="mm-footer-col">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Belanja Online</a></li>
                        <li><a href="#">Pengiriman</a></li>
                        <li><a href="{{ route('register.courier') }}">Gabung Kurir</a></li>
                        <li><a href="#">Promo</a></li>
                    </ul>
                </div>

                <div class="mm-footer-col">
                    <h4>Kontak</h4>
                    <ul>
                        <li><a href="mailto:halo@maduramart.id">halo@maduramart.id</a></li>
                        <li><a href="tel:+6281234567890">+62 812-3456-7890</a></li>
                        <li><a href="#">Pusat Bantuan</a></li>
                    </ul>
                </div>
            </div>

            <div class="mm-footer-bottom">
                <p>&copy; {{ date('Y') }} Madura Mart. Hak cipta dilindungi.</p>
                <div class="d-flex gap-3">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* ============================================
           NAVBAR SCROLL BEHAVIOR
           ============================================ */
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        });

        /* ============================================
           MOBILE NAV TOGGLE
           ============================================ */
        const navToggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavClose = document.getElementById('mobileNavClose');

        navToggle.addEventListener('click', () => mobileNav.classList.add('open'));
        mobileNavClose.addEventListener('click', () => mobileNav.classList.remove('open'));

        function closeMobileNav() {
            mobileNav.classList.remove('open');
        }

        /* ============================================
           SCROLL REVEAL ANIMATION
           ============================================ */
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));

        /* ============================================
           SMOOTH SCROLL FOR ANCHOR LINKS
           ============================================ */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({ top: offsetTop, behavior: 'smooth' });
                }
            });
        });
    </script>

</body>

</html>
