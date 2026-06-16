<?php
require_once 'auth.php';

$con = new mysqli("localhost","root","","baculmolovata");
if($con->connect_error) die("Eroare conectare: ".$con->connect_error);

$utilizator = $_SESSION['utilizator'] ?? '';
$mesaj = '';
$tip_mesaj = '';

$stmt = $con->prepare("SELECT login, parola FROM loghin WHERE login = ?");
$stmt->bind_param("s", $utilizator);
$stmt->execute();
$stmt->bind_result($login_curent, $parola_curenta);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_nou     = trim($_POST['login_nou'] ?? '');
    $parola_veche  = trim($_POST['parola_veche'] ?? '');
    $parola_noua   = trim($_POST['parola_noua'] ?? '');
    $parola_confirma = trim($_POST['parola_confirma'] ?? '');

    if ($parola_veche !== $parola_curenta) {
        $mesaj = 'Parola actuala este incorecta.';
        $tip_mesaj = 'err';
    } elseif (empty($login_nou)) {
        $mesaj = 'Numele de utilizator nu poate fi gol.';
        $tip_mesaj = 'err';
    } elseif (!empty($parola_noua) && $parola_noua !== $parola_confirma) {
        $mesaj = 'Parolele noi nu coincid.';
        $tip_mesaj = 'err';
    } elseif (!empty($parola_noua) && strlen($parola_noua) < 4) {
        $mesaj = 'Parola noua trebuie sa aiba minim 4 caractere.';
        $tip_mesaj = 'err';
    } else {
        $parola_finala = !empty($parola_noua) ? $parola_noua : $parola_curenta;
        $stmt2 = $con->prepare("UPDATE loghin SET login = ?, parola = ? WHERE login = ?");
        $stmt2->bind_param("sss", $login_nou, $parola_finala, $utilizator);
        if ($stmt2->execute()) {
            $_SESSION['utilizator'] = $login_nou;
            $utilizator = $login_nou;
            $login_curent = $login_nou;
            $parola_curenta = $parola_finala;
            $mesaj = 'Contul a fost actualizat cu succes!';
            $tip_mesaj = 'ok';
        } else {
            $mesaj = 'Eroare la actualizare.';
            $tip_mesaj = 'err';
        }
        $stmt2->close();
    }
}

function he($s){ return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<title>Actualizare Cont</title>
<style>
*{ 
    box-sizing:border-box;
     margin:0; 
     padding:0; 
}
body{
    font-family:'Segoe UI',Arial,sans-serif;
    background:#eef2f7;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}
.header{
    background:linear-gradient(90deg,#1a3a6e 0%,#2e5fbf 100%);
    color:#fff;
    padding:14px 28px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    box-shadow:0 2px 8px rgba(0,0,0,.18);
}
.header h1{ 
    font-size:22px; 
    font-weight:700; 
}
.btn-back{
    background:#fff;
    color:#1a3a6e;
    padding:6px 16px;
    border-radius:5px;
    text-decoration:none;
    font-size:13px;
    font-weight:600;
}
.btn-back:hover{ 
    background:#eef2f7; 
}
.container{
    max-width:480px;
    margin:40px auto;
    background:#fff;
    border-radius:12px;
    padding:32px 36px;
    box-shadow:0 4px 14px rgba(0,0,0,.07);
}
.container h2{
    color:#1a3a6e;
    font-size:22px;
    margin-bottom:24px;
    border-bottom:2px solid #eef2f7;
    padding-bottom:12px;
}
label{
    display:block;
    font-size:13px;
    font-weight:600;
    color:#555;
    margin-bottom:5px;
    margin-top:16px;
}
input[type=text], input[type=password]{
    width:100%;
    padding:10px 13px;
    border:1px solid #ddd;
    border-radius:7px;
    font-size:14px;
    outline:none;
    transition:border .2s;
}
input[type=text]:focus, input[type=password]:focus{ 
    border-color:#2e5fbf; 
}
.hint{
    font-size:11px;
    color:#aaa;
    margin-top:3px;
}
.divider{
    border:none;
    border-top:1px dashed #eee;
    margin:22px 0 6px;
}
.btn-save{
    width:100%;
    margin-top:24px;
    background:#27ae60;
    color:#fff;
    border:none;
    padding:12px;
    border-radius:7px;
    font-size:15px;
    font-weight:700;
    cursor:pointer;
    transition:background .2s;
}
.btn-save:hover{ 
    background:#1e8449; 
}
.msg-ok{
    background:#eafaf1;
    color:#27ae60;
    border:1px solid #a9dfbf;
    border-radius:7px;
    padding:10px 14px;
    font-size:14px;
    margin-bottom:16px;
    text-align:center;
}
.msg-err{
    background:#fdf0f0;
    color:#e74c3c;
    border:1px solid #f5b7b1;
    border-radius:7px;
    padding:10px 14px;
    font-size:14px;
    margin-bottom:16px;
    text-align:center;
}
</style>
</head>
<body>
<div class="header">
    <h1>🏛️ I.S.Bacul Molovata</h1>
    <a href="Principala.php" class="btn-back">← Inapoi</a>
</div>
<div class="container">
    <h2>✏️ Actualizare Cont</h2>

    <?php if($mesaj): ?>
        <div class="msg-<?=he($tip_mesaj)?>"><?=he($mesaj)?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nume utilizator</label>
        <input type="text" name="login_nou" value="<?=he($login_curent)?>" required>

        <hr class="divider">

        <label>Parola actuala <span style="color:#e74c3c">*</span></label>
        <input type="password" name="parola_veche" required>
        <div class="hint">Obligatoriu pentru orice modificare.</div>

        <label>Parola noua <span style="color:#aaa;font-weight:400">(optional)</span></label>
        <input type="password" name="parola_noua">
        <div class="hint">Lasa gol daca nu vrei sa schimbi parola.</div>

        <label>Confirma parola noua</label>
        <input type="password" name="parola_confirma">

        <button type="submit" class="btn-save">💾 Salveaza modificarile</button>
    </form>
</div>
</body>
</html>