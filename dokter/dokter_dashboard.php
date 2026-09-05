<?php

require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";

$notifikasiHapus=null;

// proteksi($_SESSION["role"], $_SESSION["user_id"]);

$notifikasiHapus=null;
$tambahJadwal=null;
$modifJadwal=null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if( isset($_POST['pasien_id']) && isset($_POST['status_jadwal']) && isset($_POST['tanggal_pertemuan'])){
        $berhasilTambahJadwal = addJadwalPasien($koneksi, $_POST, $_SESSION['user_id']);
        if($berhasilTambahJadwal){
            $tambahJadwal = "Berhasil menambahkan jadwal";
        }else{
            $tambahJadwal = "Gagal menambahkan jadwal";
        }
    }

    if(isset($_POST['tanggal_pertemuan']) && isset($_POST['status_jadwal']) && isset($_POST['jadwal_id'])){
        
        $berhasilModifikasiJadwal = editJadwalPasien($koneksi, $_POST, $_POST['jadwal_id']);
        if($berhasilModifikasiJadwal){
            $modifJadwal = "Berhasil mengubah jadwal";
        }else{
            $modifJadwal = "Gagal mengubah jadwal";
        }
    }


    if( isset($_POST['hapus_id']) && isset($_POST['nama_table'])){
        $pengamanTable ='jadwal_kontrol';
        if($_POST['nama_table'] !== $pengamanTable){
            $notifikasiHapus = "Gagal menghapus data, nama table tidak sesuai";
            exit;
        }else{
            $berhasilHapus=deleteData($koneksi, $_POST['hapus_id'], $_POST['nama_table']);
            if($berhasilHapus){
                $notifikasiHapus = "Berhasil menghapus data";
            }else{
                $notifikasiHapus = "Gagal menghapus data";
            }
        }
    }




  


}
// $dataUsersCount = array_filter(getAlldataUsers($koneksi), function ($user) {
// return $user['role'] !== 'admin';
// });

$dataCountSchedule = array_filter(getJadwalWithUser($koneksi), function ($schedule) {
    return $schedule;
});

$dataAllUsers = array_filter(getAlldataUsers($koneksi), function ($user) {
    return $user['role'] !== 'dokter' && $user['role'] !== 'admin';
});
// $dataCountDassResult = array_filter(getAllDataDass21($koneksi), function ($result) {
//     return $result;
// });

$dataCountPasienDass = array_filter(getUserWithDass($koneksi), function($user){
    return $user;
});

