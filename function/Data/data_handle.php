<?php

use function PHPSTORM_META\override;

function getDataById($koneksi, $targetTable, $id){
    $data = mysqli_query($koneksi, "SELECT * FROM $targetTable WHERE id = $id");
    return $data; 
}


function getAlldataUsers($koneksi){
    $data = mysqli_prepare($koneksi, "SELECT * FROM users");
    // mysqli_stmt_bind_param($data, "s");
    mysqli_stmt_execute($data);
    $result = mysqli_stmt_get_result($data);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function thumbnailHanler($file){
    $thumbnailTitle = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $tujuanSimpan = __DIR__ . '/../../uploads/thumbnails/' . $thumbnailTitle;
    $pathDatabase = 'uploads/thumbnails/' . $thumbnailTitle;

    if(move_uploaded_file($file['tmp_name'], $tujuanSimpan)){
        return $pathDatabase;
        }else{
            return false; 
            }
            }
            
function addUser($koneksi,$add){
                
$passwordPolos = $add['password'] ?? "";
$passwordHash = password_hash($passwordPolos, PASSWORD_DEFAULT);  
                
$data = mysqli_prepare($koneksi, "INSERT INTO users (name, jenis_kelamin, tanggal_lahir, alamat, email, password, phone, no_rekam_medis, alergi, role, avatar, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($data, "ssssssssssss",  $add['userName'],     
        $add['jenisKelamin'],  
        $add['tanggalLahir'],
        $add['alamat'],
        $add['email'],         
        $passwordHash,        
        $add['noTlpn'],        
        $add['noRekamMedis'],
        $add['alergi'],
        $add['peran'],        
        $add['avatar'],        
        $add['status']);
        
        $prosesSimpan = mysqli_stmt_execute($data);
        
        return $prosesSimpan;
        
        
}

function editUser($koneksi, $update, $id){
$data = mysqli_prepare($koneksi, "UPDATE users SET name = ?, jenis_kelamin = ?, alamat = ?, email = ?, phone = ?, alergi = ?, status = ? WHERE id = ?");
mysqli_stmt_bind_param($data, "sssssssi", 
$update['userName'], $update['jenisKelamin'],$update['alamat'], $update['email'],
$update['noTlpn'],  $update['alergi'],
$update['status'], $id);
$prosesModifikasi = mysqli_stmt_execute($data);
return $prosesModifikasi;  
}

function getAlldataContent($koneksi){
            $data = mysqli_prepare($koneksi, "SELECT * FROM konten_edukasi");
            // mysqli_stmt_bind_param($data, "s");
            mysqli_stmt_execute($data);
            $result = mysqli_stmt_get_result($data);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
        
function addContent($koneksi, $add, $id, $path){
$data = mysqli_prepare($koneksi, "INSERT INTO konten_edukasi (admin_id, judul, link, deskripsi, thumbnail) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($data, "issss", 
$id,$add['judul'],$add['link'],$add['deskripsi'],$path);
$prosesTambahKonten = mysqli_stmt_execute($data);
return $prosesTambahKonten;
}



function editContent($koneksi, $update, $id, $path){
$thumbnail = $update['thumbnail_lama'];

    if($path['error'] !== UPLOAD_ERR_NO_FILE){
        $thumbnailPathBaru = thumbnailHanler($path);
        if($thumbnailPathBaru){
            unlink(__DIR__ . '/../../' . $thumbnail);
            $thumbnail = $thumbnailPathBaru;
        }
    }
    $data = mysqli_prepare($koneksi, "UPDATE 
    konten_edukasi SET judul = ?, link = ?, 
    deskripsi = ?, thumbnail = ? WHERE id = ?");

    mysqli_stmt_bind_param($data, "ssssi", 
    $update['judul'], $update['link'], $update['deskripsi'], $thumbnail, $id );

    $prosesModifikasi = mysqli_stmt_execute($data);
    return $prosesModifikasi;  
}






function deleteData($koneksi, $id, $tableName){
    $data = mysqli_prepare($koneksi, "DELETE FROM $tableName WHERE id=?");
    mysqli_stmt_bind_param($data,'i', $id);
    $prosesHapus = mysqli_stmt_execute($data);
    return $prosesHapus;
}





?>