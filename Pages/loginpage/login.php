<?php
// caso o usuario já esteja logado rediciona para a pagina principal
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: /loginapp/login.php");
    exit;
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <title>Login</title>
</head>

<body>
    <div class="w3-display-middle">
        <div class="w3-card-4 w3-white w3-round-xlarge" style="max-width:400px">
            <div class="w3-container w3-center w3-bar w3-brown w3-round-xlarge">
                <h2>Login</h2>
            </div>
            <form class="w3-container" method="post" action="/Biblioteca-Universo-da-Palavra/Controllers/checkLogin.php">
                <p>
                    <label>Usuário</label>
                    <input class="w3-input" name="nome" required>
                </p>
                <p>
                    <label>Senha</label>
                    <input class="w3-input" type="password" name="senha" required>
                </p>
                <p>
                    <button class="w3-btn w3-white w3-border w3-border-green w3-round-xlarge" type="submit">Enter</button>
                    <a class="w3-btn w3-right w3-white w3-border w3-border-green w3-round-xlarge" href="/Biblioteca-Universo-da-Palavra/Pages/Usuarios/usercadastro.php">Cadastrar</a>
                </p>

            </form>
        </div>
        <div>
            <div>
                <?php
                if (isset($_GET['status'])) {
                    if ($_GET['status'] == 1) {
                        echo "<p style='color:red;'>Usuário ou senha inválidos!</p>";
                    } else if ($_GET['status'] == 2) {
                        echo "<p style='color:green;'>Você foi deslogado com sucesso!</p>";
                    } else if ($_GET['status'] == 3) {
                        echo "<p style='color:red;'>Você deve estar logado para acessar essa página!</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>