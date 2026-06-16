<?php
// Call setActiv('PageName') before including this file
// e.g.: setActiv('Achizitie');
if (!function_exists('setActiv')) {
    function setActiv($page) {
        $GLOBALS['_activPage'] = $page;
    }
}
$activPage = $GLOBALS['_activPage'] ?? '';
function navLink($href, $label, $slug) {
    global $activPage;
    $cls = ($activPage === $slug) ? ' class="activ"' : '';
    echo "<li><a href=\"{$href}\"{$cls}>{$label}</a></li>";
}
function navLinkD($href, $label, $slug) {
    global $activPage;
    $cls = ($activPage === $slug) ? ' class="activ"' : '';
    echo "<a href=\"{$href}\"{$cls}>{$label}</a>";
}
?>
<header id="mainHeader" class="expanded">
    <div class="header-top">
        <div class="logo-area">
            <img src="Stema-removebg-preview.png" alt="Logo">
            <span>ÎNTREPRINDERE DE STAT<br>BACUL MOLOVATA</span>
        </div>
        <div class="nav-dropdown" id="navDropdown">
            <button class="nav-dropdown-btn" id="dropdownBtn">
                ☰ Navigare <span class="arrow">▼</span>
            </button>
            <div class="nav-dropdown-menu" id="dropdownMenu">
                <?php navLinkD('Principala.php', 'Pagina Principală', 'Principala'); ?>
                <?php navLinkD('DespreNoi.php', 'Despre Noi', 'DespreNoi'); ?>
                <?php navLinkD('Noutati.php', 'Noutăți', 'Noutati'); ?>
                <?php navLinkD('ActeNormative.php', 'Acte Normative', 'ActeNormative'); ?>
                <?php navLinkD('Achizitie.php', 'Achiziție', 'Achizitie'); ?>
                <?php navLinkD('Rapoarte.php', 'Rapoarte', 'Rapoarte'); ?>
                <?php navLinkD('Avizuri.php', 'Avizuri', 'Avizuri'); ?>
            </div>
        </div>
    </div>
    <div class="header-nav" id="navExpanded">
        <nav>
            <ul id="menuExpanded">
                <?php navLink('Principala.php', 'Pagina Principală', 'Principala'); ?>
                <?php navLink('DespreNoi.php', 'Despre Noi', 'DespreNoi'); ?>
                <?php navLink('Noutati.php', 'Noutăți', 'Noutati'); ?>
                <?php navLink('ActeNormative.php', 'Acte Normative', 'ActeNormative'); ?>
                <?php navLink('Achizitie.php', 'Achiziție', 'Achizitie'); ?>
                <?php navLink('Rapoarte.php', 'Rapoarte', 'Rapoarte'); ?>
                <?php navLink('Avizuri.php', 'Avizuri', 'Avizuri'); ?>
            </ul>
        </nav>
    </div>
</header>

<script>
(function() {
    const header      = document.getElementById('mainHeader');
    const navExpanded = document.getElementById('navExpanded');
    const navDropdown = document.getElementById('navDropdown');
    const dropdownBtn = document.getElementById('dropdownBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    function updateHeader() {
        const isMobile = window.innerWidth <= 900;
        const scrolled = window.scrollY > 60;
        if (scrolled) {
            header.classList.remove('expanded');
            header.classList.add('compact');
            navExpanded.style.display = 'none';
            navDropdown.style.display = 'block';
        } else {
            header.classList.remove('compact');
            header.classList.add('expanded');
            navExpanded.style.display = isMobile ? 'none' : 'flex';
            navDropdown.style.display = isMobile ? 'block' : 'none';
        }
    }

    window.addEventListener('scroll', updateHeader);
    window.addEventListener('resize', function() {
        dropdownMenu.style.display = 'none';
        updateHeader();
    });
    updateHeader();

    dropdownBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = dropdownMenu.style.display === 'block';
        dropdownMenu.style.display = isOpen ? 'none' : 'block';
        dropdownBtn.querySelector('.arrow').style.transform = isOpen ? '' : 'rotate(180deg)';
    });
    document.addEventListener('click', function() {
        dropdownMenu.style.display = 'none';
        dropdownBtn.querySelector('.arrow').style.transform = '';
    });
})();
</script>
