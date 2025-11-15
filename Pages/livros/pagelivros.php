<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Cadastro de Livros</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-container">

<?php
include("../../dados/conexao/conexao.php");
include("../../Components/menu/menu.html");

// Excluir livro se receber ID
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $sqlDel = "DELETE FROM livros WHERE id = ?";
    $stmt = $conn->prepare($sqlDel);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="w3-panel w3-green w3-padding">Livro excluído com sucesso!</div>';
    } else {
        echo '<div class="w3-panel w3-red w3-padding">Erro ao excluir: ' . $conn->error . '</div>';
    }
    $stmt->close();
}

// Cadastrar livro
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $Titulo = $_POST["Titulo"] ?? null;
    $Autor = $_POST["Autor"] ?? null;
    $AnoPublicacao = $_POST["AnoPublicacao"] ?? null;
    $Editora = $_POST["Editora"] ?? null;

    // Upload da capa
    $Capa = null;
    if (!empty($_FILES["Capa"]["name"])) {
        $nomeArquivo = basename($_FILES["Capa"]["name"]);
        $destino = "../../Pages/imagens/" . $nomeArquivo;

        if (move_uploaded_file($_FILES["Capa"]["tmp_name"], $destino)) {
            $Capa = $nomeArquivo;
        }
    }

    if ($Titulo && $Autor) {
        $sql = "INSERT INTO livros (titulo, autor, ano_publicacao, editora, capa) VALUES (?, ?, ?, ?, ?)";
        $insert = $conn->prepare($sql);
        $insert->bind_param("ssiss", $Titulo, $Autor, $AnoPublicacao, $Editora, $Capa);

        if ($insert->execute()) {
            echo '<div class="w3-panel w3-green w3-padding">Livro cadastrado com sucesso!</div>';
        } else {
            echo '<div class="w3-panel w3-red w3-padding">Erro ao cadastrar: ' . $conn->error . '</div>';
        }
        $insert->close();
    } else {
        echo '<div class="w3-panel w3-red w3-padding">Título e Autor são obrigatórios.</div>';
    }
}
?>

<h1 class="w3-text-green"> 📖 Cadastro de Livros</h1>

<form id="livroForm" action="pagelivros.php" method="POST" enctype="multipart/form-data" 
      class="w3-container w3-card-4 w3-light-grey" style="padding:20px;">

    <label><b>Título</b></label>
    <input class="w3-input w3-border" type="text" name="Titulo" required>

    <label><b>Autor</b></label>
    <input class="w3-input w3-border" type="text" name="Autor" required>

    <label><b>Ano de Publicação</b></label>
    <input class="w3-input w3-border" type="number" name="AnoPublicacao" min="1000" max="2100" required>

    <label><b>Editora</b></label>
    <input class="w3-input w3-border" type="text" name="Editora">

    <label><b>Capa do Livro</b></label>
    <input class="w3-input w3-border" type="file" name="Capa">

    <div class="w3-section">
        <button type="submit" class="w3-button w3-green">Salvar</button>
        <button type="button" class="w3-button w3-red" onclick="document.getElementById('livroForm').reset()">Cancelar</button>
    </div>
</form>

<hr>

<h2 class="w3-text-blue">📚 Lista de Livros</h2>

<?php

$sqlLivros = "SELECT id, titulo, autor, ano_publicacao, editora, capa FROM livros ORDER BY id DESC";
$result = $conn->query($sqlLivros);

if ($result->num_rows > 0): ?>
    <table class="w3-table-all w3-hoverable">
        <tr class="w3-green">
            <th>ID</th>
            <th>Capa</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Ano</th>
            <th>Editora</th>
            <th>Ações</th>
        </tr>
        <?php while($livro = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $livro['id'] ?></td>
                <td>
                    <?php if(!empty($livro['capa'])): ?>
                        <img src="../../Pages/imagens/<?= htmlspecialchars($livro['capa']) ?>" 
                             alt="Capa do livro <?= htmlspecialchars($livro['titulo']) ?>" 
                             style="width:80px; height:auto;">
                    <?php else: ?>
                        <span>Sem capa</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($livro['titulo']) ?></td>
                <td><?= htmlspecialchars($livro['autor']) ?></td>
                <td><?= htmlspecialchars($livro['ano_publicacao']) ?></td>
                <td><?= htmlspecialchars($livro['editora']) ?></td>
                <td>
                    <a href="pagelivros.php?excluir=<?= $livro['id'] ?>" 
                       onclick="return confirm('Tem certeza que deseja excluir este livro?')" 
                       class="w3-button w3-red">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Nenhum livro cadastrado ainda.</p>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>
