<?php
require_once 'auth.php';
mb_internal_encoding('UTF-8');
$errors = [];
$values = ['data' => '', 'link' => '', 'titlu' => ''];
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
$uploadDir = __DIR__ . '/uploads/actenormative/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$con = new mysqli("localhost","root","","baculmolovata");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
    $r = $con->query("SELECT data, titlu, Link FROM actenormative WHERE ID_ActNormativ=$id")->fetch_row();
    if ($r) { $values['data']=$r[0]; $values['titlu']=$r[1]; $values['link']=$r[2]; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['data'] = trim($_POST['data'] ?? '');
    $values['titlu'] = trim($_POST['titlu'] ?? '');
    $linkPath = $_POST['link_existent'] ?? '';
    if ($values['data'] === '') $errors['data'] = 'Trebuie introdusa data.';
    if ($values['titlu'] === '') $errors['titlu'] = 'Trebuie introdus titlul.';

    if (isset($_FILES['fisier']) && $_FILES['fisier']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['fisier']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf','doc','docx','xls','xlsx','txt'];
        if (!in_array($ext,$allowed)) { $errors['fisier']='Tip nepermis.'; }
        else {
            $dest = $uploadDir.uniqid('act_',true).'.'.$ext;
            if (move_uploaded_file($_FILES['fisier']['tmp_name'], $dest)) {
                if ($linkPath && file_exists(__DIR__.'/'.$linkPath)) @unlink(__DIR__.'/'.$linkPath);
                $linkPath = 'Principala/uploads/actenormative/'.basename($dest);
            } else $errors['fisier']='Eroare upload.';
        }
    }

    if (empty($errors)) {
        $stmt = $con->prepare("UPDATE actenormative SET data=?, titlu=?, Link=? WHERE ID_ActNormativ=?");
        $stmt->bind_param("sssi", $values['data'], $values['titlu'], $linkPath, $id);
        if ($stmt->execute()) { $_SESSION['tab']='Tabel2'; header("Location: Principala.php"); exit; }
    }
}
$con->close();
function e($s){return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Updatare Act Normativ</title>
    <?php include 'form_style.php'; ?>
    </head>
<body>
<div class="container">
    <a href="Principala.php" class="back">← Inapoi</a>
    <h2>📄 Updatare Act Normativ</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=e($id)?>">
        <input type="hidden" name="link_existent" value="<?=e($values['link'])?>">
        <label>Data</label>
        <input type="date" name="data" value="<?=e($values['data'])?>">
        <?php if(!empty($errors['data'])): ?><div class="error"><?=e($errors['data'])?></div><?php endif; ?>
        <label>Titlu</label>
        <input type="text" name="titlu" value="<?=e($values['titlu'])?>"> 
        <?php if(!empty($errors['titlu'])): ?><div class="error"><?=e($errors['titlu'])?></div><?php endif; ?>
        <?php if($values['link']): 
        $link = str_replace('Principala/', '', $values['link']);        
        ?>
        <div class="existing">Document curent: <a href="<?=e($link)?>" target="_blank">📎 Deschide</a></div>
        <?php endif; ?>
        <label>Document nou <span class="opt">(lasati gol pentru a pastra)</span></label>
        <input type="file" name="fisier" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt">
        <?php if(!empty($errors['fisier'])): ?><div class="error"><?=e($errors['fisier'])?></div><?php endif; ?>
        <button type="submit">Salveaza</button>
    </form>
</div>
</body>
</html>
