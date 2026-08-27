<?php
require_once __DIR__ . "/../function/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth_cek.php";

proteksi($_SESSION["role"], $_SESSION["user_id"]);

$user = getDataById($koneksi, $_GET['id'])->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin - edit user</title>
</head>
<body>
    <p>ini halaman edit user: <?= $user['name'] ?> dengan id: <?= $user['id'] ?></p>
</body>
</html>