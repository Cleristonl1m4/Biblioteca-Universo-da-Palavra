<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🖊 Cadastro de Autor</title

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-container">

<?php
include("../../dados/conexao/conexao.php");
include("../../Components/menu/menu.html");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $Nome = $_POST["Nome"] ?? null;
    $Email = $_POST["Email"] ?? null;
    $DataNascimento = $_POST["DataNascimento"] ?? null;
    $Biografia = $_POST["Biografia"] ?? null;

    if ($Nome && $Email) {
        $sql = "INSERT INTO autor (Nome, Email, DataNascimento, Biografia) VALUES (?, ?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("ssss", $Nome, $Email, $DataNascimento, $Biografia);

        if ($insert->execute()) {
            echo '<div class="w3-panel w3-green w3-padding">Autor cadastrado com sucesso!</div>';
        } else {
            echo '<div class="w3-panel w3-red w3-padding"> Erro ao cadastrar: ' . $conn->error . '</div>';
        }
        $insert->close();
    } else {
        echo '<div class="w3-panel w3-red w3-padding"> Nome e Email são obrigatórios.</div>';
    }
    $conn->close();
}
?>

<h1 class="w3-text-green"> 📚 Cadastro de Autor</h1>

<form id="autorForm" action="pageAutor.php" method="POST" class="w3-container w3-card-4 w3-light-grey" style="padding:20px;">

    <label><b>Nome</b></label>
    <input class="w3-input w3-border" type="text" name="Nome" required>

    <label><b>Email</b></label>
    <input class="w3-input w3-border" type="email" name="Email" required>

    <label><b>Data de Nascimento</b></label>
    <input class="w3-input w3-border" type="date" name="DataNascimento" required>

    <label><b>Biografia</b></label>
    <textarea class="w3-input w3-border" name="Biografia" rows="4"></textarea>

    <p>Ao criar uma conta, você concorda com nossos 
        <a href="#" class="w3-text-blue">Termos & Privacidade</a>.
    </p>

    <div class="w3-section">
        <button type="submit" class="w3-button w3-green">Salvar</button>
        <button type="button" class="w3-button w3-red" onclick="document.getElementById('autorForm').reset()">Cancelar</button>
    </div>
</form>


<?php include("pageListarAutores.php"); ?>

</body>
</html>
