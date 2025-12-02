<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include("../../dados/conexao/conexao.php");

    $sql = "SELECT * FROM alunos";

    $result = $conn->query($sql);

    ?>

    <table class="w3-table-all w3-margin-top">
        <thead>
            <tr class="w3-light-grey">
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>CEP</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Endereço</th>
                <th>Bairro</th>
                <th>Email</th>
                <th>Alterações</th>
            </tr>
        </thead>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["cpf"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["telefone"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["cep"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["estado"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["cidade"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["endereco"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["bairro"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>";
                echo "<a href='deleteAluno.php?id=" . $row['id'] . "'><button type='button'>Exluir</button></a></td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>

</html>