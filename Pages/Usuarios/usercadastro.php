<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <title>Cadastrar usuario</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        include("../../dados/conexao/conexao.php");

        $nome   = $_POST['name'];
        $usuario = $_POST['usuario'];
        $senha  = $_POST['password'];
        $confirma = $_POST['Confirmpassword'];

        if ($senha !== $confirma) {
            echo '<div class="w3-panel w3-red">
                <h3>Falha!</h3>
                <p>As senhas não coincidem.</p>
              </div>';
            exit;
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, usuario, senha) VALUES (?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("sss", $nome, $usuario, $hash);

        if ($insert->execute()) {
            echo '<div class="w3-panel w3-green">
                <h3>Concluído!</h3>
                <p>Usuário inserido com sucesso</p>
              </div>';
        } else {
            echo '<div class="w3-panel w3-red">
                <h3>Falha!</h3>
                <p>Erro ao inserir usuário</p> 
              </div>';
        }

        $insert->close();
    }
    ?>
    <div class="w3-display-middle">
        <div>
            <h2 class="w3-serif">Cadastro de Usuarios</h2>
        </div>
        <div class="w3-card-4 w3-white w3-round-xlarge" style="max-width:900px">
            <form class="w3-container" method="post" action="usercadastro.php">
                <p>
                    <label>Nome</label>
                    <input class="w3-input" name="name" required>
                </p>
                <p>
                    <label>Usuário</label>
                    <input class="w3-input" name="usuario" required>
                </p>
                <p>
                    <label>Senha</label>
                    <input class="w3-input" type="password" name="password" required>
                </p>
                <p>
                    <label>Confirmação de Senha</label>
                    <input class="w3-input" type="password" name="Confirmpassword" required>
                </p>
                <p>
                    <a class="w3-btn w3-right w3-white w3-border w3-border-green w3-round-xlarge" href="/Biblioteca-Universo-da-Palavra/Pages/loginpage/login.php">Voltar</a>
                    <button class="w3-btn w3-white w3-border w3-border-green w3-round-xlarge" type="submit">Salvar</button>
                </p>
            </form>
        </div>
    </div>
    </div>
</body>

</html>