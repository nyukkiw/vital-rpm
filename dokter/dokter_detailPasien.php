<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";


proteksi($_SESSION["role"], $_SESSION["user_id"]);

// $user = getDataById($koneksi, $_GET['id'])->fetch_assoc();

$user = getDataById($koneksi, 'users', $_GET['id'])->fetch_assoc();

$modifSukses = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $berhasilModifikasi = editUser($koneksi, $_POST, $user['id']);
    if($berhasilModifikasi){
        $modifSukses = "Modifikasi data berhasil";
    }else{
        $modifSukses = "Modifikasi data gagal";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail pasien</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <a href="dokter_dashboard.php">
                    <button>Kembali</button>
                </a>
                <h1>Detail Pasien</h1>
            </header>
            <main>
                   <section class="profil-pasien">
                    <div>
                        <h2><?= $user['name'] ?></h2>
                        <p><?= $user['jenis_kelamin'] ?></p>
                        <p><?= hitungUmur($user['tanggal_lahir']) ?></p>
                        <p><?= $user['alamat'] ?></p>
                    </div>
                    <div>
                        <p><?= $user['email'] ?></p>
                        <p><?= $user['phone'] ?></p>
                        <p><?= $user['alergi'] ?></p>
                    </div>
                        
                    </section>

                    <section class="rekam-medis">
                        <div>
                            <h2>Rekam Medis</h2>
                            <p><?= $user['no_rekam_medis'] ?></p>
                            <p><?= $user['name'] ?></p>
                            <p><?= $user['jenis_kelamin'] ?></p>
                            <p><?= hitungUmur($user['tanggal_lahir'] )?></p>
                            <p><?= $user['alamat'] ?></p>
                            <p><?= $user['phone'] ?></p>
                            <p><?= $user['alergi'] ?></p>
                        </div>
                        <div>
                            
                        </div>
                    </section>

                    <section class="skor-dass21">
                        <h2>Skor DASS-21</h2>
                        <!-- Skor Depresi, Kecemasan, Stres -->
                    </section>

                    <section class="grafik-mood">
                        <h2>Grafik Mood 7 Hari</h2>
                        <!-- chart -->
                    </section>

                    <section class="grafik-dass21-bulanan">
                        <h2>DASS-21 (Per Bulan)</h2>
                        <!-- chart -->
                    </section>

                    <section class="keluhan-pasien">
                        <h2>Keluhan Pasien</h2>
                        <!-- chart -->
                    </section>

                    <section class="catatan-pasien">
                        <h2>Catatan Pasien</h2>
                        <!-- chart -->
                    </section>
            </main>

        </div>
    </div>

</body>
</html>