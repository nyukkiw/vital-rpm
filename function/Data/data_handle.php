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

function editUser($koneksi, $id){
     
}





?>