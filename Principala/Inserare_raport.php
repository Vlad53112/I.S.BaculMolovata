<?php
require_once 'auth.php';
mb_internal_encoding('UTF-8');
$errors = [];
$values = ['data' => '','titlu' => ''];
$uploadDir = __DIR__ . '/uploads/rapoarte/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['data'] = trim($_POST['data'] ?? '');
    $values['titlu'] = trim($_POST['titlu'] ?? '');
    if ($values['data'] === '') $errors['data'] = 'Trebuie introdusa data.';
    if ($values['titlu'] === '') $errors['titlu'] = 'Trebuie introdus titlul.';

    $linkPath = '';
    if (isset($_FILES['fisier']) && $_FILES['fisier']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['fisier']['name'], PATHINFO_EXTENSION));
        $allowed = ['pdf','doc','docx','xls','xlsx','txt'];
        if (!in_array($ext,$allowed)) { $errors['fisier']='Tip nepermis.'; }
        else {
            $dest = $uploadDir.uniqid('rap_',true).'.'.$ext;
            if (move_uploaded_file($_FILES['fisier']['tmp_name'], $dest))
                $linkPath = 'Principala/uploads/rapoarte/'.basename($dest);
            else $errors['fisier']='Eroare upload.';
        }
    }

    if (empty($errors)) {
        $con = new mysqli("localhost","root","","baculmolovata");
        $stmt = $con->prepare("INSERT INTO rapoarte (data, Titlu, Link) VALUES (?,?,?)");
        $stmt->bind_param("sss", $values['data'], $values['titlu'], $linkPath);
        if ($stmt->execute()) { $_SESSION['tab']='Tabel5'; header("Location: Principala.php"); exit; }
        $con->close();
    }
}
function e($s){return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Inserare Raport</title>
    <?php include 'form_style.php'; ?>
    </head>
<body>
<div class="container">
    <a href="Principala.php" class="back">← Inapoi</a>
    <h2>📊 Inserare Raport</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Data</label>
        <input type="date" name="data" value="<?=e($values['data'])?>">
        <?php if(!empty($errors['data'])): ?><div class="error"><?=e($errors['data'])?></div><?php endif; ?>
        <label>Titlu</label>
        <input type="text" name="titlu" value="<?=e($values['titlu'])?>" placeholder="Titlul avizului">
        <?php if(!empty($errors['titlu'])): ?><div class="error"><?=e($errors['titlu'])?></div><?php endif; ?>
        <label>Document <span class="opt">(PDF, DOC, DOCX, XLS, XLSX, TXT)</span></label>
        <input type="file" name="fisier" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt">
        <?php if(!empty($errors['fisier'])): ?><div class="error"><?=e($errors['fisier'])?></div><?php endif; ?>
        <button type="submit">Salveaza</button>
    </form>
</div> 
</body>
</html>
