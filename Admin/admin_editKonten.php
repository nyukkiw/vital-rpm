<?php
require_once __DIR__ . "/../function/data/data_handle.php";
require_once __DIR__ . "/../function/koneksi.php";
require_once __DIR__ . "/../function/auth/auth_cek.php";

proteksi($_SESSION["role"], $_SESSION["user_id"]);

$konten = getContentById($koneksi, 'konten_edukasi', $_GET['id'])->fetch_assoc();


$notifikasiModif=null;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $modifikasi = editContent($koneksi, $_POST, $konten['id'],$_FILES['thumbnail_baru']);

    if($modifikasi){
        $notifikasiModif = "Berhasil mengedit konten";
    }else{
        $notifikasiModif = "Gagal mengedit konten"; 
    }

    // $hasilThumb = thumbnailHanler($_FILES['thumbnail_lama']);

    //     // if($tambahKonten){
    //     //     $notifikasiTambah="Berhasil tambah konten"; 
    //     // }else{
    //     //     $notifikasTambah="gagal tambah konten";
    //     // }
    // }
   
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Edit content</title>
</head>
<body>
    <div class="container-addPage-layout">
        <div class="add-pageLayout">
            <header>
                <p><?= $konten['judul'] ?></p>
                <a href="admin_dashbord.php">
                    <button>Kembali</button>
                </a>
                <div class="title-addUser">
                    <H1>Edit konten</H1>
                </div>
            </header>
            <main>
                <?php
                if(!is_null($notifikasiModif)):
                ?>
                    <p><?= $notifikasiModif ?></p>
                <?php
                endif;
                ?> 

                <div class="formAdd-container">
                <form method="POST"  enctype="multipart/form-data">
                    <label for="">
                        Judul
                        <input type="text" name="judul" value="<?= $konten['judul'] ?>" >
                    </label>
                    
                    <label for="">
                        Link
                        <input type="text" name="link" value="<?= $konten['link'] ?>" >
                    </label>

                    <label for="">
                        Deskripsi
                        <input type="text" name="deskripsi" value="<?= $konten['deskripsi'] ?>" >
                    </label>

                    <label for="">
                        Thumbnail
                        <img src="/uploads/thumbnails/<?= basename($konten['thumbnail']); ?>" alt="thumbnail">
                        <input type="file" name="thumbnail_baru" accept="image/jpeg, image/png">
                        <input type="hidden" name="thumbnail_lama" value="<?= $konten['thumbnail']; ?>">
                    </label>

                    <!-- <label for="">
                        Thumbnail
                        <img src="/uploads/thumbnails/<?= basename($konten['thumbnail']); ?>" alt="thumbnail">
                    </label> -->
                
                    <button type="submit" id="parubahanButton">Simpan perubahan</button>
                </form>   
                </div>
            </main>

        </div>
    </div>

</body>
</html>