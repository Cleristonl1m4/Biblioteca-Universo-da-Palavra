<?php
    $database = "universodaspalavras";
    $serve = "localhost";
    $user = "root";
    $pass = "Aluno123qwer#";

    $mensagen = "";
    session_start();
    $conn = new mysqli($serve,$user,$pass,$database );

    if ($conn ->connect_error){
        die("falha na conexao " .$conn->connect_error );
    }
?>