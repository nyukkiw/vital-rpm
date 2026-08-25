<?php
// memulai sesi logika
session_start();

// ambil sekali file koneksi.php
require_once __DIR__ . "/koneksi.php";


// cek apakah request method berupa post
if($_SERVER["REQUEST_METHOD"]==="POST"){

    // ambil data dari form login
    $username = isset($_POST['userName']) ? trim($_POST['userName']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";

    // cek apakah username dan password kosong 
    if(!$username || !$password){
        // jika kosong maka redirect ke halaman login dengan error
        header("Location: ../index.php?error=kosong");
        exit();
    }
    
    $sql = "SELECT id, name, password FROM users WHERE name = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

      // CEK APAKAH USERNAME DITEMUKAN
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // COCOKKAN PASSWORD
        // Menggunakan password_verify adalah standar keamanan untuk mengecek password yang di-hash
        if (password_verify($password, $user['password'])) { 
            $_SESSION["user"] = $user['name'];
            $_SESSION["user_id"] = $user['id'];
            
            header("Location: ../home.php");
            exit();
        }
    }

    // Jika username tidak ada ATAU password salah, lempar ke sini
    header("Location:../index.php?error=salah");
    exit();

}




?>