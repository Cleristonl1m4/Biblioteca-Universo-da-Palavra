<?php
    $database = "universodaspalavras";
    $serve = "localhost";
    $user = "root";
    $pass = "2208";

    $mensagen = "";
    session_start();
    $conn = new mysqli($serve,$user,$pass,$database );

    if ($conn ->connect_error){
        die("falha na conexao " .$conn->connect_error );
    }
?>