<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>夜の東京 - Tokyo Nights</title>

    <link rel="icon" type="image/png" href="images/come.jpeg">
    <link rel="apple-touch-icon" href="come.jpeg">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #ffffff;
            overflow-x: hidden;
            position: relative;
        }
        
        /* Animated Background Particles */
        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: #ff006e;
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
            box-shadow: 0 0 10px #ff006e;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(50px); opacity: 0; }
        }
        
        /* Header */
        header {
            position: relative;
            z-index: 10;
            padding: 2rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 14, 39, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(255, 0, 110, 0.3);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, #ff006e, #8338ec, #3a86ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { filter: drop-shadow(0 0 5px #ff006e); }
            to { filter: drop-shadow(0 0 20px #8338ec); }
        }
        
        nav {
            display: flex;
            gap: 2rem;
        }
        
        nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #ff006e, transparent);
            transition: left 0.5s;
        }
        
        nav a:hover::before {
            left: 100%;
        }
        
        nav a:hover {
            border: 1px solid #ff006e;
            color: #ff006e;
        }
        
        /* Profile Hero Section */
        .profile-hero {
            position: relative;
            z-index: 1;
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .profile-container {
            background: rgba(26, 26, 46, 0.6);
            border: 2px solid rgba(255, 0, 110, 0.3);
            border-radius: 30px;
            padding: 3rem;
            backdrop-filter: blur(15px);
            max-width: 800px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            animation: slideUp 1s ease-out;
        }
        
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        /* Profile Image with Center Image */
        .profile-image-wrapper {
            position: relative;
            width: 250px;
            height: 250px;
            margin: 0 auto 2rem;
        }
        
        .profile-image-border {
            position: absolute;
            inset: -5px;
            background: linear-gradient(45deg, #ff006e, #8338ec, #3a86ff, #ff006e);
            border-radius: 50%;
            animation: rotate 3s linear infinite;
            padding: 5px;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .profile-image {
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: #1a1a2e;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-image-placeholder {
            font-size: 6rem;
            color: #ff006e;
        }
        
        /* Center Image Container */
        .center-image-container {
            margin: 2rem 0;
            position: relative;
        }
        
        .center-image-wrapper {
            max-width: 600px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            border: 3px solid rgba(255, 0, 110, 0.5);
            box-shadow: 0 15px 40px rgba(255, 0, 110, 0.3);
            transition: all 0.3s ease;
            background: #1a1a2e;
        }
        
        .center-image-wrapper:hover {
            transform: scale(1.02);
            border-color: #ff006e;
            box-shadow: 0 20px 50px rgba(255, 0, 110, 0.5);
        }
        
        .center-image {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .center-image-placeholder {
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: #ff006e;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
        }
        
        /* Username and Bio */
        .profile-username {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #ff006e, #8338ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .profile-title {
            font-size: 1.2rem;
            color: #a0a0a0;
            margin-bottom: 1.5rem;
        }
        
        .profile-bio {
            font-size: 1rem;
            color: #c0c0c0;
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Stats Row */
        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, #ff006e, #8338ec);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #a0a0a0;
            margin-top: 0.5rem;
        }
        
        /* Action Buttons */
        .profile-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 0.8rem 2rem;
            font-size: 1rem;
            border: 2px solid #ff006e;
            background: transparent;
            color: #ff006e;
            cursor: pointer;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-family: 'Noto Sans JP', sans-serif;
        }
        
        .action-btn:hover {
            background: #ff006e;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 0, 110, 0.4);
        }
        
        .action-btn.primary {
            background: linear-gradient(45deg, #ff006e, #8338ec);
            border: none;
            color: white;
        }
        
        .action-btn.primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 40px rgba(255, 0, 110, 0.5);
        }
        
        /* Cards Section */
        .cards-section {
            position: relative;
            z-index: 1;
            padding: 5rem 5%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .card {
            background: rgba(26, 26, 46, 0.6);
            border: 1px solid rgba(255, 0, 110, 0.2);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 0, 110, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }
        
        .card:hover::before {
            left: 100%;
        }
        
        .card:hover {
            transform: translateY(-10px);
            border-color: #ff006e;
            box-shadow: 0 20px 60px rgba(255, 0, 110, 0.3);
        }
        
        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }
        
        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #ff006e;
        }
        
        .card p {
            color: #c0c0c0;
            line-height: 1.6;
        }
        
        /* Footer */
        footer {
            position: relative;
            z-index: 1;
            padding: 3rem 5%;
            text-align: center;
            background: rgba(10, 14, 39, 0.9);
            border-top: 2px solid rgba(255, 0, 110, 0.3);
            margin-top: 5rem;
        }
        
        footer p {
            color: #a0a0a0;
            margin-bottom: 1rem;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .social-links a {
            color: #ff006e;
            font-size: 2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-links a:hover {
            transform: scale(1.2) rotate(10deg);
            filter: drop-shadow(0 0 10px #ff006e);
        }
        
        /* Cursor Effect */
        .cursor-follower {
            position: fixed;
            width: 20px;
            height: 20px;
            border: 2px solid #ff006e;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: all 0.1s ease;
            transform: translate(-50%, -50%);
        }
        
        @media (max-width: 768px) {
            .profile-username { font-size: 2rem; }
            nav { flex-direction: column; gap: 1rem; }
            .profile-stats { gap: 1.5rem; }
            .profile-container { padding: 2rem; }
        }
    </style>
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor-follower"></div>
    
    <!-- Particles Background -->
    <div class="particles" id="particles"></div>
    
    <!-- Header -->
    <header>
        <div class="logo">夜の東京</div>
        <nav>
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#portfolio">Portfolio</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>
    
    <!-- Profile Hero Section -->
    <section class="profile-hero" id="home">
        <div class="profile-container">
            <!-- Profile Image -->
            <div class="profile-image-wrapper">
                <div class="profile-image-border"></div>
                <div class="profile-image">
                    <img src="images/mizuki_akiyama.jpeg" alt="Profile" class="w-full h-full object-cover">
                </div>
            </div>
            
            <!-- Username and Title -->
            <h1 class="profile-username">Mizuki Akiyama</h1>
            <p class="profile-title">Programmer code | プロジェクトセカイ カラフルステージ!</p>
            
            <!-- Bio -->
            <p class="profile-bio">Creating beautiful experiences at the intersection of technology and art. Exploring the fusion of traditional Japanese aesthetics with modern design.</p>
            
            <!-- Stats -->
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number">10M</span>
                    <span class="stat-label">Posts </span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100M</span>
                    <span class="stat-label">Followers </span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">100M</span>
                    <span class="stat-label">Following</span>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="profile-actions">
                <button class="action-btn primary" onclick="followUser()">Follow </button>
                <button class="action-btn" onclick="sendMessage()">Message</button>
                <button class="action-btn" onclick="shareProfile()">Share </button>
            </div>
        </div>
    </section>
    
    <!-- Cards Section -->
    <section class="cards-section" id="portfolio">
        <div class="card">
            <span class="card-icon">🏮</span>
            <h3>Tradition</h3>
            <p>Where ancient wisdom meets modern innovation in perfect harmony.</p>
        </div>
        <div class="card">
            <span class="card-icon">🌸</span>
            <h3>Aesthetics</h3>
            <p>Japanese concept of beauty that finds perfection in simplicity.</p>
        </div>
        <div class="card">
            <span class="card-icon">⚡</span>
            <h3>Technology</h3>
            <p>Cutting-edge technology shaping the future of culture and design.</p>
        </div>
        <div class="card">
            <span class="card-icon">🎨</span>
            <h3>Art</h3>
            <p>From traditional art forms to contemporary digital masterpieces.</p>
        </div>
    </section>
    
    <!-- Footer -->
    <footer id="contact">
        <p>&copy; 2025 夜の東京 - Tokyo Nights. All rights reserved.</p>
        <p>The fusion of Japanese aesthetics and modern design 日本の美学と現代デザインの融合</p>
        <div class="social-links">
            <a href="#" title="Twitter">✦</a>
            <a href="#" title="Instagram">✧</a>
            <a href="#" title="GitHub">★</a>
        </div>
    </footer>
    
    <script>
        // Particles Animation
        const particlesContainer = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }
        
        // Custom Cursor
        const cursorFollower = document.querySelector('.cursor-follower');
        document.addEventListener('mousemove', (e) => {
            cursorFollower.style.left = e.clientX + 'px';
            cursorFollower.style.top = e.clientY + 'px';
        });
        
        // Card Hover Effect
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.background = 'rgba(255, 0, 110, 0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.background = 'rgba(26, 26, 46, 0.6)';
            });
        });
        
        // Profile Actions
        function followUser() {
            alert('Following user! フォローしました！');
        }
        
        function sendMessage() {
            alert('Opening message... メッセージを開いています...');
        }
        
        function shareProfile() {
            alert('Sharing profile! プロフィールをシェア！');
        }
        
        // Smooth Scroll for Navigation
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
        
        // Add parallax effect on scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.profile-hero');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });
    </script>
</body>
</html>