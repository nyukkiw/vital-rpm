<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";



// proteksi($_SESSION["role"], $_SESSION["user_id"]);

// $user = getDataById($koneksi, $_GET['id'])->fetch_assoc();

$user = getDataById($koneksi, 'users', $_GET['id'])->fetch_assoc();
$userWithDass = getUserByIdWithDass($koneksi, $_GET['id']);
$userRiwayatTerapi = getUserRiwayatTerapi($koneksi, $_GET['id']);
$diagnosisTerbaru = end($userRiwayatTerapi);
// var_dump($diagnosisTerbaru);

$umurUser = hitungUmur($user['tanggal_lahir']);

// var_dump($userWithDass); 
// exit;
// header('Content-Type: application/json');
// echo json_encode($userWithDass);
// exit; 

// $error=null;
// if($userWithDass){
//     $error=$userWithDass['skor_depresi'] ?? null;
// }


// $catatanSukses = null;

// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//     $berhasilKirimCatatan = addCatatan($koneksi, $_POST, $userWithDass['user_id'], $_SESSION['user_id']);
//     if($berhasilKirimCatatan){
//         $catatanSukses = "Catatan berhasil dikirim";
//     }else{
//         $catatanSukses = "Gagal mengirim catatan";
//     }
// }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekap Pasien</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <a href="dokter_dashboard.php">
                    <button>Kembali</button>
                </a>
                <h1>Laporan Rekap Pasien</h1>
                <p><?= $user['status'] ?></p>
                
            </header>
            <main>
                <!-- informasi rekam medis -->
                   <section class="profil-rekap-pasien">
                    <div>
                        <p>foto profil</p>
                        <h2><?= $user['name'] ?></h2>
                        <p>Diagnosis: <?= $diagnosisTerbaru['diagnosis'] ?? 'Tidak ada diagnosis' ?></p>
                       
                    </div>                        
                    </section>
                   <section class="informasi-rekam-medis">
                    <div>
                        <h2>Informasi Rekam Medis</h2>
                        <p>No Rekam Medis: <?= $user['no_rekam_medis'] ?></p>
                        <p>Jenis Kelamin: <?= $user['jenis_kelamin'] ?></p>
                        <p>Umur: <?= $umurUser ?></p>
                    </div>                        
                    </section>
                <!-- end informasi rekam medis -->

                <!-- Ringkasan skor dass-21 terbaru -->
                    <section class="rekam-medis">
                        <div>
                            <h2>Ringkasan Skor DASS-21 Terbaru</h2>
                            <p>Depresi: <?= $userWithDass['skor_depresi'] ?? 'Tidak mengisi DASS-21' ?></p>
                            <p>Kecemasan: <?= $userWithDass['skor_kecemasan'] ?? 'Tidak mengisi DASS-21' ?></p>
                            <p>Stress: <?= $userWithDass['skor_stress'] ?? 'Tidak mengisi DASS-21' ?></p>
                        </div>
                    </section>
                <!-- End ringkasan skor dass-21 terbaru-->

                    <!-- Riwayat kunjungan terapi -->
                    <section class="riwayat-kunjungan-terapi">
                        <h2>Riwayat Kunjungan Terapi</h2>
                        <table class="table-riwayatKunjungan">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <?php if (empty($userRiwayatTerapi)): ?>
                                        <tr>
                                            <td>Belum ada kunjungan</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach($userRiwayatTerapi as $riwayat): ?>
                                            <tr>
                                                <td><?= $riwayat['tanggal_terapi'] ?? 'Tanggal tidak tercatat' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                            </tbody>

                        </table>
                        
                    </section>
                    <!-- end riwayat kunjungan -->

                    <!-- Riwayat catatan dokter -->
                    <!-- <section class="riwayat-kunjungan">
                        <h2>Riwayat Kunjungan</h2>
                        <table class="table-riwayatKunjungan">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Catatan Dokter</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($userRiwayatTerapi as $riwayat): ?>
                                    <tr>
                                        <td><?= $riwayat['tanggal_terapi'] ?></td>
                                        <td><?= $riwayat['catatan_dariDokter'] ?></td>
                                        <td><?= $riwayat['skor_dass21'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                        
                    </section> -->
                    <!-- end catatan dokter -->

                    <!-- Riwayat skor dass-21 -->
                    <!-- <section class="riwayat-kunjungan">
                        <h2>Riwayat Kunjungan</h2>
                        <table class="table-riwayatKunjungan">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Catatan Dokter</th>
                                    <th>Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($userRiwayatTerapi as $riwayat): ?>
                                    <tr>
                                        <td><?= $riwayat['tanggal_terapi'] ?></td>
                                        <td><?= $riwayat['catatan_dariDokter'] ?></td>
                                        <td><?= $riwayat['skor_dass21'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                        
                    </section> -->
                    <!-- end riwayat skor dass-21 -->

                    <!-- <section class="grafik-dass21-bulanan">
                        <h2>DASS-21 (Per Bulan)</h2>
                        <p>berupa chart</p>
                    </section>

                    <section class="keluhan-pasien">
                        <h2>Keluhan Pasien</h2>
                        <p>berupa chart</p>
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
                    </section> -->
            </main>

        </div>
    </div>

</body>
</html>