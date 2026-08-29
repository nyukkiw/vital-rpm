<?php
function getAlldataUsers($koneksi){
    $data = mysqli_prepare($koneksi, "SELECT * FROM users");
    // mysqli_stmt_bind_param($data, "s");
    mysqli_stmt_execute($data);
    $result = mysqli_stmt_get_result($data);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function getAlldataContent($koneksi){
    $data = mysqli_prepare($koneksi, "SELECT * FROM konten_edukasi");
    // mysqli_stmt_bind_param($data, "s");
    mysqli_stmt_execute($data);
    $result = mysqli_stmt_get_result($data);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getDataById($koneksi, $id){
    $data = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id");
    return $data; 
}

function getDataByRole($koneksi, $role){
    $data = mysqli_prepare($koneksi, "SELECT * FROM users WHERE role = ?");
    mysqli_stmt_bind_param($data, "s", $role);
    mysqli_stmt_execute($data);
    $result = mysqli_stmt_get_result($data);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
function getStatsAcc($koneksi, $stats){
    $data = mysqli_prepare($koneksi, "SELECT * FROM users WHERE status = ?");
    mysqli_stmt_bind_param($data, "s", $stats);
    mysqli_stmt_execute($data);
    $result = mysqli_stmt_get_result($data);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
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

function editUser($koneksi, $update){
    $data = mysqli_prepare($koneksi, "UPDATE users SET name = ?, alamat = ?, email = ?, phone = ?, no_rekam_medis = ?, alergi = ?, status = ? WHERE id = ?");
    mysqli_stmt_bind_param($data, "sssssssi", 
    $update['userName'], $update['alamat'], $update['email'],
     $update['noTlpn'], $update['noRekamMedis'], $update['alergi'],
      $update['status'], $update['id']);
    $prosesModifikasi = mysqli_stmt_execute($data);
    return $prosesModifikasi;
     
}


function thumbnailHanler($file){
    $thumbnailTitle = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $tujuanSimpan = __DIR__ . '/../../uploads/thumbnails/' . $thumbnailTitle;

    if(move_uploaded_file($file['tmp_name'], $tujuanSimpan)){
        return $tujuanSimpan;
    }else{
        return false; 
    }
}

function addContent($koneksi, $add, $id, $path ){
    $data = mysqli_prepare($koneksi, "INSERT INTO konten_edukasi (admin_id, judul, link, deskripsi, thumbnail) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($data, "issss", 
    $id,
    $add['judul'],
    $add['link'],
    $add['deksripsi'],
    $path
    );
    $prosesTambahKonten = mysqli_stmt_execute($data);

    return $prosesTambahKonten;

}





?>