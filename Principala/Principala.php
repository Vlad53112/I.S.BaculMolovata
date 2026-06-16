<?php
require_once 'auth.php';
if (isset($_GET['logout'])) { session_destroy(); header("Location: login.php"); exit; }

$con = new mysqli("localhost","root","","baculmolovata");
if($con->connect_error) die("Eroare conectare: ".$con->connect_error);

if(isset($_POST['stergere1'])) {
    $con->query("DELETE FROM achizitie WHERE ID_Achizitie=".intval($_POST['id']));
    $_SESSION['tab']='Tabel1'; header("Location: Principala.php"); exit;
}
if(isset($_POST['stergere2'])) {
    $id=intval($_POST['id']);
    $r=$con->query("SELECT Link FROM actenormative WHERE ID_ActNormativ=$id")->fetch_row();
    if($r && $r[0] && file_exists(__DIR__.'/'.$r[0])) @unlink(__DIR__.'/'.$r[0]);
    $con->query("DELETE FROM actenormative WHERE ID_ActNormativ=$id");
    $_SESSION['tab']='Tabel2'; header("Location: Principala.php"); exit;
}
if(isset($_POST['stergere3'])) {
    $con->query("DELETE FROM avizuri WHERE ID_Aviz=".intval($_POST['id']));
    $_SESSION['tab']='Tabel3'; header("Location: Principala_nou.php"); exit;
}
if(isset($_POST['stergere4'])) {
    $id=intval($_POST['id']);
    $r=$con->query("SELECT Link FROM poze WHERE ID_Poza=$id")->fetch_row();
    if($r && $r[0] && file_exists(__DIR__.'/'.$r[0])) @unlink(__DIR__.'/'.$r[0]);
    $con->query("DELETE FROM poze WHERE ID_Poza=$id");
    $_SESSION['tab']='Tabel4'; header("Location: Principala.php"); exit;
}
if(isset($_POST['stergere5'])) {
    $id=intval($_POST['id']);
    $r=$con->query("SELECT Link FROM rapoarte WHERE ID_Rapoarte=$id")->fetch_row();
    if($r && $r[0] && file_exists(__DIR__.'/'.$r[0])) @unlink(__DIR__.'/'.$r[0]);
    $con->query("DELETE FROM rapoarte WHERE ID_Rapoarte=$id");
    $_SESSION['tab']='Tabel5'; header("Location: Principala.php"); exit;
}
if(isset($_POST['stergere6'])) {
    $con->query("DELETE FROM recenzii WHERE ID_recenzii=".intval($_POST['id']));
    $_SESSION['tab']='Tabel6'; header("Location: Principala.php"); exit;
}

$tabActiv = $_SESSION['tab'] ?? 'Tabel1';
unset($_SESSION['tab']);

