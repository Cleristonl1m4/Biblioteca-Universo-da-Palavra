<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✍️ Lista de Autores</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
include("../../dados/conexao/conexao.php");

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    
    $sqlCheck = "SELECT COUNT(*) as total FROM livros WHERE autor = (SELECT Nome FROM autor WHERE id = ?)";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $check = $resultCheck->fetch_assoc();
    
    if ($check['total'] > 0) {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-exclamation-triangle"></i> 
                Não é possível excluir! Este autor possui ' . $check['total'] . ' livro(s) cadastrado(s).
              </div>';
    } else {
        $sqlDel = "DELETE FROM autor WHERE id = ?";
        $stmt = $conn->prepare($sqlDel);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo '<div class="w3-panel w3-green w3-padding w3-round">
                    <i class="fa fa-check"></i> Autor excluído com sucesso!
                  </div>';
        } else {
            echo '<div class="w3-panel w3-red w3-padding w3-round">
                    <i class="fa fa-times"></i> Erro ao excluir: ' . $conn->error . '
                  </div>';
        }
        $stmt->close();
    }
    $stmtCheck->close();
}


if (isset($_POST["edit_id"])) {
    $id = intval($_POST["edit_id"]);
    $Nome = trim($_POST["Nome"]);
    $Email = trim($_POST["Email"]);
    $DataNascimento = $_POST["DataNascimento"];
    $Biografia = trim($_POST["Biografia"]);

    $sql = "UPDATE autor SET Nome=?, Email=?, DataNascimento=?, Biografia=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $Nome, $Email, $DataNascimento, $Biografia, $id);
    
    if ($stmt->execute()) {
        echo '<div class="w3-panel w3-green w3-padding w3-round">
                <i class="fa fa-check"></i> Autor atualizado com sucesso!
              </div>';
    } else {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-times"></i> Erro ao atualizar: ' . $conn->error . '
              </div>';
    }
    $stmt->close();
}

$sql = "SELECT id, Nome, Email, DataNascimento, Biografia FROM autor ORDER BY Nome ASC";
$result = $conn->query($sql);
?>

<div class="w3-container w3-margin-top">
    <h1 class="w3-text-brown">
        <i class="fa fa-users"></i> Lista de Autores
    </h1>
    <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
</div>

<?php if ($result && $result->num_rows > 0): ?>
    <div class="w3-container w3-margin-top">
        <div class="w3-responsive">
            <table class="w3-table-all w3-hoverable w3-card-4">
                <thead>
                    <tr class="w3-brown">
                        <th><i class="fa fa-hashtag"></i> ID</th>
                        <th><i class="fa fa-user"></i> Nome</th>
                        <th><i class="fa fa-envelope"></i> Email</th>
                        <th><i class="fa fa-calendar"></i> Data de Nascimento</th>
                        <th><i class="fa fa-file-text"></i> Biografia</th>
                        <th><i class="fa fa-book"></i> Livros</th>
                        <th><i class="fa fa-cog"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): 
                        // Contar livros do autor
                        $sqlLivros = "SELECT COUNT(*) as total FROM livros WHERE autor = ?";
                        $stmtLivros = $conn->prepare($sqlLivros);
                        $stmtLivros->bind_param("s", $row['Nome']);
                        $stmtLivros->execute();
                        $resultLivros = $stmtLivros->get_result();
                        $totalLivros = $resultLivros->fetch_assoc()['total'];
                        $stmtLivros->close();
                    ?>
                        <!-- Linha de Visualização -->
                        <tr id="view-<?= $row['id'] ?>">
                            <td><?= $row['id'] ?></td>
                            <td><strong><?= htmlspecialchars($row['Nome']) ?></strong></td>
                            <td><?= htmlspecialchars($row['Email']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['DataNascimento'])) ?></td>
                            <td>
                                <div style="max-width:300px;">
                                    <?= htmlspecialchars(substr($row['Biografia'], 0, 150)) ?>
                                    <?= strlen($row['Biografia']) > 150 ? '...' : '' ?>
                                </div>
                            </td>
                            <td>
                                <span class="w3-tag w3-round w3-green">
                                    <?= $totalLivros ?> livro(s)
                                </span>
                            </td>
                            <td>
                                <button class="w3-button w3-blue w3-round w3-small" 
                                        onclick="toggleEdit(<?= $row['id'] ?>)">
                                    <i class="fa fa-pencil"></i> Editar
                                </button>
                                <a href="pageAutor.php?excluir=<?= $row['id'] ?>"
                                   onclick="return confirm('Tem certeza que deseja excluir este autor?')"
                                   class="w3-button w3-red w3-round w3-small">
                                    <i class="fa fa-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>

                        <tr id="edit-<?= $row['id'] ?>" style="display:none;" class="w3-pale-blue">
                            <form method="POST">
                                <td>
                                    <?= $row['id'] ?>
                                    <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                                </td>
                                <td>
                                    <input class="w3-input w3-border w3-round" type="text" name="Nome" 
                                           value="<?= htmlspecialchars($row['Nome']) ?>" required>
                                </td>
                                <td>
                                    <input class="w3-input w3-border w3-round" type="email" name="Email" 
                                           value="<?= htmlspecialchars($row['Email']) ?>" required>
                                </td>
                                <td>
                                    <input class="w3-input w3-border w3-round" type="date" name="DataNascimento" 
                                           value="<?= htmlspecialchars($row['DataNascimento']) ?>" required>
                                </td>
                                <td colspan="2">
                                    <textarea class="w3-input w3-border w3-round" name="Biografia" 
                                              rows="3"><?= htmlspecialchars($row['Biografia']) ?></textarea>
                                </td>
                                <td>
                                    <button type="submit" class="w3-button w3-green w3-round w3-small">
                                        <i class="fa fa-check"></i> Salvar
                                    </button>
                                    <button type="button" class="w3-button w3-grey w3-round w3-small" 
                                            onclick="toggleEdit(<?= $row['id'] ?>)">
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="w3-container w3-margin-top">
        <div class="w3-panel w3-pale-yellow w3-border w3-round-large w3-center">
            <p><i class="fa fa-info-circle"></i> Nenhum autor cadastrado ainda.</p>
        </div>
    </div>
<?php endif; ?>



<?php $conn->close(); ?>

<script>
    function toggleEdit(id) {
        const viewRow = document.getElementById("view-" + id);
        const editRow = document.getElementById("edit-" + id);
        
        if (viewRow.style.display === "none") {
            viewRow.style.display = "";
            editRow.style.display = "none";
        } else {
            viewRow.style.display = "none";
            editRow.style.display = "";
        }
    }
</script>

</body>
</html>