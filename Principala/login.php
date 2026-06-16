<?php
mb_internal_encoding('UTF-8');
session_start();

if (isset($_SESSION['logat']) && $_SESSION['logat'] === true) {
    header("Location: Principala.php");
    exit;
}
$eroare = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilizator = trim($_POST['utilizator'] ?? '');
    $parola     = trim($_POST['parola'] ?? '');

    $con = new mysqli("localhost", "root", "", "baculmolovata");
    if ($con->connect_error) {
        die("Eroare conectare: " . $con->connect_error);
    }

    $stmt = $con->prepare("SELECT parola FROM loghin WHERE login = ?");
    $stmt->bind_param("s", $utilizator);
    $stmt->execute();
    $stmt->bind_result($parola_db);

    if ($stmt->fetch() && $parola_db === $parola) {
        $_SESSION['logat']      = true;
        $_SESSION['utilizator'] = $utilizator;
        $stmt->close();
        $con->close();
        header("Location: Principala.php");
        exit;
    } else {
        $eroare = 'Utilizator sau parolă incorectă.';
    }

    $stmt->close();
    $con->close();
}
function e($s) { return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autentificare – Bacul Molovata</title>
    <style>
        * { 
            box-sizing: border-box; 
        }
        body {
            margin: 0;
            background: linear-gradient(135deg, #1a3a6e 0%, #3572c6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 40px 36px 32px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.22);
            width: 360px;
        }
        .logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo h1 {
            margin: 0;
            font-size: 28px;
            color: #1a3a6e;
            letter-spacing: 1px;
        }
        .logo p {
            margin: 4px 0 0;
            color: #888;
            font-size: 13px;
        }
        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 4px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 18px;
            transition: border-color .2s;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #3572c6;
        }
        button {
            width: 100%;
            background: #1a3a6e;
            color: #fff;
            padding: 11px;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }
        button:hover { 
            background: #3572c6; 
        }
        .eroare {
            background: #fdecea;
            color: #b00020;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 9px 12px;
            font-size: 13px;
            margin-bottom: 18px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <h1>🏛️ Bacul Molovata</h1>
        <p>Sistem de administrare</p>
    </div>
    <?php if ($eroare): ?>
        <div class="eroare"><?= e($eroare) ?></div>
    <?php endif; ?>
    <form method="POST">
        <label>Utilizator</label>
        <input type="text" name="utilizator" placeholder="Introduceti utilizatorul" autofocus required>
        <label>Parolă</label>
        <input type="password" name="parola" placeholder="Introduceti parola" required>
        <button type="submit">Autentificare</button>
    </form>
</div>
</body>
</html>