function rows($con,$sql){ $r=$con->query($sql); return $r?$r->fetch_all(MYSQLI_NUM):[]; }
function he($s){ return htmlspecialchars($s??'',ENT_QUOTES,'UTF-8'); }
function btns($sname,$id,$upd_page){
    return "
    <td>
        <form method='POST' onsubmit=\"return confirm('Sigur doresti sa stergi?');\">
        <input type='hidden' name='id' value='$id'>
        <input type='submit' name='$sname' value='Stergere'>
        </form>
    </td>
    <td>
        <form action='$upd_page' method='get'>
        <input type='hidden' name='id' value='$id'>
        <input type='submit' name='updat' value='Update'>
        </form>
    </td>";
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Bacul Molovata – Administrare</title>
<style>
*{ box-sizing:border-box; margin:0; padding:0; }
body{
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #eef2f7;
    color: #222;
    min-height: 100vh;
}
.header{
    background: linear-gradient(90deg,#1a3a6e 0%,#2e5fbf 100%);
    color:#fff;
    padding: 14px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0,0,0,.18);
}
.header h1{ 
    font-size:22px; 
    font-weight:700; 
    letter-spacing:.5px; 
}
.header .user{ 
    font-size:13px; 
    display:flex; 
    align-items:center; 
    gap:12px; 
}
.btn-logout{
    background:#e74c3c; 
    color:#fff; 
    padding:6px 16px;
    border-radius:5px; 
    text-decoration:none; 
    font-size:13px; 
    font-weight:600;
    transition:background .2s;
}
.btn-logout:hover{ 
    background:#c0392b; 
}
.layout{
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 18px;
    padding: 20px 24px;
    height: calc(100vh - 54px);
}
.sidebar{
    background: #fff;
    border-radius: 12px;
    padding: 16px 12px;
    box-shadow: 0 4px 14px rgba(0,0,0,.07);
    display: flex;
    flex-direction: column;
    gap: 6px;
    overflow-y: auto;
}
.sidebar h3{
    font-size:12px; 
    text-transform:uppercase; 
    letter-spacing:1px;
    color:#999; 
    margin-bottom:8px; 
    padding-left:6px;
}
.sidebar button{
    width: 100%;
    text-align: left;
    padding: 10px 14px;
    border: none;
    border-radius: 8px;
    background: transparent;
    font-size: 14px;
    font-weight: 500;
    color: #334;
    cursor: pointer;
    transition: background .15s, color .15s;
}
.sidebar button:hover{ 
    background:#eef4ff; 
    color:#1a3a6e; 
}
.sidebar button.activ{
    background: #1a3a6e;
    color: #fff;
    font-weight: 700;
}
.main{
    background: #fff;
    border-radius: 12px;
    padding: 22px 24px;
    box-shadow: 0 4px 14px rgba(0,0,0,.07);
    overflow: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.main-header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #eef2f7;
    padding-bottom: 12px;
}
.main-header h2{ 
    font-size:20px; 
    color:#1a3a6e; 
}
.btn-insert{
    background: #27ae60;
    color: #fff;
    padding: 9px 20px;
    border: none;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background .2s;
}
.btn-insert:hover{ 
    background:#1e8449; 
}
table{
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
th{
    background: #1a3a6e;
    color: #fff;
    padding: 10px 12px;
    text-align: left;
    white-space: nowrap;
    font-weight: 600;
}
th:first-child{ 
    border-radius:6px 0 0 0; 
}
th:last-child{ 
    border-radius:0 6px 0 0; 
}
td{
    padding: 9px 12px;
    border-bottom: 1px solid #eef2f7;
    vertical-align: middle;
}
tbody tr:hover{ 
    background:#f5f8ff; 
}
.td-act{ 
    white-space:nowrap; 
}
.btn-del, .btn-upd{
    border: none; 
    padding: 5px 13px; 
    border-radius: 5px;
    cursor: pointer; 
    font-size: 12px; 
    font-weight: 600;
    transition: background .15s;
}
.btn-del{ 
    background:#e74c3c; 
    color:#fff; 
}
.btn-del:hover{ 
    background:#c0392b; 
}
.btn-upd{ 
    background:#2980b9; 
    color:#fff; 
}
.btn-upd:hover{ 
    background:#1f6391; 
}
.stele{ 
    color:#f39c12; 
    font-size:16px; 
    letter-spacing:1px; 
}
.empty{ 
    text-align:center; 
    color:#aaa; 
    padding:40px 0; 
    font-size:15px; 
}
</style>
</head>
<body>
<div class="header">
    <h1>🏛️ I.S.Bacul Molovata</h1>
    <div class="user">
        <span>Logat ca: <b><?= he($_SESSION['utilizator']??'admin') ?></b></span>
        <a href="Updatare_cont.php" style="background:#2e5fff;color:#fff;padding:6px 16px;border-radius:5px;text-decoration:none;font-size:13px;font-weight:600;">
            ✏️ Cont
        </a>
        <a href="?logout=1" class="btn-logout">Delogare</a>
    </div>
</div>
<div class="layout">
    <div class="sidebar">
        <h3>Tabele</h3>
        <?php
        $tabele = [
            'Tabel1' => '📦 Achizitii',
            'Tabel2' => '📄 Acte Normative',
            'Tabel3' => '📋 Avizuri',
            'Tabel4' => '🖼️ Poze',
            'Tabel5' => '📊 Rapoarte',
            'Tabel6' => '⭐ Recenzii',
        ];
        foreach($tabele as $tid=>$tlabel){
            $cls=($tid===$tabActiv)?'activ':'';
            echo "<button class='$cls' onclick=\"arataTabel('$tid')\">$tlabel</button>";
        }
        ?>
    </div>
    <div class="main">
        <div id="Tabel1" class="tpanel">
            <div class="main-header">
                <h2>📦 Achizitii</h2>
                <a href="Inserare_achizitie.php" class="btn-insert">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Data</th><th>Titlu</th><th>Link</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_Achizitie,data,Titlu,Link FROM achizitie");
                if($rows): foreach($rows as $r): 
                    $link = str_replace('Principala/', '', $r[3]);
                ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?=he($r[1])?></td>
                    <td><?=he($r[2])?></td>
                    <td><?= $r[3] ? "<a href='".he($link)."' target='_blank'>Deschide</a>" : '-' ?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere1' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_achizitie.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="Tabel2" class="tpanel">
            <div class="main-header">
                <h2>📄 Acte Normative</h2>
                <a href="Inserare_actnormativ.php" class="btn-insert">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Data</th><th>Titlu</th><th>Document</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_ActNormativ,data,Titlu,Link FROM actenormative");
                if($rows): foreach($rows as $r): 
                    $link = str_replace('Principala/', '', $r[3]);
                ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?=he($r[1])?></td>
                    <td><?=he($r[2])?></td>
                    <td><?= $r[3] ? "<a href='".he($link)."' target='_blank'>📎 Deschide</a>" : '-' ?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere2' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_actnormativ.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="Tabel3" class="tpanel">
            <div class="main-header">
                <h2>📋 Avizuri</h2>
                <a href="Inserare_aviz.php" class="btn-insert">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Data</th><th>Titlu</th><th>Text</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_Aviz,data,titlu,text FROM avizuri");
                if($rows): foreach($rows as $r): ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?=he($r[1])?></td>
                    <td><?=he($r[2])?></td>
                    <td><?=he(mb_substr($r[3]??'',0,90)).(mb_strlen($r[3]??'')>90?'…':'')?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere3' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_aviz.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="Tabel4" class="tpanel">
            <div class="main-header">
                <h2>🖼️ Poze</h2>
                <a href="Inserare_poza.php" class="btn-insert">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Previzualizare</th><th>Cale fisier</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_Poza,Link FROM poze");
                if($rows): foreach($rows as $r): 
                    $link = str_replace('Principala/', '', $r[1]);
                ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?= $r[1] ? "<img src='".he($link)."' width='80' height='60' style='object-fit:cover;border-radius:5px;border:1px solid #ddd'>" : '-' ?></td>
                    <td style="font-size:12px;color:#666;max-width:200px;word-break:break-all"><?=he($r[1])?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere4' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_poza.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="Tabel5" class="tpanel">
            <div class="main-header">
                <h2>📊 Rapoarte</h2>
                <a href="Inserare_raport.php" class="btn-insert">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Data</th><th>Titlu</th><th>Document</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_Rapoarte,data,Titlu,Link FROM rapoarte");
                if($rows): foreach($rows as $r): 
                    $link = str_replace('Principala/', '', $r[3]);
                ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?=he($r[1])?></td>
                    <td><?=he($r[2])?></td>
                    <td><?= $r[3] ? "<a href='".he($link)."' target='_blank'>📎 Deschide</a>" : '-' ?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere5' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_raport.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="5" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div id="Tabel6" class="tpanel">
            <div class="main-header">
                <h2>⭐ Recenzii</h2>
                <a href="Inserare_recenzie.php" class="btn-insert" style="opacity:0;pointer-events:none;">+ Inserare</a>
            </div>
            <table>
                <thead><tr>
                    <th>#</th><th>Data</th><th>Nume</th><th>Stele</th><th>Text</th><th colspan="2">Actiuni</th>
                </tr></thead>
                <tbody>
                <?php $rows=rows($con,"SELECT ID_recenzii,data,nume,stele,text FROM recenzii");
                if($rows): foreach($rows as $r): ?>
                <tr>
                    <td><?=he($r[0])?></td>
                    <td><?=he($r[1])?></td>
                    <td><?=he($r[2])?></td>
                    <td class="stele"><?=str_repeat('★',(int)$r[3]).str_repeat('☆',5-(int)$r[3])?></td>
                    <td><?=he(mb_substr($r[4]??'',0,90)).(mb_strlen($r[4]??'')>90?'…':'')?></td>
                    <td class="td-act">
                        <form method='POST' style='display:inline' onsubmit="return confirm('Sigur doresti sa stergi?');">
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='stergere6' class='btn-del' value='Stergere'>
                        </form>
                    </td>
                    <td class="td-act">
                        <form action='Updatare_recenzie.php' method='get' style='display:inline'>
                            <input type='hidden' name='id' value='<?=he($r[0])?>'>
                            <input type='submit' name='updat' class='btn-upd' value='Update' style='opacity:0;pointer-events:none;'>
                        </form>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="7" class="empty">Nu exista inregistrari.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>
var tabele = <?= json_encode(array_keys($tabele)) ?>;
var titluri = <?= json_encode($tabele) ?>;
function arataTabel(id) {
    tabele.forEach(function(t) {
        var el = document.getElementById(t);
        if (el) el.style.display = 'none';
    });
    var el = document.getElementById(id);
    if (el) el.style.display = 'block';

    document.querySelectorAll('.sidebar button').forEach(function(btn, i) {
        btn.classList.toggle('activ', tabele[i] === id);
    });
}
arataTabel('<?= $tabActiv ?>');
</script>
</body>
</html>
