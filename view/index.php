<?php
$title = "Dashboard";
ob_start();
?>

    <p>Ini adalah paragraf di halaman index.</p>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/template.php';
?>