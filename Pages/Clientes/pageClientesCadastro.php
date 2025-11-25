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
            echo '<div class="w3-panel w3-green">
            <h3>Concluido!</h3>
            <p>Dados inseridos com sucesso</p>
            </div>'; 
        } else {
            echo '<div class="w3-panel w3-red">
            <h3>Falha!</h3>
            <p>Erro ao inserir dados</p> 
            </div>';
        }

        $insert->close();
    }
    ?>
    <div class="w3-container">
        <h2 class="w3-margin-top"><strong>Cadastro de Clientes</strong></h2>
        <form id="formaCliente" class='w3-container w3-card-2 w3-margin-top' action="pageClientesCadastro.php" method="post">
            <div class="w3-margin-top">
                <div class="w3-col s2">
                    <label for="nome">Nome:</label><br>
                    <input class="w3-input" type="text" id="nome" name="nome" placeholder="Nome" required><br>
                </div>
                <div class="w3-col s2">
                    <label for="cpf">CPF:</label><br>
                    <input class="w3-input" type="text" id="cpf" name="cpf" placeholder="CPF" required><br>
                </div>
                <div class="w3-col s2">
                    <label for="telefone">Telefone:</label><br>
                    <input class="w3-input" type="text" id="telefone" name="telefone" placeholder="Telefone" required><br>
                </div>
                <div class="w3-col s2">
                    <label for="cep">Cep:</label><br>
                    <input class="w3-input" type="text" id="cap" name="cep" placeholder="CEP" required><br>
                </div>
                
                <div class="w3-col s2">
                    <label for="estado">Estado:</label><br>
                    <input class="w3-input" type="text" id="estado" name="estado" placeholder="Estado" required><br>
                </div>
                <div class="w3-col s2">
                    <label for="cidade">Cidade:</label><br>
                    <input class="w3-input" type="text" id="cidade" name="cidade" placeholder="Cidade" required><br>
                </div>
                <div class="w3-col s2">
                    <label for="endereço">Endereço:</label><br>
                    <input class="w3-input" type="text" id="endereco" name="endereco" placeholder="Endereço" required><br>
                </div>
                 <div class="w3-col s2">
                     <label for="bairro">Bairro:</label><br>
                     <input class="w3-input" type="text" id="bairro" name="bairro" placeholder="Bairro" required><br>
                 </div>   
                <div class="w3-col s2">
                    <label for="email">Email:</label><br>
                    <input class="w3-input" type="text" id="email" name="email" placeholder="Email" required><br>
                </div>
            </div>
            <div class="w3-row-padding w3-margin-bottom">
                <button class="w3-button w3-blue w3-margin-top" type="submit">Salvar</button>
            </div>
        </form>
    </div>
    <?php include("pagelistarCliente.php") ?>
</body>

</html>