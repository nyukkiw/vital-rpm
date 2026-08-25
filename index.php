<?php
// logika pesan error ambil dari login_logic.php
$pesanError="";
if(isset($_GET['error'])){
    if($_GET['error']=="kosong"){
        $pesanError="Username dan password tidak boleh kosong";
    }elseif($_GET['error']=="salah"){
        $pesanError="invalid username atau password"; 
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- login container -->
    <div class="login-container">
        <div class="header-card">
            <h1>
                Selamat Datang di
                Sistem Self-Monitoring Kesehatan Mental
            </h1>

            <!-- pesan error -->
            <?php if($pesanError): ?>
                <div class="error-message">
                    <p><?php echo $pesanError; ?></p>
                </div>
            <?php endif; ?>

        </div>
        <p>Silakan masuk untuk memantau kesehatan mental Anda.</p>
        <div class="login-form">
            <form method="POST" action="function/login_logic.php">
                <input type="text" name="userName" placeholder="Nama pengguna">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" id="loginButton">Masuk</button>
            </form>
        </div>

        
    </div>
<!-- end login container -->

</body>
</html>

