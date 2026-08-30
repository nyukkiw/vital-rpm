
<?php
session_start();
session_unset();    // hapus semua variabel $_SESSION
session_destroy();  // hancurkan session-nya total di server
header("Location: /index.php"); // pakai path absolut, sesuai bug yang barusan kita bahas
exit;

?>