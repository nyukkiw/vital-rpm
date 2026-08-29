<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";

proteksi($_SESSION["role"], $_SESSION["user_id"]);
$notifikasiTambah=null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $hasilThumb = thumbnailHanler($_FILES['thumbnail']);
    if($hasilThumb){
        $tambahKonten = addContent($koneksi, $_POST, $_SESSION['user_id'], $hasilThumb);

        if($tambahKonten){
            $notifikasiTambah="Berhasil tambah konten"; 
        }else{
            $notifikasTambah="gagal tambah konten";
        }
    }
   
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-add content</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <a href="admin_dashbord.php">
                    <button>Kembali</button>
                </a>
                <div class="title-addUser">
                    <H1>Tambah konten</H1>
                </div>
            </header>
            <main>
                <?php
                if(!is_null($notifikasiTambah)):
                ?>
                    <p><?= $notifikasiTambah ?></p>
                <?php
                endif;
                ?> 

                <div class="formAdd-container">
                <form method="POST"  enctype="multipart/form-data">
                    <label for="">
                        Judul
                        <input type="text" name="judul" placeholder="judul" >
                    </label>
                    <label for="">
                        Link
                        <input type="text" name="link" placeholder="link" >
                    </label>

                    <label for="">
                        Deskripsi
                        <input type="text" name="deskripsi" placeholder="Deskripsi">
                    </label>

                    <label for="">
                        Upload thumbnail
                        <input type="file" name="thumbnail" placeholder="thumbnail">
                    </label>
                
                    <button type="submit" id="daftarButton">Daftarkan</button>
                </form>   
                </div>
            </main>

        </div>
    </div>

</body>
</html>