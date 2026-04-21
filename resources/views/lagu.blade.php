<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lagu — A curated melancholic music experience by Madura Mart.">
    <title>Lagu — 音楽</title>

    <link rel="icon" type="image/png" href="images/pfp_mizuki.jpeg">
    <link rel="apple-touch-icon" href="images/pfp_mizuki.jpeg">

    {{-- Google Fonts: Elegant serif + clean sans-serif --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           CSS RESET & BASE
           ============================================================ */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #0a0a0a;
            color: #e0e0e0;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* ============================================================
           ANIMATED BACKGROUND — Subtle grain + floating particles
           ============================================================ */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(40, 40, 40, 0.4) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(50, 50, 50, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 80%, rgba(30, 30, 30, 0.5) 0%, transparent 60%);
            z-index: 0;
            pointer-events: none;
        }

        /* Film-grain overlay */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            z-index: 0;
            pointer-events: none;
        }

        /* ============================================================
           FLOATING PARTICLES
           ============================================================ */
        .particles-container {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: particleDrift linear infinite;
        }

        @keyframes particleDrift {
            0% { transform: translateY(100vh) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) translateX(40px); opacity: 0; }
        }

        /* ============================================================
           MAIN LAYOUT
           ============================================================ */
        .page-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding: 2rem 1.5rem 6rem;
        }

        /* ============================================================
           HEADER / NAVIGATION
           ============================================================ */
        .page-header {
            width: 100%;
            max-width: 900px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 3rem;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 300;
            letter-spacing: 0.15em;
            color: #ffffff;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .page-header .logo:hover { opacity: 0.7; }
        .page-header .logo span { font-weight: 600; }

        .page-header nav {
            display: flex;
            gap: 1.8rem;
        }

        .page-header nav a {
            color: rgba(255, 255, 255, 0.45);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 400;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: color 0.3s ease;
            position: relative;
        }

        .page-header nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 1px;
            background: #ffffff;
            transition: width 0.3s ease;
        }

        .page-header nav a:hover { color: #ffffff; }
        .page-header nav a:hover::after { width: 100%; }

        /* ============================================================
           HERO TITLE SECTION
           ============================================================ */
        .hero-title {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-title h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 300;
            letter-spacing: 0.08em;
            color: #ffffff;
            line-height: 1.15;
            margin-bottom: 0.5rem;
        }

        .hero-title h1 em {
            font-style: italic;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.5);
        }

        .hero-title .subtitle {
            font-size: 0.85rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.25em;
            text-transform: uppercase;
            margin-top: 0.8rem;
        }

        .hero-title .divider {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            margin: 1.5rem auto 0;
        }

        /* ============================================================
           YOUTUBE SEARCH BAR
           ============================================================ */
        .search-section {
            width: 100%;
            max-width: 780px;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.35s both;
        }

        .search-bar {
            display: flex;
            gap: 0;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(18, 18, 18, 0.6);
            backdrop-filter: blur(15px);
            transition: border-color 0.3s ease;
        }

        .search-bar:focus-within {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .search-bar input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 300;
            padding: 1rem 1.4rem;
            letter-spacing: 0.02em;
        }

        .search-bar input::placeholder {
            color: rgba(255, 255, 255, 0.2);
            font-weight: 300;
        }

        .search-bar button {
            background: rgba(255, 255, 255, 0.06);
            border: none;
            border-left: 1px solid rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.5);
            padding: 1rem 1.6rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 400;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-bar button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .search-bar button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Search results dropdown */
        .search-results {
            width: 100%;
            max-width: 780px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            opacity: 0;
        }

        .search-results.open {
            max-height: 600px;
            overflow-y: auto;
            opacity: 1;
        }

        .search-results-inner {
            background: rgba(14, 14, 14, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-top: none;
            border-radius: 0 0 12px 12px;
            backdrop-filter: blur(20px);
            padding: 0.5rem;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.25s ease;
        }

        .search-result-item:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .search-result-item .thumb {
            width: 80px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            background: #1a1a1a;
        }

        .search-result-item .result-info {
            flex: 1;
            min-width: 0;
        }

        .search-result-item .result-title {
            font-size: 0.85rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 2px;
        }

        .search-result-item .result-channel {
            font-size: 0.72rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.3);
        }

        .search-status {
            text-align: center;
            padding: 1.5rem 1rem;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.25);
            font-weight: 300;
        }

        /* ============================================================
           PLAYER CARD
           ============================================================ */
        .now-playing-section {
            width: 100%;
            max-width: 780px;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .player-card {
            background: rgba(18, 18, 18, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow:
                0 4px 30px rgba(0, 0, 0, 0.5),
                0 0 80px rgba(255, 255, 255, 0.01);
            transition: border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .player-card:hover {
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow:
                0 8px 50px rgba(0, 0, 0, 0.6),
                0 0 100px rgba(255, 255, 255, 0.02);
        }

        /* YouTube Player container */
        .video-wrapper {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 */
            background: #000;
        }

        .video-wrapper #yt-player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Track info bar */
        .track-info {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .track-details { flex: 1; min-width: 0; }

        .track-details .track-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.35rem;
            font-weight: 400;
            color: #ffffff;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .track-details .track-artist {
            font-size: 0.8rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 0.05em;
        }

        .now-playing-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.25);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            flex-shrink: 0;
            margin-left: 1rem;
        }

        /* Animated equalizer bars */
        .eq-bars {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 14px;
        }

        .eq-bars span {
            display: block;
            width: 3px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 1px;
            animation: eqBounce 0.8s ease-in-out infinite alternate;
        }

        .eq-bars span:nth-child(1) { height: 4px; animation-delay: 0s; }
        .eq-bars span:nth-child(2) { height: 10px; animation-delay: 0.15s; }
        .eq-bars span:nth-child(3) { height: 6px; animation-delay: 0.3s; }
        .eq-bars span:nth-child(4) { height: 12px; animation-delay: 0.1s; }

        @keyframes eqBounce {
            0%   { height: 3px; }
            100% { height: 14px; }
        }

        /* ============================================================
           SHUFFLE BUTTON
           ============================================================ */
        .shuffle-section {
            margin-top: 2rem;
            text-align: center;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .shuffle-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 0.9rem 2.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 400;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #ffffff;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .shuffle-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .shuffle-btn:hover {
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .shuffle-btn:hover::before { opacity: 1; }
        .shuffle-btn:active { transform: translateY(0); }

        .shuffle-btn .shuffle-icon {
            font-size: 1.1rem;
            transition: transform 0.5s ease;
        }

        .shuffle-btn:hover .shuffle-icon { transform: rotate(180deg); }

        .shuffle-btn.spinning .shuffle-icon {
            animation: spin360 0.6s ease-out;
        }

        @keyframes spin360 {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ============================================================
           PLAYLIST SECTION
           ============================================================ */
        .playlist-section {
            width: 100%;
            max-width: 780px;
            margin-top: 3.5rem;
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        .playlist-header {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.3);
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            outline: none;
            transition: border-color 0.3s;
            text-transform: none;
            letter-spacing: normal;
            width: 180px;
        }

        .filter-input:focus {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .playlist-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 1rem;
            position: relative;
        }

        .playlist-item::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(255,255,255,0.03), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .playlist-item:hover::before { opacity: 1; }
        .playlist-item:hover { background: rgba(255, 255, 255, 0.03); }
        .playlist-item.active { background: rgba(255, 255, 255, 0.05); }

        .playlist-item .track-num {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.2);
            width: 20px;
            text-align: center;
            font-weight: 400;
            flex-shrink: 0;
        }

        .playlist-item.active .track-num { color: #ffffff; }

        .playlist-item .item-info { flex: 1; min-width: 0; }

        .playlist-item .item-title {
            font-size: 0.9rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.75);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color 0.3s ease;
        }

        .playlist-item.active .item-title { color: #ffffff; }

        .playlist-item .item-artist {
            font-size: 0.75rem;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.25);
            margin-top: 2px;
        }

        .playlist-item .item-duration {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        /* ============================================================
           ANIME CHARACTER OVERLAY
           ============================================================ */
        .anime-character {
            position: fixed;
            bottom: 0;
            right: -20px;
            width: clamp(180px, 22vw, 320px);
            height: auto;
            z-index: 2;
            opacity: 0.12;
            filter: grayscale(100%) brightness(1.2) contrast(0.9);
            pointer-events: none;
            transition: opacity 1s ease;
            animation: subtleFloat 8s ease-in-out infinite;
            mix-blend-mode: luminosity;
        }

        @keyframes subtleFloat {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-8px); }
        }

        /* ============================================================
           FOOTER
           ============================================================ */
        .page-footer {
            width: 100%;
            max-width: 780px;
            margin-top: 5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            text-align: center;
            animation: fadeInUp 1s ease-out 1s both;
        }

        .page-footer p {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.15);
            letter-spacing: 0.1em;
        }

        .page-footer .footer-quote {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.2);
            margin-bottom: 1rem;
        }

        /* ============================================================
           RESPONSIVE DESIGN
           ============================================================ */
        @media (max-width: 768px) {
            .page-wrapper { padding: 1.5rem 1rem 5rem; }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .page-header nav { gap: 1rem; }

            .track-info {
                padding: 1.2rem 1.2rem;
                flex-direction: column;
                gap: 0.8rem;
                align-items: flex-start;
            }

            .now-playing-badge { margin-left: 0; }

            .anime-character {
                width: 140px;
                opacity: 0.08;
                right: -10px;
            }

            .playlist-item { padding: 0.8rem; }

            .search-bar input { font-size: 0.82rem; padding: 0.85rem 1rem; }
            .search-bar button { padding: 0.85rem 1rem; font-size: 0.7rem; }

            .search-result-item .thumb { width: 64px; height: 36px; }
        }

        @media (max-width: 480px) {
            .hero-title h1 { font-size: 2rem; }
            .shuffle-btn { padding: 0.75rem 2rem; font-size: 0.72rem; }
            .anime-character { display: none; }
            .filter-input { width: 130px; font-size: 0.72rem; }
        }

        /* ============================================================
           SCROLLBAR
           ============================================================ */
        .search-results::-webkit-scrollbar { width: 4px; }
        .search-results::-webkit-scrollbar-track { background: transparent; }
        .search-results::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 2px;
        }
    </style>
