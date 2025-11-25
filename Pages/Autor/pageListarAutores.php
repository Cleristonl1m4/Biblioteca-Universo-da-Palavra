<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Autores</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-light-grey">

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

<div class="w3-container w3-padding">
    <h1 class="w3-text-green"><i class="fa fa-users"></i> Lista de Autores</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="w3-responsive w3-card w3-white w3-round-large w3-margin-top">
            <table class="w3-table-all w3-hoverable w3-striped w3-bordered">
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
                        <td>
                            <div class="w3-card w3-light-grey w3-round w3-padding-small w3-small" style="max-height:100px; overflow-y:auto;">
                                <?php echo nl2br(htmlspecialchars($row["Biografia"])); ?>
                            </div>
                        </td>
                        <td>
                            <button class="w3-button w3-blue w3-round-small" onclick="toggleEdit(<?php echo $row['id']; ?>)">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <form method="POST" style="display:inline;" onsubmit="return confirm('Quer mesmo excluir?')">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="w3-button w3-red w3-round-small">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <tr id="edit-<?php echo $row['id']; ?>" style="display:none;" class="w3-pale-blue">
                        <form method="POST">
                            <td>
                                <?php echo $row['id']; ?>
                                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                            </td>
                            <td><input class="w3-input w3-border w3-round" type="text" name="Nome" value="<?php echo htmlspecialchars($row["Nome"]); ?>"></td>
                            <td><input class="w3-input w3-border w3-round" type="text" name="Email" value="<?php echo htmlspecialchars($row["Email"]); ?>"></td>
                            <td><input class="w3-input w3-border w3-round" type="date" name="DataNascimento" value="<?php echo htmlspecialchars($row["DataNascimento"]); ?>"></td>
                            <td><textarea class="w3-input w3-border w3-round" name="Biografia"><?php echo htmlspecialchars($row["Biografia"]); ?></textarea></td>
                            <td>
                                <button type="submit" class="w3-button w3-green w3-round-small">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button type="button" class="w3-button w3-grey w3-round-small" onclick="toggleEdit(<?php echo $row['id']; ?>)">
                                    <i class="fa fa-times"></i>
                                </button>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php else: ?>
        <p class="w3-text-grey">Nenhum autor cadastrado ainda.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</div>

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