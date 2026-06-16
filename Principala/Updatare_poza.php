<?php
require_once 'auth.php';
mb_internal_encoding('UTF-8');
$errors = [];
$values = ['link' => ''];
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
$uploadDir = __DIR__ . '/uploads/poze/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$con = new mysqli("localhost","root","","baculmolovata");
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id) {
    $r = $con->query("SELECT Link FROM poze WHERE ID_Poza=$id")->fetch_row();
    if ($r) $values['link'] = $r[0];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $linkPath = $_POST['link_existent'] ?? '';

    if (isset($_FILES['fisier']) && $_FILES['fisier']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['fisier']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif','webp','bmp'];
        if (!in_array($ext,$allowed)) { $errors['fisier']='Tip nepermis.'; }
        else {
            $dest = $uploadDir.uniqid('poza_',true).'.'.$ext;
            if (move_uploaded_file($_FILES['fisier']['tmp_name'], $dest)) {
                if ($linkPath && file_exists(__DIR__.'/'.$linkPath)) @unlink(__DIR__.'/'.$linkPath);
                $linkPath = 'Principala/uploads/poze/'.basename($dest);
            } else $errors['fisier']='Eroare upload.';
        }
    }

    if (empty($errors)) {
        $stmt = $con->prepare("UPDATE poze SET Link=? WHERE ID_Poza=?");
        $stmt->bind_param("si", $linkPath, $id);
        if ($stmt->execute()) { $_SESSION['tab']='Tabel4'; header("Location: Principala.php"); exit; }
    }
}
$con->close();
function e($s){return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8');}
?>
<!DOCTYPE html>
<html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Updatare Poza</title>
    <?php include 'form_style.php'; ?>
    </head>
<body>
<div class="container">
    <a href="Principala.php" class="back">← Inapoi</a>
    <h2>🖼️ Updatare Poza</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=e($id)?>">
        <input type="hidden" name="link_existent" value="<?=e($values['link'])?>">
        <?php if($values['link']): 
            $link = str_replace('Principala/', '', $values['link']);   
        ?>
        <div class="existing">
            Poza curenta:<br>
            <img src="<?=e($link)?>" style="max-width:100%;border-radius:7px;margin-top:6px;border:1px solid #ddd">
        </div>
        <?php endif; ?>
        <label>Poza noua <span class="opt">(lasati gol pentru a pastra)</span></label>
        <input type="file" name="fisier" id="fisierInput" accept=".png,.jpg,.jpeg,.gif,.webp,.bmp"
               onchange="previz(this)">
        <img id="preview" alt="Previzualizare">
        <?php if(!empty($errors['fisier'])): ?><div class="error"><?=e($errors['fisier'])?></div><?php endif; ?>
        <button type="submit">Salveaza</button>
    </form>
</div>
<script>
function previz(input){
    var p=document.getElementById('preview');
    if(input.files&&input.files[0]){
        var r=new FileReader();
        r.onload=function(e){p.src=e.target.result;p.style.display='block';};
        r.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>
