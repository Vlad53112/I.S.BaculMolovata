<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['logat']) || $_SESSION['logat'] !== true) {
    header("Location: login.php");
    exit;
}
?>
