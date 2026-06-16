<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achiziție — I.S. Bacul Molovata</title>
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

<?php include 'header.php'; setActiv('Achizitie'); ?>

<?php
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $bd_name = "baculmolovata";
    $con = new mysqli($servername, $user, $pass, $bd_name);
    if ($con->connect_error) die("Conexiune esuata: " . $con->connect_error);

    $result = $con->query("
        SELECT ID_Achizitie, data, Link , Titlu
        FROM achizitie 
        ORDER BY YEAR(data) DESC, data DESC
    ");
    $documente_pe_ani = [];
    while ($row = $result->fetch_assoc()) {
        $an = date('Y', strtotime($row['data']));
        $documente_pe_ani[$an][] = $row;
    }
    $con->close();
?>

<section class="continut">
    <div class="container">
        <?php foreach ($documente_pe_ani as $an => $documente): ?>
        <div class="year-card">
            <div class="year-title"><?= htmlspecialchars($an) ?></div>
            <ul class="link-list">
                <?php foreach ($documente as $doc):
                    ?>
                <li>
                    <a href="<?= htmlspecialchars($doc['Link']) ?>">
                        📄 <?= htmlspecialchars($doc['Titlu']) ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
