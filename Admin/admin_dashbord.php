<?php

require_once __DIR__ . "/../function/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth_cek.php";



proteksi($_SESSION["role"], $_SESSION["user_id"]);

$dataUsersCount = getAlldataUsers($koneksi);
$semuaDataKonten = getAlldataContent($koneksi);

$dataCountPasien = array_filter($dataUsersCount, function($user){
    return $user['role'] === 'pasien';
});

$dataCountDokter = array_filter($dataUsersCount, function($user){
    return $user['role'] === 'dokter';
});

$dataAkunAktif= array_filter($dataUsersCount, function($user){
    return $user['status'] === 'aktif';
});

$dataNonAktifAcc= array_filter($dataUsersCount, function($user){
    return $user['status'] === 'tidak aktif';
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
                    <h1>Selamat pagi, <?= $_SESSION['user'] ?></h1>
                    <p>Kelola pengguna, konten edukasi, dan database dengan mudah</p>
                </div>
                <div class="admin_profile">
                    <span class="material-icons">person icon</span>
                    <div class="profile-info">
                        <strong><?= $_SESSION['user'] ?></strong>
                      
                    </div>
                </div>
            </header>

            <main>

                <!-- sesi pantau statistik -->
                <section class="statistik-section">
                   <header>
                    <h2>Statistik</h2>
                    <div class="db-status">
                       <span class="material-icons">
                        database
                       </span> 
                    </div>
                   </header>
                   
                   <div class="cards-grid">

                        <article class="stat-card">
                            <div class="card-icon icon-patients">
                                <span class="material-icons">groups</span>
                            </div>
                            <div class="card-info">
                                <span class="card-label">Total Pasien</span>
                                <strong class="card-number"> <?=count($dataCountPasien) ?> </strong>
                            </div>
                        </article>

                        <article class="stat-card">
                            <div class="card-icon icon-patients">
                                <span class="material-icons">medical</span>
                            </div>
                            <div class="card-info">
                                <span class="card-label">Total Dokter</span>
                                <strong class="card-number"> <?=count($dataCountDokter) ?> </strong>
                            </div>
                        </article>

                        <article class="stat-card">
                             <div class="card-icon icon-patients">
                                <span class="material-icons">active acc</span>
                            </div>
                            <div class="card-info">
                                <span class="card-label">Akun aktif</span>
                                <strong class="card-number"> <?=count($dataAkunAktif) ?> </strong>
                            </div>
                        </article>

                        <article class="stat-card">
                            <div class="card-icon icon-patients">
                                <span class="material-icons">inactive acc</span>
                            </div>
                            <div class="card-info">
                                <span class="card-label">Akun tidak aktif</span>
                                <strong class="card-number"> <?=count($dataNonAktifAcc) ?> </strong>
                            </div>
                        </article>

                        </article>

                        <article class="stat-card">
                            <div class="card-icon icon-patients">
                                    <span class="material-icons">Konten</span>
                                </div>
                                <div class="card-info">
                                    <span class="card-label">Jumlah konten</span>
                                    <strong class="card-number"> <?=count($semuaDataKonten) ?> </strong>
                                </div>
                        </article>

                        <article class="stat-card">

                        </article>

                   </div>

                </section>

                <!-- sesi manajemen user -->
                <section class="users-manajemen">
                    <!-- Bagian Judul dan Tombol Tambah User -->
                    <header class="section-header">
                        <h2 class="title-daftar">Daftar User</h2>
                        <a href="admin_tambahUser.php">
                            <button class="btn-tambah">Tambah User</button>
                        </a>
                    </header>

                    <!-- list user -->
                    <div class="users-list">

                        <?php foreach ($dataUsersCount as $user): ?>
                        <article class="user-card-row">
                                <div class="user-profile-info">
                                    <span class="material-icons avatar-icon">person</span>
                                    <div class="user-text">
                                        <strong><?= $user['name'] ?></strong>
                                        <span><?= $user['role'] ?></span>
                                    </div>
                                </div>
                            
                                <div class="user-actions">
                                    <span class="badge badge-aktif"><?= $user['status'] ?></span>
                                    <a href="admin_editUser.php?id=<?= $user['id'] ?>">
                                        <button class="btn-edit">
                                            <span class="material-icons">
                                                edit
                                            </span> 
                                        </button>
                                    </a>
                                    
                                    <button class="btn-hapus">
                                        <span class="material-icons">
                                            delete
                                        </span> 
                                    </button>
                                </div>
                        </article>
                        <?php endforeach;?>
                    </div>
                    <!-- end list user -->
                </section>


                <!-- sesi manajemen konten -->
                <section class="manajemem-konten">
                    <header class="section-header">
                        <h2 class="title-daftar">Konten edukasi</h2>
                        <a href="admin_tambahKonten.php">
                            <button class="btn-tambah">Tambah konten</button>
                        </a>
                    </header>

                    <div class="users-list">
                        <?php foreach ($semuaDataKonten as $konten): ?>
                        <article class="user-card-row">
                                <div class="user-profile-info">
                                    <span class="material-icons avatar-icon">thumbnail</span>
                                    <div class="user-text">
                                        <strong>Judul: <?= $konten['judul'] ?></strong>
                                        <span>publish: <?= $konten['created_at'] ?></span>
                                        <span>Link: <?= $konten['link'] ?></span>
                                    </div>
                                </div>
                            
                                <div class="user-actions">
                                    <button class="btn-edit"><span class="material-icons">edit</span> </button>
                                    <button class="btn-hapus"><span class="material-icons">delete</span> </button>
                                </div>
                        </article>
                        <?php endforeach;?>
                    </div>

                </section>


            </main>

        </div>

    </div>
    
</body>
</html>