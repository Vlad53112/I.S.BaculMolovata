<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I.S.Bacul Molovata</title>
    <link rel="stylesheet" href="Stilul.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; color: #222; }

        header {
            background: linear-gradient(135deg, #011f7a 0%, #0288d1 100%);
            color: white;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,0.18);
            transition: all 0.3s ease;
        }

        header.expanded .header-top {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 40px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        header.expanded .logo-area img {
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.5);
            transition: all 0.3s;
        }
        header.expanded .logo-area span {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.3;
        }
        header.expanded .header-nav {
            display: flex;
            justify-content: center;
            padding: 10px 40px 14px;
        }
        header.expanded .hamburger {
            display: none;
        }

        header.compact .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 28px;
        }
        header.compact .logo-area img {
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.4);
            transition: all 0.3s;
        }
        header.compact .logo-area span {
            font-size: 13px;
            font-weight: 700;
            line-height: 1.2;
        }
        header.compact .header-nav {
            display: flex;
            align-items: center;
            padding: 0;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 4px;
            padding: 0;
            margin: 0;
        }
        nav ul li a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 13px;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
            display: block;
        }
        nav ul li a:hover, nav ul li a.activ {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }
        .hamburger {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            white-space: nowrap;
        }
        .hamburger:hover { background: rgba(255,255,255,0.2); }

        .nav-dropdown {
            position: relative;
            display: none;
        }
        .nav-dropdown-btn {
            background: rgba(255,255,255,0.12);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: background 0.2s;
        }
        .nav-dropdown-btn:hover { background: rgba(255,255,255,0.22); }
        .nav-dropdown-btn .arrow { font-size: 10px; transition: transform 0.2s; }
        .nav-dropdown:hover .arrow { transform: rotate(180deg); }
        .nav-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #011f7a;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            min-width: 200px;
            overflow: hidden;
            z-index: 200;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .nav-dropdown:hover .nav-dropdown-menu { display: block; }
        .nav-dropdown-menu a {
            display: block;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.15s;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .nav-dropdown-menu a:last-child { border-bottom: none; }
        .nav-dropdown-menu a:hover, .nav-dropdown-menu a.activ {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        /* RESPONSIVE - mobil */
        @media (max-width: 900px) {
            header.expanded .header-top {
                justify-content: space-between;
                padding: 14px 16px 10px;
            }
            header.expanded .logo-area img { height: 50px; }
            header.expanded .logo-area span { font-size: 14px; }
            header.expanded .header-nav { padding: 0 16px 12px; }
            header.expanded .hamburger { display: block !important; }
            header.compact .header-top { padding: 8px 16px; }
            header.compact .logo-area img { height: 34px; }
            header.compact .logo-area span { font-size: 12px; }
            header.compact .hamburger { display: block !important; }
            nav ul {
                display: none !important;
                flex-direction: column !important;
                width: 100% !important;
                padding: 8px 0 12px !important;
                justify-content: flex-start !important;
                background: rgba(0,0,0,0.15);
            }
            nav ul.show { display: flex !important; }
            nav ul li a { padding: 11px 20px; }
        }

        .hero {
            background: #fff;
            max-width: 1200px;
            margin: 28px auto 0;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            display: flex;
            align-items: stretch;
            overflow: hidden;
            flex-wrap: wrap;
        }
        .hero img {
            width: 42%;
            min-width: 260px;
            object-fit: cover;
            display: block;
        }
        .hero-text {
            flex: 1;
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 14px;
        }
        .hero-text h2 {
            font-size: 28px;
            color: #011f7a;
            font-weight: 700;
            text-align: left;
            margin: 0;
        }
        .hero-text p {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin: 0;
        }
        .btn-citeste {
            display: inline-block;
            background: #011f7a;
            color: #fff;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            width: fit-content;
            transition: background 0.2s;
        }
        .btn-citeste:hover { background: #0288d1; }

        @media (max-width: 700px) {
            .hero { flex-direction: column; }
            .hero img { width: 100%; height: 220px; }
            .hero-text { padding: 24px 20px; }
        }

        /* ── GALERIE ── */
        .sectiune-galerie {
            max-width: 1200px;
            margin: 32px auto 0;
            padding: 0 16px;
        }
        .sectiune-galerie h2 {
            font-size: 22px;
            color: #011f7a;
            margin-bottom: 16px;
            text-align: left;
            font-weight: 700;
        }
        .galerie {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }
        .galerie img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s, filter 0.3s;
            display: block;
        }
        .galerie img:hover { transform: scale(1.03); filter: brightness(85%); }
        .btn-galerie-wrap { text-align: right; margin-top: 8px; }
        .read-more-button {
            display: inline-block;
            background: #0288d1;
            color: #fff;
            padding: 10px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .read-more-button:hover { background: #011f7a; }

        @media (max-width: 700px) {
            .galerie { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .galerie { grid-template-columns: 1fr; }
        }

        .sectiune-recenzii {
            background: linear-gradient(180deg, #f0f4f8 0%, #e8eef5 100%);
            padding: 48px 16px 56px;
            margin-top: 40px;
        }
        .titlu-recenzii {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            color: #011f7a;
            margin-bottom: 28px;
        }

        .slider-wrapper { overflow: hidden; width: 100%; position: relative; }
        .slider-track {
            display: flex;
            gap: 20px;
            width: max-content;
            animation: derulare 30s linear infinite;
        }
        .slider-track:hover { animation-play-state: paused; }
        @keyframes derulare {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .review-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            width: 280px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            flex-shrink: 0;
            border-top: 3px solid #0288d1;
        }
        .review-stars { font-size: 1.3rem; color: #f4a000; margin-bottom: 10px; }
        .review-text { font-size: 0.9rem; color: #555; font-style: italic; margin-bottom: 12px; line-height: 1.6; }
        .review-autor { font-weight: 700; color: #011f7a; font-size: 0.88rem; }
        .review-data { font-size: 0.75rem; color: #aaa; margin-top: 4px; }

        .form-recenzie {
            max-width: 560px;
            margin: 40px auto 0;
            background: #fff;
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.09);
        }
        .form-recenzie h3 {
            text-align: center;
            color: #011f7a;
            margin-bottom: 28px;
            font-size: 1.25rem;
            font-weight: 700;
        }
        #formRecenzie {
            display: block !important;
            flex-direction: unset !important;
            align-items: unset !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .fg { margin-bottom: 20px; display: flex; flex-direction: column; gap: 7px; }
        .fg label { font-weight: 600; font-size: 0.88rem; color: #444; letter-spacing: 0.2px; }
        .fg input[type="text"], .fg textarea {
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 11px 14px !important;
            margin: 0 !important;
            border: 1.5px solid #e0e0e0 !important;
            border-radius: 9px !important;
            font-size: 0.95rem !important;
            font-family: inherit !important;
            background: #f8fafc !important;
            box-shadow: none !important;
            transition: border-color 0.2s, background 0.2s !important;
            color: #222 !important;
        }
        .fg input[type="text"]:focus, .fg textarea:focus {
            outline: none !important;
            border-color: #0288d1 !important;
            background: #fff !important;
            box-shadow: 0 0 0 3px rgba(2,136,209,0.12) !important;
        }
        .fg textarea { resize: vertical !important; min-height: 110px !important; }
        .fg .hint { font-size: 0.76rem; color: #aaa; }

        .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 6px; }
        .star-rating input[type="radio"] { display: none !important; width: auto !important; margin: 0 !important; padding: 0 !important; }
        .star-rating label { font-size: 2.2rem; color: #ddd; cursor: pointer; transition: color 0.15s; line-height: 1; }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #f4a000; }

        #formRecenzie .btn-trimite {
            width: 100% !important;
            padding: 13px !important;
            background: linear-gradient(135deg, #011f7a, #0288d1) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 9px !important;
            font-size: 1rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            margin-top: 8px !important;
            transition: opacity 0.2s !important;
            letter-spacing: 0.3px !important;
        }
        #formRecenzie .btn-trimite:hover { opacity: 0.88 !important; }

        .alert-succes { background: #e8f5e9; color: #1b5e20; border: 1px solid #a5d6a7; border-radius: 9px; padding: 14px 18px; margin-bottom: 20px; font-weight: 600; }
        .alert-eroare { background: #fce4ec; color: #880e4f; border: 1px solid #f48fb1; border-radius: 9px; padding: 14px 18px; margin-bottom: 20px; }
        .alert-eroare ul { margin: 0; padding-left: 18px; }
        .alert-eroare li { margin-bottom: 4px; font-size: 0.9rem; }

        footer {
            background: linear-gradient(135deg, #011f7a 0%, #0a3880 100%);
            color: rgba(255,255,255,0.9);
            padding: 40px 32px 28px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            margin-top: 0;
        }
        .footer-bloc { font-size: 14px; line-height: 1.8; }
        .footer-bloc b { font-size: 16px; color: #fff; display: block; margin-bottom: 6px; }
        .footer-bloc p { margin: 0; color: rgba(255,255,255,0.8); }
        .footer-bloc a { color: #90caf9; text-decoration: none; }
        .footer-bloc a:hover { color: #fff; }
        .footer-bloc hr { border: none; border-top: 1px solid rgba(255,255,255,0.15); margin: 14px 0; }
        .orar-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 8px; }
        .orar-grid p { margin: 2px 0; font-size: 14px; color: rgba(255,255,255,0.85); }
        .footer-bottom {
            grid-column: 1 / -1;
            text-align: center;
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 16px;
            margin-top: 8px;
        }

        @media (max-width: 800px) {
            footer { grid-template-columns: 1fr; gap: 24px; }
            .footer-bottom { grid-column: 1; }
        }
    </style>
</head>
<body>

<?php include 'header.php'; setActiv('Principala'); ?>

<script>
    const header     = document.getElementById('mainHeader');
    const hamburger  = document.getElementById('hamburger-btn');
    const navExpanded  = document.getElementById('navExpanded');
    const navCompact   = document.getElementById('navCompact');
    const menuCompact  = document.getElementById('menuCompact');

    function updateHeader() {
        const isMobile = window.innerWidth <= 900;
        const scrolled = window.scrollY > 60;

        if (scrolled) {
            header.classList.remove('expanded');
            header.classList.add('compact');
            navExpanded.style.display = 'none';
            navCompact.style.display  = isMobile ? 'none' : 'flex';
            hamburger.style.display   = isMobile ? 'block' : 'none';
        } else {
            header.classList.remove('compact');
            header.classList.add('expanded');
            navExpanded.style.display = isMobile ? 'none' : 'flex';
            navCompact.style.display  = 'none';
            hamburger.style.display   = isMobile ? 'block' : 'none';
        }
    }

    window.addEventListener('scroll', updateHeader);
    window.addEventListener('resize', updateHeader);
    updateHeader();

    hamburger.addEventListener('click', function() {
        const scrolled = window.scrollY > 60;
        const isMobile = window.innerWidth <= 900;
        if (scrolled || isMobile) {
            if (menuCompact.classList.contains('show')) {
                menuCompact.classList.remove('show');
                navCompact.style.display = 'none';
            } else {
                navCompact.style.display = 'flex';
                menuCompact.classList.add('show');
            }
        }
    });
</script>

<main>
    <div class="hero" style="margin-left:auto;margin-right:auto;max-width:1200px;margin-top:28px;border-radius:16px;">
        <img src="logo.jpg" alt="Bacul Molovata">
        <div class="hero-text">
            <h2>Bacul Molovata</h2>
            <p>Fondatorul întreprinderii – AGENŢIA PROPRIETĂŢII PUBLICE al RM. Întreprinderea este predestinată pentru transportarea pasagerilor și mărfurilor din s. Molovata Nouă în s. Molovata, peste râul Nistru, raionul Dubăsari, cu șlepul nepropulsat.</p>
            <p>De asemenea, populația localităților din această zonă este asigurată cu produse alimentare, în special pe timp de iarnă, tot cu ajutorul podului plutitor.</p>
            <a href="DespreNoi.php" class="btn-citeste">Citește mai departe →</a>
        </div>
    </div>

    <?php
        $servername = "localhost";
        $user = "root";
        $pass = "";
        $bd_name = "baculmolovata";
        $con = new mysqli($servername, $user, $pass, $bd_name);
        if ($con->connect_error) die("Conexiune esuata: " . $con->connect_error);

        $erori  = [];
        $succes = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['trimite_recenzie'])) {
            if (!empty($_POST['website'])) {
                $succes = true;
            } else {
                $timp_start = (int)($_POST['timp_start'] ?? 0);
                if (time() - $timp_start < 3) $erori[] = "Formularul a fost completat prea rapid.";

                $nume = trim($_POST['nume'] ?? '');
                $nume = strip_tags($nume);
                $nume = htmlspecialchars($nume, ENT_QUOTES, 'UTF-8');
                if (empty($nume))            $erori[] = "Numele este obligatoriu.";
                elseif (strlen($nume) < 3)   $erori[] = "Numele trebuie să aibă cel puțin 3 caractere.";
                elseif (strlen($nume) > 100) $erori[] = "Numele nu poate depăși 100 de caractere.";
                elseif (!preg_match('/^[\p{L}\s\-\.]+$/u', $nume)) $erori[] = "Numele poate conține doar litere, spații și cratime.";

                $stele = $_POST['stele'] ?? '';
                if (!in_array((string)$stele, ['1','2','3','4','5'], true)) $erori[] = "Selectează un calificativ între 1 și 5 stele.";
                else $stele = (int)$stele;

                $text = trim($_POST['text'] ?? '');
                if (preg_match('/<script|javascript:|on\w+\s*=/i', $text)) $erori[] = "Textul conține caractere nepermise.";
                $text = strip_tags($text);
                $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                if (empty($text))             $erori[] = "Textul recenziei este obligatoriu.";
                elseif (strlen($text) < 10)   $erori[] = "Recenzia trebuie să aibă cel puțin 10 caractere.";
                elseif (strlen($text) > 1000) $erori[] = "Recenzia nu poate depăși 1000 de caractere.";

                if (empty($erori)) {
                    $stmt = $con->prepare("INSERT INTO recenzii (nume, stele, text, data) VALUES (?, ?, ?, NOW())");
                    $stmt->bind_param("sis", $nume, $stele, $text);
                    if ($stmt->execute()) $succes = true;
                    else $erori[] = "Eroare la salvare. Încearcă din nou.";
                    $stmt->close();
                }
            }
        }

        $rez_recenzii = $con->query("SELECT nume, stele, text, data FROM recenzii ORDER BY data DESC");
        $recenzii = [];
        while ($r = $rez_recenzii->fetch_assoc()) $recenzii[] = $r;

        $result = $con->query("SELECT link FROM poze WHERE link != '' AND link IS NOT NULL LIMIT 12");
        $poze = [];
        while ($row = $result->fetch_assoc()) $poze[] = $row['link'];
        $con->close();
        $grupuri = array_chunk($poze, 3);
    ?>

    <div class="sectiune-galerie">
        <h2>🖼️ Galerie foto</h2>
        <?php foreach ($grupuri as $grup): ?>
        <div class="galerie">
            <?php foreach ($grup as $index => $url): ?>
            <img src="<?= htmlspecialchars($url) ?>" alt="Poza <?= $index + 1 ?>">
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        <div class="btn-galerie-wrap">
            <a href="Galereie.php" class="read-more-button">Vizionează mai departe →</a>
        </div>
    </div>

    <section class="sectiune-recenzii">
        <h2 class="titlu-recenzii">⭐ Ce spun utilizatorii</h2>

        <?php if (!empty($recenzii)): ?>
        <div class="slider-wrapper">
            <div class="slider-track">
                <?php foreach ($recenzii as $rec): ?>
                <div class="review-card">
                    <div class="review-stars"><?= str_repeat('★', (int)$rec['stele']) . str_repeat('☆', 5 - (int)$rec['stele']) ?></div>
                    <p class="review-text">"<?= htmlspecialchars($rec['text']) ?>"</p>
                    <p class="review-autor">— <?= htmlspecialchars($rec['nume']) ?></p>
                    <p class="review-data"><?= date('d.m.Y', strtotime($rec['data'])) ?></p>
                </div>
                <?php endforeach; ?>
                <?php foreach ($recenzii as $rec): ?>
                <div class="review-card">
                    <div class="review-stars"><?= str_repeat('★', (int)$rec['stele']) . str_repeat('☆', 5 - (int)$rec['stele']) ?></div>
                    <p class="review-text">"<?= htmlspecialchars($rec['text']) ?>"</p>
                    <p class="review-autor">— <?= htmlspecialchars($rec['nume']) ?></p>
                    <p class="review-data"><?= date('d.m.Y', strtotime($rec['data'])) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="form-recenzie">
            <h3>✍️ Lasă o recenzie</h3>

            <?php if ($succes): ?>
                <div class="alert-succes">✅ Recenzia ta a fost trimisă cu succes! Mulțumim!</div>
            <?php endif; ?>
            <?php if (!empty($erori)): ?>
                <div class="alert-eroare">
                    <ul><?php foreach ($erori as $e): ?><li><?= $e ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>

            <?php if (!$succes): ?>
            <form method="POST" action="" id="formRecenzie" novalidate>
                <input type="text" name="website" style="display:none;" tabindex="-1" autocomplete="off">
                <input type="hidden" name="timp_start" value="<?= time() ?>">

                <div class="fg">
                    <label for="nume">Numele tău *</label>
                    <input type="text" id="nume" name="nume" maxlength="100"
                           placeholder="Ex: Ion Popescu"
                           value="<?= htmlspecialchars($_POST['nume'] ?? '') ?>" required>
                    <span class="hint">Doar litere și cratime, 3–100 caractere</span>
                </div>

                <div class="fg">
                    <label>Calificativ *</label>
                    <div class="star-rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="s<?= $i ?>" name="stele" value="<?= $i ?>"
                               <?= (($_POST['stele'] ?? '5') == $i) ? 'checked' : '' ?>>
                        <label for="s<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="fg">
                    <label for="text">Recenzia ta *</label>
                    <textarea id="text" name="text" rows="4" maxlength="1000"
                              placeholder="Scrie experiența ta... (10–1000 caractere)"
                              required><?= htmlspecialchars($_POST['text'] ?? '') ?></textarea>
                    <span class="hint" id="contor">0 / 1000 caractere</span>
                </div>

                <button type="submit" name="trimite_recenzie" class="btn-trimite">Trimite recenzia</button>
            </form>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
const textarea = document.getElementById('text');
const contor   = document.getElementById('contor');
if (textarea && contor) {
    textarea.addEventListener('input', function() {
        const lung = this.value.length;
        contor.textContent = lung + ' / 1000 caractere';
        contor.style.color = lung > 900 ? '#c0392b' : '#aaa';
    });
}
document.getElementById('formRecenzie')?.addEventListener('submit', function(e) {
    const nume  = document.getElementById('nume').value.trim();
    const text  = document.getElementById('text').value.trim();
    const stele = document.querySelector('input[name="stele"]:checked');
    if (nume.length < 3)  { alert('Numele trebuie să aibă cel puțin 3 caractere.'); e.preventDefault(); return; }
    if (!stele)            { alert('Te rugăm să selectezi un calificativ.'); e.preventDefault(); return; }
    if (text.length < 10) { alert('Recenzia trebuie să aibă cel puțin 10 caractere.'); e.preventDefault(); return; }
});
</script>
<?php include 'footer.php'; ?>
</body>
</html>