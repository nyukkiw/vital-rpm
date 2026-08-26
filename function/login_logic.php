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

    // die("Username: $username, Password: $password"); // Debugging line to check values

    // cek apakah username dan password kosong 
    if(!$username || !$password){
        // jika kosong maka redirect ke halaman login dengan error
        header("Location: ../index.php?error=kosong");
        exit();
    }
    
    $sql = "SELECT id, name, password, role FROM users WHERE name = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

      // CEK APAKAH USERNAME DITEMUKAN
    //   die("username: $username, password: $password, result rows: " . $result->num_rows); // Debugging line to check values
    
      if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // die("sampai disini username: " . $user['name'] . ", password: " . $user['password'] . ", result rows: " . $result->num_rows); // Debugging line to check values
        if (password_verify($password, $user['password'])) { 
            if($user['role'] === 'admin'){
                $_SESSION["user"] = $user['name'];
                $_SESSION["user_id"] = $user['id'];
                    
                header("Location: ../Admin/admin_dashbord.php");
                exit();
            }

            if($user['role'] === 'dokter'){
                $_SESSION["user"] = $user['name'];
                $_SESSION["user_id"] = $user['id'];
                    
                header("Location: ../dokter/dokter_dashboard.php");
                exit();
            }
            

            header("Location: ../pasien/pasien_dashboard.php");
            exit();
        }


        // if(!isset($user['role'])){
        //     header("Location:../index.php?error=role_tidak_ditemukan");
        //     exit();
        // }

    }

    // Jika username tidak ada ATAU password salah, lempar ke sini
    header("Location:../index.php?error=salah");
    exit();

}




?>