// var_dump($dataCountPasienDass);
// var_dump($dataAllUsers);

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
                    <!-- LIST USER -->
                    <div class="section-header">
                        <h2 class="title-daftar">Daftar Pasien Dengan DASS-21</h2>
                    </div>
                    
                    <div class="users-list">
                        <?php foreach ($dataAllUsers as $user): ?>
                            <?php
                                if(getUserByIdWithDass($koneksi, $user['id'])): 
                            ?>
                                <article class="user-card-row">
                                        <div class="user-profile-info">
                                            <span class="material-icons avatar-icon">person</span>
                                            <div class="user-text">
                                                <strong><?= $user['name'] ?></strong>
                                                <p>Last DASS-21 * <?= getUserByIdWithDass($koneksi, $user['id'])['tanggal_pengisian'] ?? 'Tanggal tidak tercatat' ?></p>
                                            </div>
                                        </div>
                                    
                                        <div class="user-actions">
                                            <a href="dokter_rekapOnePasien.php?id=<?= $user['id'] ?>">
                                                <button class="btn-edit">
                                                    <span class="material-icons">
                                                        Rekap
                                                    </span> 
                                                </button>
                                            </a>
                                            <a href="dokter_detailPasien.php?id=<?= $user['id'] ?>">
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
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>

                    <div class="section-header">
                        <h2 class="title-daftar">Daftar Pasien Tanpa DASS-21</h2>
                    </div>
                    <div class="users-list">
                        <?php foreach ($dataAllUsers as $user): ?>
                            <?php 
                                if(!getUserByIdWithDass($koneksi, $user['id'])): 
                            ?>
                                <article class="user-card-row">
                                        <div class="user-profile-info">
                                            <span class="material-icons avatar-icon">person</span>
                                            <div class="user-text">
                                                <strong><?= $user['name'] ?></strong>
                                                <p>Tidak mengisi Dass-21</p>
                                            </div>
                                        </div>
                                    
                                        <div class="user-actions">
                                            <a href="dokter_rekapOnePasien.php?id=<?= $user['id'] ?>">
                                                <button class="btn-edit">
                                                    <span class="material-icons">
                                                        Rekap
                                                    </span> 
                                                </button>
                                            </a>
                                            <a href="dokter_detailPasien.php?id=<?= $user['id'] ?>">
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
                            <?php endif;?>
                        <?php endforeach;?>
                    </div>
                    <!-- end list user -->
                </section>


                <!-- sesi manajemen Jadwal -->
                <section class="manajemem-konten">
                    <header class="section-header">
                        <h2 class="title-daftar">Jadwal pertemuan</h2>
                         <?php
                            if(!is_null($tambahJadwal)):
                            ?>
                                <p><?= $tambahJadwal ?></p>
                        <?php elseif(!is_null($notifikasiHapus)):?>
                                <p><?= $notifikasiHapus ?></p>
                        <?php endif;?>
                                                <!-- tombol pemicu -->
                        <button onclick="document.getElementById('modalJadwal').style.display='flex'">
                            Buat Jadwal
                        </button>

                        <!-- modal-nya, tersembunyi di awal -->
                        <div id="modalJadwal"  style="display: none; "class="modal-overlay">
                            <div class="modal-content">
                                <h3>Buat Jadwal</h3>

                                <form method="POST">
                                    <select name="pasien_id">
                                        <?php foreach($dataAllUsers as $pasien):?>
                                            <option value="<?= $pasien['id'] ?>"><?= $pasien['name'] ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <select name="status_jadwal">
                                            <option value="aktif">Aktif</option>
                                            <option value="sudah_diproses">Tidak aktif</option>
                                    </select>
                                    <input type="date" name="tanggal_pertemuan">
                                    <button type="submit">Simpan</button>
                                    <button type="button" onclick="document.getElementById('modalJadwal').style.display='none'">Batal</button>
                                </form>
                            </div>
                        </div>
                    </header>


                    <div class="users-list">
                        <?php
                            if(!is_null($notifikasiHapus)):
                        ?>
                            <p><?= $notifikasiHapus ?></p>
                        <?php
                        elseif(!is_null($modifJadwal)):
                        ?>
                            <p><?= $modifJadwal ?></p>
                        <?php endif; ?>

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
                                <!-- edit jadwal -->
                                    <button onclick="document.getElementById('modalJadwal<?= $jadwal['id'] ?>').style.display='flex'">
                                        Edit
                                    </button>

                                    <!-- modal-nya, tersembunyi di awal -->
                                    <div id="modalJadwal<?= $jadwal['id'] ?>"  style="display: none; "class="modal-overlay">
                                        <div class="modal-content">
                                            <h3>Edit Jadwal</h3>

                                            <form method="POST">
                                                <input type="hidden" name="jadwal_id" value=<?= $jadwal['id'] ?>>
                                                <!-- <select name="pasien_id">
                                                    <?php foreach($dataAllUsers as $pasien):?>
                                                        <option value="<?= $pasien['id'] ?>" <?= $pasien['id'] == $jadwal['pasien_id'] ? 'selected' : '' ?> >
                                                            <?= $pasien['name'] ?>
                                                        </option>
                                                    <?php endforeach;?>
                                                </select> -->

                                                <select name="status_jadwal">
                                                        <option value="aktif" <?= $jadwal['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                                        <option value="tidak aktif" <?= $jadwal['status'] == 'tidak aktif' ? 'selected' : '' ?>>Tidak aktif</option>
                                                </select>

                                                <input type="date" name="tanggal_pertemuan" value="<?= $jadwal['tanggal_pertemuan'] ?>">
                                                <button type="submit">Simpan perubahan</button>
                                                <button type="button" onclick="document.getElementById('modalJadwal<?= $jadwal['id'] ?>').style.display='none'">Batal</button>

                                            </form>
                                        </div>
                                    </div>

                                    <form method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        <input type="hidden" name="hapus_id" value="<?= $jadwal['id']; ?>">
                                        <input type="hidden" name="nama_table" value="jadwal_kontrol">
                                        <button type="submit">Hapus</button>
                                    </form>

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