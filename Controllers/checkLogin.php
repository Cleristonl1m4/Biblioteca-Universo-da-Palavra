<?php
session_start(); // INICIAR SESSÃO
include("../dados/conexao/conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();


        if ($pass === $user['senha']) {

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
