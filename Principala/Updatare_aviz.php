<?php
require_once 'auth.php';
mb_internal_encoding('UTF-8');
$errors = [];
$values = ['data' => '', 'titlu' => '', 'text' => ''];
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

$con = new mysqli("localhost","root","","baculmolovata");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
    $r = $con->query("SELECT data, titlu, text FROM avizuri WHERE ID_Aviz=$id")->fetch_row();
    if ($r) { $values['data']=$r[0]; $values['titlu']=$r[1]; $values['text']=$r[2]; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['data']  = trim($_POST['data']  ?? '');
    $values['titlu'] = trim($_POST['titlu'] ?? '');
    $values['text']  = trim($_POST['text']  ?? '');
    if ($values['data']  === '') $errors['data']  = 'Trebuie introdusa data.';
    if ($values['titlu'] === '') $errors['titlu'] = 'Trebuie introdus titlul.';
    if ($values['text']  === '') $errors['text']  = 'Trebuie introdus textul.';

    if (empty($errors)) {
        $stmt = $con->prepare("UPDATE avizuri SET data=?, titlu=?, text=? WHERE ID_Aviz=?");
        $stmt->bind_param("sssi", $values['data'], $values['titlu'], $values['text'], $id);
        if ($stmt->execute()) { $_SESSION['tab']='Tabel3'; header("Location: Principala.php"); exit; }
    }
}
$con->close();
function e($s){return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Updatare Aviz</title>
    <?php include 'form_style.php'; ?>
    </head>
<body>
<div class="container">
    <a href="Principala.php" class="back">← Inapoi</a>
    <h2>📋 Updatare Aviz</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?=e($id)?>">
        <label>Data</label>
        <input type="date" name="data" value="<?=e($values['data'])?>">
        <?php if(!empty($errors['data'])): ?><div class="error"><?=e($errors['data'])?></div><?php endif; ?>
        <label>Titlu</label>
        <input type="text" name="titlu" value="<?=e($values['titlu'])?>" placeholder="Titlul avizului">
        <?php if(!empty($errors['titlu'])): ?><div class="error"><?=e($errors['titlu'])?></div><?php endif; ?>
        <label>Text</label>
        <textarea name="text" placeholder="Textul avizului..."><?=e($values['text'])?></textarea>
        <?php if(!empty($errors['text'])): ?><div class="error"><?=e($errors['text'])?></div><?php endif; ?>
        <button type="submit">Salveaza</button>
    </form>
</div> 
</body>
</html>
