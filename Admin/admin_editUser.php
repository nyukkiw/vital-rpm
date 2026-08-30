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
    <title>Admin-Edit User</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <a href="admin_dashbord.php">
                    <button>Kembali</button>
                </a>
                <div class="title-addUser">
                    <H1>Edit user</H1>
                </div>
            </header>
            <main>
                <?php
                if(!is_null($modifSukses)):
                ?>
                    <p><?= $modifSukses ?></p>
                <?php
                endif;
                ?> 
                <div class="formAdd-container">
                <form method="POST">

                    <label for="">
                        Nama pengguna
                        <input type="text" name="userName" placeholder="Nama pengguna" value="<?= $user['name'] ?>">
                    </label>
                    
                    <label for="">
                        Password
                        <input type="password" name="password" placeholder="Password">
                    </label>

                     <label for="aktif">
                        <input type="radio" id="aktif" name="status" value="Aktif" 
                        <?= ($user['status'] === 'aktif') ? 'checked' : ''; ?>>
                        Aktif
                    </label>

                    <label for="nonAktif">
                        <input type="radio" id="nonAktif" name="status" value="Tidak aktif"
                        <?= ($user['status'] === 'tidak aktif') ? 'checked' : ''; ?>>
                        Tidak aktif
                    </label>

                    <label for="laki">
                            <input type="radio" id="laki" name="jenisKelamin" value="Laki-laki" 
                                <?= ($user['jenis_kelamin'] === 'Laki-laki') ? 'checked' : ''; ?>>
                            Laki-laki
                    </label>

                    <label for="perempuan">
                            <input type="radio" id="perempuan" name="jenisKelamin" value="Perempuan" 
                                <?= ($user['jenis_kelamin'] === 'Perempuan') ? 'checked' : ''; ?>>
                            Perempuan
                    </label>
                    
                    <label>
                        Alamat                        
                        <input type="text" name="alamat" placeholder="Alamat" value="<?= $user['alamat'] ?>">
                    </label>
                    <label for="">
                        No. Telpon
                        <input type="text" name="noTlpn" placeholder="No. Telpon" value="<?= $user['phone'] ?>">
                    </label>

                    <label for="">
                        Email
                        <input type="text" name="noTlpn" placeholder="No. Telpon" value="<?= $user['email'] ?>">
                    </label>
                    
                    <label>
                        Alergi
                        <input type="text" name="alergi" placeholder="Alergi" value="<?= $user['alergi']?>">
                    </label>
                    
                    <!-- <input type="text" name="noRekamMedis" placeholder="No.Rekam medis" value="<?= $user['no_rekam_medis'] ?>"> -->

                    
                    <input type="text" name="email" placeholder="email" value="<?= $user['email'] ?>">

                   

                    <button type="submit" id="perubahanButton">Simpan perubahan</button>

                </form>   
                </div>
            </main>

        </div>
    </div>

</body>
</html>