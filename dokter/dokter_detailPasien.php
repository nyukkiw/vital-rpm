<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";



// proteksi($_SESSION["role"], $_SESSION["user_id"]);

// $user = getDataById($koneksi, $_GET['id'])->fetch_assoc();

$user = getDataById($koneksi, 'users', $_GET['id'])->fetch_assoc();
$userWithDass = getUserByIdWithDass($koneksi, $_GET['id']);

// var_dump($userWithDass); 
// exit;
// header('Content-Type: application/json');
// echo json_encode($userWithDass);
// exit; 

// $error=null;
// if($userWithDass){
//     $error=$userWithDass['skor_depresi'] ?? null;
// }


$catatanSukses = null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $berhasilKirimCatatan = addCatatan($koneksi, $_POST, $userWithDass['user_id'], $_SESSION['user_id']);
    if($berhasilKirimCatatan){
        $catatanSukses = "Catatan berhasil dikirim";
    }else{
        $catatanSukses = "Gagal mengirim catatan";
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
                            <p>No rekam medis: <?= $user['no_rekam_medis'] ?></p>
                            <p>Nama: <?= $user['name'] ?></p>
                            <p>Jenis Kelamin: <?= $user['jenis_kelamin'] ?></p>
                            <p>Umur: <?= hitungUmur($user['tanggal_lahir'] )?></p>
                            <p>Alamat: <?= $user['alamat'] ?></p>
                            <p>No Telepon: <?= $user['phone'] ?></p>
                            <p>Alergi: <?= $user['alergi'] ?></p>
                        </div>
                        <div>
                            <p>Diagnosa: </p>
                            <p>Tanggal kunjungan:</p>
                        </div>
                    </section>

                    <section class="skor-dass21">
                        <h2>Skor DASS-21</h2>
                        <p>Skor Depresi: <?= $userWithDass['skor_depresi'] ?></p>
                        <p>Skor Kecemasan: <?= $userWithDass['skor_kecemasan'] ?></p>
                        <p>Skor Stress: <?= $userWithDass['skor_stress'] ?></p>
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
                        <?php
                            if(!is_null($catatanSukses)):
                        ?>
                            <p><?= $catatanSukses ?></p>
                        <?php endif;?>
                        <form action="" method="POST">
                            <input type="text" name="catatan_dariDokter" placeholder="Berikan catatan kepada pasien">
                            <button type="submit">Simpan Catatan</button>
                        </form>
                    </section>
            </main>

        </div>
    </div>

</body>
</html>