</head>

<body>
    {{-- Floating particles --}}
    <div class="particles-container" id="particles-container"></div>

    {{-- Anime character overlay --}}
    <img
        src="{{ asset('images/anime.png') }}"
        alt="Anime character placeholder"
        class="anime-character"
        id="anime-overlay"
        loading="lazy"
    >

    <div class="page-wrapper">
        {{-- ======================== HEADER ======================== --}}
        <header class="page-header">
            <a href="{{ url('/') }}" class="logo"><span>Madura</span>Mart</a>
            <nav>
                <a href="{{ url('/') }}">Welcome</a>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ url('/mizuki') }}">Mizuki</a>
                <a href="{{ url('/lagu') }}">Lagu</a>
            </nav>
        </header>

        {{-- ======================== HERO TITLE ======================== --}}
        <section class="hero-title">
            <h1>Listen <em>&</em> Feel</h1>
            <p class="subtitle">a curated melancholic playlist</p>
            <div class="divider"></div>
        </section>

        {{-- ======================== YOUTUBE SEARCH ======================== --}}
        <section class="search-section">
            <div class="search-bar" id="search-bar">
                <input
                    type="text"
                    id="yt-search-input"
                    placeholder="Search any song on YouTube..."
                    autocomplete="off"
                >
                <button id="yt-search-btn" onclick="searchYouTube()">Search</button>
            </div>
            <div class="search-results" id="search-results">
                <div class="search-results-inner" id="search-results-inner">
                    {{-- Populated by JavaScript --}}
                </div>
            </div>
        </section>

        {{-- ======================== NOW PLAYING ======================== --}}
        <section class="now-playing-section" id="player-section">
            <div class="player-card" id="player-card">
                <div class="video-wrapper">
                    <div id="yt-player"></div>
                </div>
                <div class="track-info">
                    <div class="track-details">
                        <div class="track-name" id="track-name">Loading...</div>
                        <div class="track-artist" id="track-artist">—</div>
                    </div>
                    <div class="now-playing-badge">
                        <div class="eq-bars">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        Now Playing
                    </div>
                </div>
            </div>
        </section>

        {{-- ======================== SHUFFLE ======================== --}}
        <div class="shuffle-section">
            <button class="shuffle-btn" id="shuffle-btn" onclick="shuffleTrack()">
                <span class="shuffle-icon">⟳</span>
                Shuffle
            </button>
        </div>

        {{-- ======================== PLAYLIST ======================== --}}
        <section class="playlist-section">
            <div class="playlist-header">
                Curated Playlist
                <input type="text" id="filter-input" class="filter-input" placeholder="Filter playlist...">
            </div>
            <div id="playlist-list">
                {{-- Populated by JavaScript --}}
            </div>
        </section>

        {{-- ======================== FOOTER ======================== --}}
        <footer class="page-footer">
            <p class="footer-quote">"Music is the shorthand of emotion."</p>
            <p>&copy; {{ date('Y') }} Madura Mart &mdash; 音楽ページ</p>
        </footer>
    </div>

    {{-- ======================== YOUTUBE IFRAME API ======================== --}}
    <script>
        /* =============================================================
           CONFIG — YouTube Data API v3 key from .env
           ============================================================= */
        const YT_API_KEY = "{{ env('YT_API_KEY') }}";

        /* =============================================================
           CURATED PLAYLIST DATA
           ============================================================= */
        const PLAYLIST = [
            { id: 't0Bt3a-MLGs', title: 'Surat Cinta Untuk Starla', artist: 'Virgoun', duration: '4:47' },
            { id: '1TO48Cnl66w', title: 'Thank You', artist: 'Dido', duration: '3:38' },
            { id: 'uB2GnZ1IVxA', title: '忘れじの言の葉 (Wasureji no Kotonoha)', artist: 'Mirai Kodai Gakudan', duration: '5:02' }
        ];

        // ─── State ──────────────────────────────────────────────────
        let currentIndex = -1;
        let player = null;       // YouTube IFrame Player instance
        let playerReady = false;
        let searchDebounce = null;

        // ─── DOM References ─────────────────────────────────────────
        const trackNameEl      = document.getElementById('track-name');
        const trackArtistEl    = document.getElementById('track-artist');
        const shuffleBtn       = document.getElementById('shuffle-btn');
        const playlistEl       = document.getElementById('playlist-list');
        const filterInput      = document.getElementById('filter-input');
        const searchInput      = document.getElementById('yt-search-input');
        const searchBtn        = document.getElementById('yt-search-btn');
        const searchResultsEl  = document.getElementById('search-results');
        const searchInnerEl    = document.getElementById('search-results-inner');

        /* =============================================================
           YOUTUBE IFRAME API — Load the API script
           ============================================================= */
        const tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        const firstScript = document.getElementsByTagName('script')[0];
        firstScript.parentNode.insertBefore(tag, firstScript);

        // Called automatically by the YouTube IFrame API when ready
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('yt-player', {
                height: '100%',
                width: '100%',
                playerVars: {
                    autoplay: 0,
                    modestbranding: 1,
                    rel: 0,
                    color: 'white',
                    iv_load_policy: 3    // hide annotations
                },
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        function onPlayerReady(event) {
            playerReady = true;
            // Auto-shuffle on first load
            shuffleTrack();
        }

        function onPlayerStateChange(event) {
            // When a video ends, auto-play the next track from the curated list
            if (event.data === YT.PlayerState.ENDED && currentIndex >= 0) {
                const nextIndex = (currentIndex + 1) % PLAYLIST.length;
                playTrack(nextIndex);
            }
        }

        /* =============================================================
           RENDER CURATED PLAYLIST
           ============================================================= */
        function renderPlaylist() {
            playlistEl.innerHTML = '';
            PLAYLIST.forEach((track, index) => {
                const item = document.createElement('div');
                item.className = 'playlist-item' + (index === currentIndex ? ' active' : '');
                item.setAttribute('role', 'button');
                item.setAttribute('tabindex', '0');
                item.setAttribute('id', `playlist-item-${index}`);
                item.innerHTML = `
                    <span class="track-num">${String(index + 1).padStart(2, '0')}</span>
                    <div class="item-info">
                        <div class="item-title">${escapeHtml(track.title)}</div>
                        <div class="item-artist">${escapeHtml(track.artist)}</div>
                    </div>
                    <span class="item-duration">${track.duration}</span>
                `;
                item.addEventListener('click', () => playTrack(index));
                item.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); playTrack(index); }
                });
                playlistEl.appendChild(item);
            });
        }

        /* =============================================================
           PLAY A CURATED TRACK (by playlist index)
           ============================================================= */
        function playTrack(index) {
            currentIndex = index;
            const track = PLAYLIST[index];

            if (playerReady && player) {
                player.loadVideoById(track.id);
            }

            trackNameEl.textContent   = track.title;
            trackArtistEl.textContent = track.artist;

            renderPlaylist();
            scrollToPlayer();
        }

        /* =============================================================
           PLAY ANY VIDEO BY ID (from search results)
           ============================================================= */
        function playVideoById(videoId, title, channel) {
            currentIndex = -1; // Not from curated playlist

            if (playerReady && player) {
                player.loadVideoById(videoId);
            }

            trackNameEl.textContent   = title;
            trackArtistEl.textContent = channel;

            renderPlaylist(); // Deselect all curated items
            closeSearchResults();
            scrollToPlayer();
        }

        /* =============================================================
           SHUFFLE (curated playlist only)
           ============================================================= */
        function shuffleTrack() {
            let newIndex;
            if (PLAYLIST.length <= 1) {
                newIndex = 0;
            } else {
                do {
                    newIndex = Math.floor(Math.random() * PLAYLIST.length);
                } while (newIndex === currentIndex);
            }

            shuffleBtn.classList.add('spinning');
            setTimeout(() => shuffleBtn.classList.remove('spinning'), 600);

            playTrack(newIndex);
        }

        /* =============================================================
           YOUTUBE DATA API v3 — SEARCH
           ============================================================= */
        async function searchYouTube() {
            const query = searchInput.value.trim();
            if (!query) return;

            searchBtn.disabled = true;
            searchBtn.textContent = '...';
            searchInnerEl.innerHTML = '<div class="search-status">Searching YouTube...</div>';
            openSearchResults();

            try {
                const url = `https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&videoCategoryId=10&maxResults=8&q=${encodeURIComponent(query)}&key=${YT_API_KEY}`;
                const res = await fetch(url);

                if (!res.ok) {
                    const errData = await res.json().catch(() => ({}));
                    throw new Error(errData?.error?.message || `HTTP ${res.status}`);
                }

                const data = await res.json();

                if (!data.items || data.items.length === 0) {
                    searchInnerEl.innerHTML = '<div class="search-status">No results found. Try a different query.</div>';
                    return;
                }

                searchInnerEl.innerHTML = '';
                data.items.forEach(item => {
                    const videoId   = item.id.videoId;
                    const title     = item.snippet.title;
                    const channel   = item.snippet.channelTitle;
                    const thumbnail = item.snippet.thumbnails?.medium?.url || item.snippet.thumbnails?.default?.url || '';

                    const el = document.createElement('div');
                    el.className = 'search-result-item';
                    el.setAttribute('role', 'button');
                    el.setAttribute('tabindex', '0');
                    el.innerHTML = `
                        <img class="thumb" src="${escapeHtml(thumbnail)}" alt="" loading="lazy">
                        <div class="result-info">
                            <div class="result-title">${escapeHtml(decodeEntities(title))}</div>
                            <div class="result-channel">${escapeHtml(channel)}</div>
                        </div>
                    `;
                    el.addEventListener('click', () => {
                        playVideoById(videoId, decodeEntities(title), channel);
                    });
                    el.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') { playVideoById(videoId, decodeEntities(title), channel); }
                    });
                    searchInnerEl.appendChild(el);
                });

            } catch (err) {
                console.error('YouTube API Error:', err);
                searchInnerEl.innerHTML = `<div class="search-status">Error: ${escapeHtml(err.message)}</div>`;
            } finally {
                searchBtn.disabled = false;
                searchBtn.textContent = 'Search';
            }
        }

        /* =============================================================
           SEARCH RESULT PANEL HELPERS
           ============================================================= */
        function openSearchResults() {
            searchResultsEl.classList.add('open');
        }

        function closeSearchResults() {
            searchResultsEl.classList.remove('open');
        }

        /* =============================================================
           UTILITY HELPERS
           ============================================================= */
        function scrollToPlayer() {
            document.getElementById('player-section').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function decodeEntities(encoded) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = encoded;
            return textarea.value;
        }

        /* =============================================================
           PARTICLES GENERATOR
           ============================================================= */
        function generateParticles() {
            const container = document.getElementById('particles-container');
            const count = window.innerWidth < 768 ? 20 : 40;
            for (let i = 0; i < count; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left            = Math.random() * 100 + '%';
                p.style.animationDelay  = (Math.random() * 20) + 's';
                p.style.animationDuration = (Math.random() * 15 + 15) + 's';
                p.style.width           = (Math.random() * 2 + 1) + 'px';
                p.style.height          = p.style.width;
                container.appendChild(p);
            }
        }

        /* =============================================================
           INITIALIZE
           ============================================================= */
        document.addEventListener('DOMContentLoaded', () => {
            generateParticles();
            renderPlaylist();

            // Enter key triggers search
            searchInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') searchYouTube();
            });

            // Playlist filter
            filterInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const items = document.querySelectorAll('.playlist-item');
                items.forEach((item, index) => {
                    const track = PLAYLIST[index];
                    const matches = track.title.toLowerCase().includes(term) ||
                                    track.artist.toLowerCase().includes(term);
                    item.style.display = matches ? 'flex' : 'none';
                });
            });

            // Click outside search results to close
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.search-section')) {
                    closeSearchResults();
                }
            });
        });
    </script>
</body>

</html>
