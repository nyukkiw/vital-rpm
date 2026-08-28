<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";




proteksi($_SESSION["role"], $_SESSION["user_id"]);



if($_SERVER["REQUEST_METHOD"] === "POST"){

    $pesanEror = "";

    $field_wajib = ['userName', 'password', 'jenisKelamin', 
    'alamat', 'peran', 
    'noRekamMedis', 'alergi', 'tanggalLahir', 'noTlpn', 'email', 'status'];

    foreach ($field_wajib as $field){
        if(empty($_POST[$field])){
            $pesanEror = true;
            break;
        }

        
    }

    if($pesanEror == true){
        $_SESSION['error'] = "field tidak boleh kosong";
        header("Location: admin_tambahUser.php");
        exit();
    }else{
        $berhasilTambah = addUser($koneksi, $_POST);
        if($berhasilTambah){
            $_SESSION['suksesTambah'] = "Data berhasil ditambah ke database!";
            header("Location: admin_tambahUser.php");
            exit();
        }else{
            $_SESSION['errorTambah'] = "Gagal menambahkan data ke database";
            header("Location: admin_tambahUser.php");
            exit();
        }
    }

    

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-add User</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <div class="title-addUser">
                    <H1>Tambah user</H1>
                </div>
            </header>
            <main>
                <div class="formAdd-container">

                    <?php if(!empty($_SESSION['error'])):?>
                       <p> <?= htmlspecialchars($_SESSION['error']) ?></p>
                       <?php
                        unset($_SESSION['error']);
                       ?>

                    <?php elseif(!empty($_SESSION['suksesTambah'])):?>
                        <p><?= htmlspecialchars($_SESSION['suksesTambah']) ?></p>

                        <?php foreach ($_SESSION['isi_data'] as $iniData): ?>
                            <p><?= $iniData ?></p>
                        <?php endforeach;?>

                        <?php
                        unset($_SESSION['suksesTambah']);
                        ?>

                    <?php else: ?>
                        <p><?= $_SESSION['errorTambah']; ?></p>
                        <?php unset($_SESSION['errorTambah']);?>

                    <?php endif; ?>
                    
                <form method="POST">
                    <label for="">
                        Nama pengguna
                        <input type="text" name="userName" placeholder="Nama pengguna" required>
                    </label>
                    <label for="">
                        Password
                        <input type="password" name="password" placeholder="Password" required>
                    </label>

                    <label for="">
                        <input type="radio" name="jenisKelamin" value="Laki-laki" required>
                        Laki-laki
                    </label>
                    <label for="">
                        <input type="radio" name="jenisKelamin" value="Perempuan" required>
                        Perempuan
                    </label>
                    
                    <label for="">
                        Alamat                        
                        <input type="text" name="alamat" placeholder="Alamat" required>
                    </label>

                    <label for="">
                        Alergi
                        <input type="text" name="alergi" placeholder="Alergi">
                    </label>
                    

                    <select name="peran" required>
                        <option value="pasien">Pasien</option>
                        <option value="dokter">Doktor</option>
                    </select>

                    <input type="text" name="noRekamMedis" placeholder="No.Rekam medis" required>

                    <input type="text" name="tanggalLahir" placeholder="Tanggal lahir" required>
                    
                    <input type="text" name="noTlpn" placeholder="No. Telpon" required>
                    
                    <input type="text" name="email" placeholder="email" required>

                    <label for="">
                        <input type="radio" name="status" value="Aktif" required>
                        Aktif
                    </label>
                    <label for="">
                        <input type="radio" name="status" value="Tidak aktif" required>
                        Tidak aktif
                    </label>

                    <button type="submit" id="daftarButton">Daftarkan</button>
                </form>   
                </div>
            </main>

        </div>
    </div>

</body>
</html>