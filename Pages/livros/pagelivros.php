<?php include("../../Controllers/validar_sessao.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Cadastro de Livros</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
include("../../dados/conexao/conexao.php");
include("../../Components/menu/menu.php");

$livroEdit = null;
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $sqlEdit = "SELECT * FROM livros WHERE id = ?";
    $stmtEdit = $conn->prepare($sqlEdit);
    $stmtEdit->bind_param("i", $id);
    $stmtEdit->execute();
    $resultEdit = $stmtEdit->get_result();
    $livroEdit = $resultEdit->fetch_assoc();
    $stmtEdit->close();
}

if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $sqlDel = "DELETE FROM livros WHERE id = ?";
    $stmt = $conn->prepare($sqlDel);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="w3-panel w3-green w3-padding w3-round">
                <i class="fa fa-check"></i> Livro excluído com sucesso!
              </div>';
    } else {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-times"></i> Erro ao excluir: ' . $conn->error . '
              </div>';
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $Titulo = trim($_POST["Titulo"] ?? "");
    $Autor = trim($_POST["Autor"] ?? "");
    $AnoPublicacao = !empty($_POST["AnoPublicacao"]) ? intval($_POST["AnoPublicacao"]) : null;
    $Editora = trim($_POST["Editora"] ?? "");
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;


    $Capa = $livroEdit['capa'] ?? null; 
    if (!empty($_FILES["Capa"]["name"])) {
        $nomeArquivo = basename($_FILES["Capa"]["name"]);
        $destino = "../../Pages/imagens/" . $nomeArquivo;

        if (move_uploaded_file($_FILES["Capa"]["tmp_name"], $destino)) {
            $Capa = $nomeArquivo;
        }
    }

    if ($Titulo && $Autor) {
        if ($id) {
            $sql = "UPDATE livros SET titulo=?, autor=?, ano_publicacao=?, editora=?, capa=? WHERE id=?";
            $update = $conn->prepare($sql);
            $update->bind_param("ssissi", $Titulo, $Autor, $AnoPublicacao, $Editora, $Capa, $id);

            if ($update->execute()) {
                echo '<div class="w3-panel w3-green w3-padding w3-round">
                        <i class="fa fa-check"></i> Livro atualizado com sucesso!
                      </div>';
                $livroEdit = null;
                header("Location: pagelivros.php");
                exit;
            } else {
                echo '<div class="w3-panel w3-red w3-padding w3-round">
                        <i class="fa fa-times"></i> Erro ao atualizar: ' . $conn->error . '
                      </div>';
            }
            $update->close();
        } 
        // Se NÃO tem ID, é CADASTRO
        else {
            $sql = "INSERT INTO livros (titulo, autor, ano_publicacao, editora, capa) VALUES (?, ?, ?, ?, ?)";
            $insert = $conn->prepare($sql);
            $insert->bind_param("ssiss", $Titulo, $Autor, $AnoPublicacao, $Editora, $Capa);

            if ($insert->execute()) {
                echo '<div class="w3-panel w3-green w3-padding w3-round">
                        <i class="fa fa-check"></i> Livro cadastrado com sucesso!
                      </div>';
            } else {
                echo '<div class="w3-panel w3-red w3-padding w3-round">
                        <i class="fa fa-times"></i> Erro ao cadastrar: ' . $conn->error . '
                      </div>';
            }
            $insert->close();
        }
    } else {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-exclamation-triangle"></i> Título e Autor são obrigatórios.
              </div>';
    }
}
?>

<div class="w3-container w3-margin-top">
    <h1 class="w3-text-brown">
        <i class="fa fa-book"></i> <?= $livroEdit ? 'Editar Livro' : 'Cadastro de Livros' ?>
    </h1>
    <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
</div>

