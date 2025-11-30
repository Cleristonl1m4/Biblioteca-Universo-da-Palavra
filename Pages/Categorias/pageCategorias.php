<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏷️ Cadastro de Categorias</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php
include("../../dados/conexao/conexao.php");
include("../../Components/menu/menu.html");

// Buscar categoria para editar
$categoriaEdit = null;
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $sqlEdit = "SELECT * FROM categorias WHERE id = ?";
    $stmtEdit = $conn->prepare($sqlEdit);
    $stmtEdit->bind_param("i", $id);
    $stmtEdit->execute();
    $resultEdit = $stmtEdit->get_result();
    $categoriaEdit = $resultEdit->fetch_assoc();
    $stmtEdit->close();
}

// Excluir categoria
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    
    // Verificar se a categoria está sendo usada em algum livro
    $sqlCheck = "SELECT COUNT(*) as total FROM livros WHERE categoria = (SELECT nome FROM categorias WHERE id = ?)";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $check = $resultCheck->fetch_assoc();
    
    if ($check['total'] > 0) {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-exclamation-triangle"></i> 
                Não é possível excluir! Esta categoria possui ' . $check['total'] . ' livro(s) cadastrado(s).
              </div>';
    } else {
        $sqlDel = "DELETE FROM categorias WHERE id = ?";
        $stmt = $conn->prepare($sqlDel);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo '<div class="w3-panel w3-green w3-padding w3-round">
                    <i class="fa fa-check"></i> Categoria excluída com sucesso!
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

// Cadastrar ou atualizar categoria
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $Nome = trim($_POST["Nome"] ?? "");
    $Descricao = trim($_POST["Descricao"] ?? "");
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;

    if ($Nome) {
        // Se tem ID, é EDIÇÃO
        if ($id) {
            $sql = "UPDATE categorias SET nome=?, descricao=? WHERE id=?";
            $update = $conn->prepare($sql);
            $update->bind_param("ssi", $Nome, $Descricao, $id);

            if ($update->execute()) {
                echo '<div class="w3-panel w3-green w3-padding w3-round">
                        <i class="fa fa-check"></i> Categoria atualizada com sucesso!
                      </div>';
                $categoriaEdit = null;
                header("Location: pageCategorias.php");
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
            // Verificar se categoria já existe
            $sqlCheck = "SELECT id FROM categorias WHERE nome = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("s", $Nome);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                echo '<div class="w3-panel w3-amber w3-padding w3-round">
                        <i class="fa fa-exclamation"></i> Esta categoria já está cadastrada!
                      </div>';
            } else {
                $sql = "INSERT INTO categorias (nome, descricao) VALUES (?, ?)";
                $insert = $conn->prepare($sql);
                $insert->bind_param("ss", $Nome, $Descricao);

                if ($insert->execute()) {
                    echo '<div class="w3-panel w3-green w3-padding w3-round">
                            <i class="fa fa-check"></i> Categoria cadastrada com sucesso!
                          </div>';
                } else {
                    echo '<div class="w3-panel w3-red w3-padding w3-round">
                            <i class="fa fa-times"></i> Erro ao cadastrar: ' . $conn->error . '
                          </div>';
                }
                $insert->close();
            }
            $stmtCheck->close();
        }
    } else {
        echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-exclamation-triangle"></i> O nome da categoria é obrigatório.
              </div>';
    }
}
?>

<div class="w3-container w3-margin-top">
    <h1 class="w3-text-brown">
        <i class="fa fa-tags"></i> <?= $categoriaEdit ? 'Editar Categoria' : 'Cadastro de Categorias' ?>
    </h1>
    <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
</div>

<div class="w3-container w3-margin-top">
    <form id="categoriaForm" action="pageCategorias.php" method="POST" 
          class="w3-card-4 w3-white w3-round-large w3-padding">

        <?php if ($categoriaEdit): ?>
            <input type="hidden" name="id" value="<?= $categoriaEdit['id'] ?>">
        <?php endif; ?>

        <div class="w3-margin-bottom">
            <label><b><i class="fa fa-tag"></i> Nome da Categoria *</b></label>
            <input class="w3-input w3-border w3-round" type="text" name="Nome" 
                   value="<?= htmlspecialchars($categoriaEdit['nome'] ?? '') ?>" 
                   placeholder="Ex: Romance, Ficção Científica, Suspense..." required>
        </div>

        <div class="w3-margin-bottom">
            <label><b><i class="fa fa-file-text"></i> Descrição</b></label>
            <textarea class="w3-input w3-border w3-round" name="Descricao" rows="4" 
                      placeholder="Descreva a categoria (opcional)..."><?= htmlspecialchars($categoriaEdit['descricao'] ?? '') ?></textarea>
        </div>

        <div class="w3-margin-top w3-padding-16">
            <button type="submit" class="w3-button w3-green w3-round w3-large">
                <i class="fa fa-save"></i> <?= $categoriaEdit ? 'Atualizar' : 'Salvar' ?>
            </button>
            <?php if ($categoriaEdit): ?>
                <a href="pageCategorias.php" class="w3-button w3-grey w3-round w3-large">
                    <i class="fa fa-times"></i> Cancelar Edição
                </a>
            <?php else: ?>
                <button type="button" class="w3-button w3-red w3-round w3-large"
                        onclick="document.getElementById('categoriaForm').reset()">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="w3-container w3-margin-top">
    <h2 class="w3-text-brown">
        <i class="fa fa-list"></i> Lista de Categorias
    </h2>
    <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
</div>

<?php
$sqlCategorias = "SELECT c.*, 
                (SELECT COUNT(*) FROM livros WHERE categoria = c.nome) as total_livros 
                FROM categorias c 
                ORDER BY c.nome ASC";
$result = $conn->query($sqlCategorias);

if ($result->num_rows > 0): ?>
    <div class="w3-container w3-margin-top">
        <div class="w3-responsive">
            <table class="w3-table-all w3-hoverable w3-card-4">
                <thead>
                    <tr class="w3-brown">
                        <th><i class="fa fa-hashtag"></i> ID</th>
                        <th><i class="fa fa-tag"></i> Nome</th>
                        <th><i class="fa fa-file-text"></i> Descrição</th>
                        <th><i class="fa fa-book"></i> Livros</th>
                        <th><i class="fa fa-cog"></i> Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($categoria = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $categoria['id'] ?></td>
                            <td><strong><?= htmlspecialchars($categoria['nome']) ?></strong></td>
                            <td>
                                <?php if(!empty($categoria['descricao'])): ?>
                                    <div style="max-width:400px;">
                                        <?= htmlspecialchars(substr($categoria['descricao'], 0, 100)) ?>
                                        <?= strlen($categoria['descricao']) > 100 ? '...' : '' ?>
                                    </div>
                                <?php else: ?>
                                    <span class="w3-text-grey">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="w3-tag w3-round w3-green">
                                    <?= $categoria['total_livros'] ?> livro(s)
                                </span>
                            </td>
                            <td>
                                <a href="pageCategorias.php?editar=<?= $categoria['id'] ?>"
                                   class="w3-button w3-blue w3-round w3-small">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <a href="pageCategorias.php?excluir=<?= $categoria['id'] ?>"
                                   onclick="return confirm('Tem certeza que deseja excluir esta categoria?')"
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
            <p><i class="fa fa-info-circle"></i> Nenhuma categoria cadastrada ainda.</p>
        </div>
    </div>
<?php endif; ?>

<?php $conn->close(); ?>

</body>
</html>