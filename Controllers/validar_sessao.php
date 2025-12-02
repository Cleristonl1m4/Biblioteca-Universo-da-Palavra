<?php 
    session_start();
    if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== true){
        header("Location: /Biblioteca-Universo-da-Palavra/Pages/loginpage/login.php?status=3");
        exit;
    }
?>