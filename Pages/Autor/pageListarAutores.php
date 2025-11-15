<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        th,
        td {
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

        button {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit {
            background: #2196F3;
            color: white;
        }

        .delete {
            background: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <?php
    include("../../dados/conexao/conexao.php");


    if (isset($_POST["delete_id"])) {
        $id = $_POST['delete_id'];
        $sql = "DELETE FROM autor WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }


    if (isset($_POST["edit_id"])) {
        $id = $_POST["edit_id"];
        $Nome = $_POST["Nome"];
        $Email = $_POST["Email"];
        $DataNascimento = $_POST["DataNascimento"];
        $Biografia = $_POST["Biografia"];

        $sql = "UPDATE autor SET Nome=?, Email=?, DataNascimento=?, Biografia=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $Nome, $Email, $DataNascimento, $Biografia, $id);
        $stmt->execute();
    }

    $sql = "SELECT id, Nome, Email, DataNascimento, Biografia FROM autor";
    $result = $conn->query($sql);
    ?>
    <h1>📚 Lista de Autores</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="w3-table-all w3-hoverable">
            <tr class="w3-green">
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Nascimento</th>
                <th>Biografia</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr id="view-<?php echo $row['id']; ?>">
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Nome"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Email"]); ?></td>
                    <td><?php echo htmlspecialchars($row["DataNascimento"]); ?></td>
                    <td><?php echo htmlspecialchars($row["Biografia"]); ?></td>
                    <td>
                        <button class="edit" onclick="toggleEdit(<?php echo $row['id']; ?>)">Editar</button>
                        <form method="POST" style="display:inline;" onsubmit="return confirm('Quer mesmo excluir?')">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete">Deletar</button>
                        </form>
                    </td>
                </tr>

                <tr id="edit-<?php echo $row['id']; ?>" style="display:none; background:#eef;">
                    <form method="POST">
                        <td><?php echo $row['id']; ?><input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>"></td>
                        <td><input type="text" name="Nome" value="<?php echo htmlspecialchars($row["Nome"]); ?>"></td>
                        <td><input type="text" name="Email" value="<?php echo htmlspecialchars($row["Email"]); ?>"></td>
                        <td><input type="date" name="DataNascimento"
                                value="<?php echo htmlspecialchars($row["DataNascimento"]); ?>"></td>
                        <td><textarea name="Biografia"><?php echo htmlspecialchars($row["Biografia"]); ?></textarea></td>
                        <td>
                            <button type="submit" class="edit">Salvar</button>
                            <button type="button" class="delete"
                                onclick="toggleEdit(<?php echo $row['id']; ?>)">Cancelar</button>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nenhum autor cadastrado ainda.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>

    <script>
        function toggleEdit(id) {
            const viewRow = document.getElementById("view-" + id);
            const editRow = document.getElementById("edit-" + id);
            viewRow.style.display = viewRow.style.display === "none" ? "" : "none";
            editRow.style.display = editRow.style.display === "none" ? "" : "none";
        }

        

    </script>
</body>

</html>