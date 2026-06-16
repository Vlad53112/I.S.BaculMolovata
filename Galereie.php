<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie — I.S. Bacul Molovata</title>
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

        @media (max-width: 900px) {
            header.expanded .header-top {
                justify-content: space-between;
                padding: 14px 16px 10px;
            }
            header.expanded .logo-area img { height: 50px; }
            header.expanded .logo-area span { font-size: 14px; }
            header.expanded .header-nav { padding: 0 16px 12px; display: none !important; }
            header.compact .header-top { padding: 8px 16px; }
            header.compact .logo-area img { height: 34px; }
            header.compact .logo-area span { font-size: 12px; }
            .nav-dropdown { display: block !important; }
            .hamburger { display: none !important; }
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

<?php include 'header.php'; setActiv(''); ?>

<?php
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $bd_name = "baculmolovata";
    $con = new mysqli($servername, $user, $pass, $bd_name);
    if ($con->connect_error) die("Conexiune esuata: " . $con->connect_error);

    $result = $con->query("SELECT Link FROM poze WHERE link != '' AND link IS NOT NULL");
    $poze = [];
    while ($row = $result->fetch_assoc()) $poze[] = $row['Link'];
    $con->close();
    $grupuri = array_chunk($poze, 3);
?>

<section class="continut">
    <?php foreach ($grupuri as $grup): ?>
    <div class="galerie">
        <?php foreach ($grup as $index => $url): ?>
        <img src="<?= htmlspecialchars($url) ?>" alt="Poza <?= $index + 1 ?>">
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
