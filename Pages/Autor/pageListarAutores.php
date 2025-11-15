<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Autores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        h1 {
            color: #04AA6D;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #04AA6D;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php
        include("../../Components/menu/menu.html");
        include("../../dados/conexao/conexao.php"); 

        // Consulta autores
        $sql = "SELECT Nome, Email, DataNascimento, Biografia FROM autor";
        $result = $conn->query($sql);

        echo "<h1>📚 Lista de Autores</h1>";

        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nome</th><th>Email</th><th>Data de Nascimento</th><th>Biografia</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["Nome"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["DataNascimento"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Biografia"]) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum autor cadastrado ainda.</p>";
        }

        $conn->close();
    ?>
</body>
</html>
