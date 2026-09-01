<?php

require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";

$notifikasiHapus=null;

proteksi($_SESSION["role"], $_SESSION["user_id"]);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id']) && isset($_POST['nama_table'])){
    // $notifikasiHapus=$_POST['hapus_id'];
    $targetId=$_POST['hapus_id'];
    $targetTable=$_POST['nama_table'];



    $pengamanTable = ['users','konten_edukasi'];

    if(in_array($targetTable,$pengamanTable)){
        $suksesHapus = deleteData($koneksi, $targetId, $targetTable);
        if($suksesHapus){
            $notifikasiHapus = "Berhasil menghapus data";
        }else{
            $notifikasiHapus = "Gagal menghapus data";
        }

    }


}
// $dataUsersCount = array_filter(getAlldataUsers($koneksi), function ($user) {
// return $user['role'] !== 'admin';
// });

$dataCountSchedule = array_filter(getJadwalWithUser($koneksi), function ($schedule) {
    return $schedule;
});
// $dataCountDassResult = array_filter(getAllDataDass21($koneksi), function ($result) {
//     return $result;
// });

$dataCountPasien = array_filter(getUserWithDass($koneksi), function($user){
    return $user;
});

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/admin-handle.css">
    <title>Dashbord admin</title>
</head>
<body>
    <div class="dashboard_layout">
        <div class="main_content">
            <header>
                <div class="admin_desc">
                    <h1>Selamat pagi, Dr.<?= $_SESSION['user'] ?></h1>
                    <p>Monitor pasien dan jadwal pertemuan hari ini</p>
                </div>
                <div class="admin_profile">
                    <span class="material-icons">person icon</span>
                    <div class="profile-info">
                        <strong><?= $_SESSION['user'] ?> || <a href="/function/auth/logout.php">Logout</a> </strong>
                      
                    </div>
                </div>
            </header>

            <main>
                <!-- sesi manajemen user -->
                <section class="users-manajemen">
                    <!-- Bagian Judul dan Tombol Tambah User -->
                    <header class="section-header">
                        <h2 class="title-daftar">Daftar pasien</h2>
                        <?php
                            if(!is_null($notifikasiHapus)):
                        ?>
                            <p><?= $notifikasiHapus ?></p>
                        <?php
                        endif;
                        ?>

                        <a href="admin_tambahUser.php">
                            <button class="btn-tambah">Tambah User</button>
                        </a>
                    </header>

                    <!-- list user -->
                    <div class="users-list">

                        <?php foreach ($dataCountPasien as $user): ?>
                        <article class="user-card-row">
                                <div class="user-profile-info">
                                    <span class="material-icons avatar-icon">person</span>
                                    <div class="user-text">
                                        <strong><?= $user['pasien'] ?></strong>
                                        <span>Last DASS-21 * <?= $user['tanggal_pengisian'] ?></span>
                                    </div>
                                </div>
                            
                                <div class="user-actions">
                                    <span class="badge badge-aktif"><?= $user['kategori'] ?></span>
                                    <a href="<?= $user['id'] ?>">
                                        <button class="btn-edit">
                                            <span class="material-icons">
                                                Rekap
                                            </span> 
                                        </button>
                                    </a>
                                    <a href="dokter_detailPasien.php?id=<?= $user['user_id'] ?>">
                                        <button class="btn-edit">
                                            <span class="material-icons">
                                                Detail
                                            </span> 
                                        </button>
                                    </a>
                                    
                                    <!-- <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <input type="hidden" name="hapus_id" value="<?= $user['id']; ?>">
                                        <input type="hidden" name="nama_table" value="users">
                                        <button type="submit">Hapus</button>
                                    </form> -->
                                </div>
                        </article>
                        <?php endforeach;?>
                    </div>
                    <!-- end list user -->
                </section>


                <!-- sesi manajemen Jadwal -->
                <section class="manajemem-konten">
                    <header class="section-header">
                        <h2 class="title-daftar">Jadwal pertemuan</h2>
                        <a href="admin_tambahKonten.php">
                            <button class="btn-tambah">buat jadwal</button>
                        </a>
                    </header>

                    <div class="users-list">
                        <?php foreach ($dataCountSchedule as $jadwal): ?>
                        <article class="user-card-row">
                                <div class="user-profile-info">
                                    <span class="material-icons avatar-icon">jadwal</span>
                                    <div class="user-text">
                                        <strong><?= $jadwal['nama_pasien'] ?></strong>
                                        <span><?= $jadwal['tanggal_pertemuan'] ?></span>
                                        <span><?= $jadwal['status'] ?></span>
                                    </div>
                                </div>
                            
                                <div class="user-actions">
                                    <a href="<?= $jadwal['id'] ?>">
                                        <button class="btn-edit">
                                            <span class="material-icons">
                                                Edit
                                            </span>
                                        </button>
                                    </a>

                                    <!-- <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <input type="hidden" name="hapus_id" value="<?= $jadwal['id']; ?>">
                                        <input type="hidden" name="nama_table" value="konten_edukasi">
                                        <button type="submit">Hapus</button>
                                    </form> -->

                                </div>
                        </article>
                        <?php endforeach;?>
                    </div>

                </section>
                <!-- end manajemen jadwal -->
            </main>

        </div>

    </div>
    
</body>
</html>