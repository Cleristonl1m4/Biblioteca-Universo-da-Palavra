<?php
session_start(); // INICIAR SESSÃO
include("../dados/conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST['nome'] ?? '';
    $pass = $_POST['senha'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE usuario = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();


        if (password_verify($pass,$user['senha'])) {

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user;

            header("Location: /Biblioteca-Universo-da-Palavra/index.php");
            exit;
        } else {
            header("Location: /Biblioteca-Universo-da-Palavra/Pages/loginpage/login.php");
            exit;
        }
    } else {
        header("Location: /Biblioteca-Universo-da-Palavra/Pages/loginpage/login.php");
        exit;
    }
}
