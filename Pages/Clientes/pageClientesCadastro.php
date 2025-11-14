<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
</head>
<body>
    <?php 
        if($_SERVER['REQUEST_METHOD'] == "POST"){
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
            $insert = $conn -> prepare($sql);
            $insert ->bind_param("sssssssss",$nome,$cpf, $telefone,$cep, $estado, $cidade, $endereco, $bairro, $email);

            if($insert -> execute()){
                echo'<div style="background: green;"">"Dados inseridos com Sucesso</div>';
            }else{
                echo"Erro ao inserir registros:".$conn -> $error;
            }
            
            $insert->close();
    
            
            
        }
    ?>
    <h2>Cadrastro de Clientes</h2>
    <form action="pageClientesCadastro.php" method="post">
        <div>
            <div>
                <label for="nome">Nome:</label><br>
                <input type="text" id="nome" name="nome" placeholder="Nome" required><br>
            </div>
            <div>
                <label for="cpf">CPF:</label><br>
                <input type="text" id="cpf" name="cpf" placeholder="CPF" required><br>
            </div>
            <div>
                <label for="telefone">Telefone:</label><br>
                <input type="text" id="telefone" name="telefone" placeholder="Telefone" required><br>
            </div>
            <div>
                <label for="cep">Cep:</label><br>
                <input type="text" id="cap" name="cep" placeholder="CEP" required><br>
            </div>
            <div>
                <label for="estado">Estado:</label><br>
                <input type="text" id="estado" name="estado" placeholder="Estado" required><br>
            </div>
            <div>
                <label for="cidade">Cidade:</label><br>
                <input type="text" id="cidade" name="cidade" placeholder="Cidade" required><br>
            </div>
            <div>
                <label for="endereço">Endereço:</label><br>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" required><br>
            </div>
            <div>
                <label for="bairro">Bairro:</label><br>
                <input type="text" id="bairro" name="bairro" placeholder="Bairro" required><br>
            </div>
            <div>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email" placeholder="Email" required><br>
            </div>
            <button type="submit">Salvar</button>
        </div>
    </form>
</body>
</html>