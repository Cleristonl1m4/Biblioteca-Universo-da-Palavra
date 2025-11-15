<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Cadastro de Clientes</title>
</head>
<styles>
    
</styles>

<body>
    <?php
    include("../../Components/menu/menu.html");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        include("../../dados/conexao/conexao.php");

        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
        $endereco = $_POST['endereco'];
        $bairro = $_POST['bairro'];
        $email = $_POST['email'];

        $sql = "INSERT INTO clientes (nome,cpf,telefone,cep,estado,cidade,endereco,bairro,email) VALUES (?,?,?,?,?,?,?,?,?);";
        $insert = $conn->prepare($sql);
        $insert->bind_param("sssssssss", $nome, $cpf, $telefone, $cep, $estado, $cidade, $endereco, $bairro, $email);

        if ($insert->execute()) {
            echo '<div style="background: green;"">"Dados inseridos com Sucesso</div>';
        } else {
            echo "Erro ao inserir registros:" . $conn->$error;
        }

        $insert->close();
    }
    ?>
    <form id="formaCliente" class="w3-container w3-card-4 w3-light-grey w3-margin" action="pageClientesCadastro.php" method="post">
        <h2 class="w3-center">Cadrastro de Clientes</h2>
        <div class="container w3-margin-left w3-margin-right w3-margin-bottom">

            <label for="nome">Nome:</label><br>
            <input class="w3-input" type="text" id="nome" name="nome" placeholder="Nome" required><br>


            <label for="cpf">CPF:</label><br>
            <input class="w3-input" type="text" id="cpf" name="cpf" placeholder="CPF" required><br>


            <label for="telefone">Telefone:</label><br>
            <input class="w3-input" type="text" id="telefone" name="telefone" placeholder="Telefone" required><br>


            <label for="cep">Cep:</label><br>
            <input class="w3-input" type="text" id="cap" name="cep" placeholder="CEP" required><br>


            <label for="estado">Estado:</label><br>
            <input class="w3-input" type="text" id="estado" name="estado" placeholder="Estado" required><br>


            <label for="cidade">Cidade:</label><br>
            <input class="w3-input" type="text" id="cidade" name="cidade" placeholder="Cidade" required><br>


            <label for="endereço">Endereço:</label><br>
            <input class="w3-input" type="text" id="endereco" name="endereco" placeholder="Endereço" required><br>


            <label for="bairro">Bairro:</label><br>
            <input class="w3-input" type="text" id="bairro" name="bairro" placeholder="Bairro" required><br>


            <label for="email">Email:</label><br>
            <input class="w3-input" type="text" id="email" name="email" placeholder="Email" required><br>

        </div>
        <button class="w3-button w3-block w3-section w3-ripple w3-pedding" type="submit">Salvar</button>
    </form>
</body>

</html>