<div class="w3-container w3-margin-top">
    <form id="livroForm" action="pagelivros.php" method="POST" enctype="multipart/form-data" 
          class="w3-card-4 w3-white w3-round-large w3-padding">

        <?php if ($livroEdit): ?>
            <input type="hidden" name="id" value="<?= $livroEdit['id'] ?>">
        <?php endif; ?>

        <div class="w3-row-padding">
            <div class="w3-half">
                <label><b><i class="fa fa-tag"></i> Título *</b></label>
                <input class="w3-input w3-border w3-round" type="text" name="Titulo" 
                       value="<?= htmlspecialchars($livroEdit['titulo'] ?? '') ?>" required>
            </div>

            <div class="w3-half">
                <label><b><i class="fa fa-user"></i> Autor *</b></label>
                <input class="w3-input w3-border w3-round" type="text" name="Autor" 
                       value="<?= htmlspecialchars($livroEdit['autor'] ?? '') ?>" required>
            </div>
        </div>

        <div class="w3-row-padding w3-margin-top">
            <div class="w3-half">
                <label><b><i class="fa fa-calendar"></i> Ano de Publicação *</b></label>
                <input class="w3-input w3-border w3-round" type="number" name="AnoPublicacao" 
                       value="<?= $livroEdit['ano_publicacao'] ?? '' ?>" 
                       min="1000" max="2100" required>
            </div>

            <div class="w3-half">
                <label><b><i class="fa fa-building"></i> Editora</b></label>
                <input class="w3-input w3-border w3-round" type="text" name="Editora" 
                       value="<?= htmlspecialchars($livroEdit['editora'] ?? '') ?>">
            </div>
        </div>

        <div class="w3-margin-top">
            <label><b><i class="fa fa-image"></i> Capa do Livro</b></label>
            <?php if ($livroEdit && !empty($livroEdit['capa'])): ?>
                <div class="w3-margin-bottom">
                    <img src="../../Pages/imagens/<?= htmlspecialchars($livroEdit['capa']) ?>" 
                         alt="Capa atual" style="max-width:150px; height:auto;">
                    <p class="w3-text-grey w3-small">Capa atual (envie nova para substituir)</p>
                </div>
            <?php endif; ?>
            <input class="w3-input w3-border w3-round" type="file" name="Capa" accept="image/*">
        </div>

        <div class="w3-margin-top w3-padding-16">
            <button type="submit" class="w3-button w3-green w3-round w3-large">
                <i class="fa fa-save"></i> <?= $livroEdit ? 'Atualizar' : 'Salvar' ?>
            </button>
            <?php if ($livroEdit): ?>
                <a href="pagelivros.php" class="w3-button w3-grey w3-round w3-large">
                    <i class="fa fa-times"></i> Cancelar Edição
                </a>
            <?php else: ?>
                <button type="button" class="w3-button w3-red w3-round w3-large"
                        onclick="document.getElementById('livroForm').reset()">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="w3-container w3-margin-top">
    <h2 class="w3-text-brown">
        <i class="fa fa-list"></i> Lista de Livros
    </h2>
    <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
</div>

<?php
$sqlLivros = "SELECT id, titulo, autor, ano_publicacao, editora, capa FROM livros ORDER BY id DESC";
$result = $conn->query($sqlLivros);

if ($result->num_rows > 0): ?>
    <div class="w3-container w3-margin-top">
        <div class="w3-responsive">
            <table class="w3-table-all w3-hoverable w3-card-4">
                <thead>
                    <tr class="w3-brown">
                        <th><i class="fa fa-hashtag"></i> ID</th>
                        <th><i class="fa fa-image"></i> Capa</th>
                        <th><i class="fa fa-book"></i> Título</th>
                        <th><i class="fa fa-user"></i> Autor</th>
                        <th><i class="fa fa-calendar"></i> Ano</th>
                        <th><i class="fa fa-building"></i> Editora</th>
                        <th><i class="fa fa-cog"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($livro = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $livro['id'] ?></td>
                            <td>
                                <?php if(!empty($livro['capa']) && file_exists("../../Pages/imagens/".$livro['capa'])): ?>
                                    <img src="../../Pages/imagens/<?= htmlspecialchars($livro['capa']) ?>" 
                                         alt="<?= htmlspecialchars($livro['titulo']) ?>" 
                                         style="width:60px; height:80px; object-fit:cover;">
                                <?php else: ?>
                                    <div class="w3-light-grey w3-center w3-round" style="width:60px; height:80px; line-height:80px;">
                                        <i class="fa fa-book fa-2x w3-text-grey"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= htmlspecialchars($livro['titulo']) ?></strong></td>
                            <td><?= htmlspecialchars($livro['autor']) ?></td>
                            <td><?= htmlspecialchars($livro['ano_publicacao']) ?></td>
                            <td><?= htmlspecialchars($livro['editora']) ?: '<span class="w3-text-grey">-</span>' ?></td>
                            <td>
                                <a href="pagelivros.php?editar=<?= $livro['id'] ?>"
                                   class="w3-button w3-blue w3-round w3-small">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <a href="pagelivros.php?excluir=<?= $livro['id'] ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir este livro?')" 
                                   class="w3-button w3-red w3-round w3-small">
                                    <i class="fa fa-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="w3-container w3-margin-top">
        <div class="w3-panel w3-pale-yellow w3-border w3-round-large w3-center">
            <p><i class="fa fa-info-circle"></i> Nenhum livro cadastrado ainda.</p>
        </div>
    </div>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>