<?php
session_start();


function proteksi($role, $id){
    if(!isset($_SESSION["user_id"])){
       header("Location: ../index.php");
       exit();
   }
    if(!isset($_SESSION["role"])){
        header("Location: ../index.php");
        exit();

    }
}

?>