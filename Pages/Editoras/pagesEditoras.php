<?php include("../../Controllers/validar_sessao.php"); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏢 Cadastro de Editoras</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php
    include("../../dados/conexao/conexao.php");
    include("../../Components/menu/menu.php");

    $editoraEdit = null;
    if (isset($_GET['editar'])) {
        $id = intval($_GET['editar']);
        $sqlEdit = "SELECT * FROM editoras WHERE id = ?";
        $stmtEdit = $conn->prepare($sqlEdit);
        $stmtEdit->bind_param("i", $id);
        $stmtEdit->execute();
        $resultEdit = $stmtEdit->get_result();
        $editoraEdit = $resultEdit->fetch_assoc();
        $stmtEdit->close();
    }

    if (isset($_GET['excluir'])) {
        $id = intval($_GET['excluir']);

        $sqlCheck = "SELECT COUNT(*) as total FROM livros WHERE editora = (SELECT nome FROM editoras WHERE id = ?)";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $check = $resultCheck->fetch_assoc();

        if ($check['total'] > 0) {
            echo '<div class="w3-panel w3-red w3-padding w3-round">
                <i class="fa fa-exclamation-triangle"></i> 
                Não é possível excluir! Esta editora possui ' . $check['total'] . ' livro(s) cadastrado(s).
              </div>';
        } else {
            $sqlDel = "DELETE FROM editoras WHERE id = ?";
            $stmt = $conn->prepare($sqlDel);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo '<div class="w3-panel w3-green w3-padding w3-round">
                    <i class="fa fa-check"></i> Editora excluída com sucesso!
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

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $Nome = trim($_POST["Nome"] ?? "");
        $Pais = trim($_POST["Pais"] ?? "");
        $Cidade = trim($_POST["Cidade"] ?? "");
        $AnoFundacao = !empty($_POST["AnoFundacao"]) ? intval($_POST["AnoFundacao"]) : null;
        $Site = trim($_POST["Site"] ?? "");
        $Email = trim($_POST["Email"] ?? "");
        $Telefone = trim($_POST["Telefone"] ?? "");
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;

        if ($Nome) {

            if ($id) {
                if ($AnoFundacao !== null) {
                    $sql = "UPDATE editoras SET nome=?, pais=?, cidade=?, ano_fundacao=?, site=?, email=?, telefone=? WHERE id=?";
                    $update = $conn->prepare($sql);
                    $update->bind_param("sssisssi", $Nome, $Pais, $Cidade, $AnoFundacao, $Site, $Email, $Telefone, $id);
                } else {
                    $sql = "UPDATE editoras SET nome=?, pais=?, cidade=?, site=?, email=?, telefone=? WHERE id=?";
                    $update = $conn->prepare($sql);
                    $update->bind_param("ssssssi", $Nome, $Pais, $Cidade, $Site, $Email, $Telefone, $id);
                }

                if ($update->execute()) {
                    echo '<div class="w3-panel w3-green w3-padding w3-round">
                            <i class="fa fa-check"></i> Editora atualizada com sucesso!
                          </div>';
                    $editoraEdit = null; // Limpar formulário
                    header("Location: pagesEditoras.php"); // Recarregar página
                    exit;
                } else {
                    echo '<div class="w3-panel w3-red w3-padding w3-round">
                            <i class="fa fa-times"></i> Erro ao atualizar: ' . $conn->error . '
                          </div>';
                }
                $update->close();
            } 
            else {
                $sqlCheck = "SELECT id FROM editoras WHERE nome = ?";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->bind_param("s", $Nome);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    echo '<div class="w3-panel w3-amber w3-padding w3-round">
                        <i class="fa fa-exclamation"></i> Esta editora já está cadastrada!
                      </div>';
                } else {
                    if ($AnoFundacao !== null) {
                        $sql = "INSERT INTO editoras (nome, pais, cidade, ano_fundacao, site, email, telefone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $insert = $conn->prepare($sql);
                        $insert->bind_param("sssisss", $Nome, $Pais, $Cidade, $AnoFundacao, $Site, $Email, $Telefone);
                    } else {
                        $sql = "INSERT INTO editoras (nome, pais, cidade, site, email, telefone) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                        $insert = $conn->prepare($sql);
                        $insert->bind_param("ssssss", $Nome, $Pais, $Cidade, $Site, $Email, $Telefone);
                    }

                    if ($insert->execute()) {
                        echo '<div class="w3-panel w3-green w3-padding w3-round">
                            <i class="fa fa-check"></i> Editora cadastrada com sucesso!
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
                <i class="fa fa-exclamation-triangle"></i> O nome da editora é obrigatório.
              </div>';
        }
    }
    ?>

    <div class="w3-container w3-margin-top">
        <h1 class="w3-text-brown">
            <i class="fa fa-building"></i> <?= $editoraEdit ? 'Editar Editora' : 'Cadastro de Editoras' ?>
        </h1>
        <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
    </div>

    <div class="w3-container w3-margin-top">
        <form id="editoraForm" action="pagesEditoras.php" method="POST"
            class="w3-card-4 w3-white w3-round-large w3-padding">

            <?php if ($editoraEdit): ?>
                <input type="hidden" name="id" value="<?= $editoraEdit['id'] ?>">
            <?php endif; ?>

            <div class="w3-row-padding">
                <div class="w3-half">
                    <label><b><i class="fa fa-tag"></i> Nome da Editora *</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="Nome" 
                           value="<?= htmlspecialchars($editoraEdit['nome'] ?? '') ?>" required>
                </div>

                <div class="w3-half">
                    <label><b><i class="fa fa-globe"></i> País</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="Pais" 
                           value="<?= htmlspecialchars($editoraEdit['pais'] ?? '') ?>" 
                           placeholder="Ex: Brasil">
                </div>
            </div>

            <div class="w3-row-padding w3-margin-top">
                <div class="w3-half">
                    <label><b><i class="fa fa-map-marker"></i> Cidade</b></label>
                    <input class="w3-input w3-border w3-round" type="text" name="Cidade" 
                           value="<?= htmlspecialchars($editoraEdit['cidade'] ?? '') ?>" 
                           placeholder="Ex: São Paulo">
                </div>

                <div class="w3-half">
                    <label><b><i class="fa fa-calendar"></i> Ano de Fundação</b></label>
                    <input class="w3-input w3-border w3-round" type="number" name="AnoFundacao" 
                           value="<?= $editoraEdit['ano_fundacao'] ?? '' ?>" 
                           min="1800" max="2025" placeholder="Ex: 1990">
                </div>
            </div>

            <div class="w3-row-padding w3-margin-top">
                <div class="w3-third">
                    <label><b><i class="fa fa-link"></i> Website</b></label>
                    <input class="w3-input w3-border w3-round" type="url" name="Site" 
                           value="<?= htmlspecialchars($editoraEdit['site'] ?? '') ?>" 
                           placeholder="https://exemplo.com">
                </div>

                <div class="w3-third">
                    <label><b><i class="fa fa-envelope"></i> E-mail</b></label>
                    <input class="w3-input w3-border w3-round" type="email" name="Email" 
                           value="<?= htmlspecialchars($editoraEdit['email'] ?? '') ?>" 
                           placeholder="contato@editora.com">
                </div>

                <div class="w3-third">
                    <label><b><i class="fa fa-phone"></i> Telefone</b></label>
                    <input class="w3-input w3-border w3-round" type="tel" name="Telefone" 
                           value="<?= htmlspecialchars($editoraEdit['telefone'] ?? '') ?>" 
                           placeholder="(11) 1234-5678">
                </div>
            </div>

            <div class="w3-margin-top w3-padding-16">
                <button type="submit" class="w3-button w3-green w3-round w3-large">
                    <i class="fa fa-save"></i> <?= $editoraEdit ? 'Atualizar' : 'Salvar' ?>
                </button>
                <?php if ($editoraEdit): ?>
                    <a href="pagesEditoras.php" class="w3-button w3-grey w3-round w3-large">
                        <i class="fa fa-times"></i> Cancelar Edição
                    </a>
                <?php else: ?>
                    <button type="button" class="w3-button w3-red w3-round w3-large"
                            onclick="document.getElementById('editoraForm').reset()">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="w3-container w3-margin-top">
        <h2 class="w3-text-brown">
            <i class="fa fa-list"></i> Lista de Editoras
        </h2>
        <div class="w3-border-bottom w3-border-brown" style="width:100px; border-width:3px !important;"></div>
    </div>

    <?php
    $sqlEditoras = "SELECT e.*, 
                (SELECT COUNT(*) FROM livros WHERE editora = e.nome) as total_livros 
                FROM editoras e 
                ORDER BY e.nome ASC";
    $result = $conn->query($sqlEditoras);

    if ($result->num_rows > 0): ?>
        <div class="w3-container w3-margin-top">
            <div class="w3-responsive">
                <table class="w3-table-all w3-hoverable w3-card-4">
                    <thead>
                        <tr class="w3-brown">
                            <th><i class="fa fa-hashtag"></i> ID</th>
                            <th><i class="fa fa-building"></i> Nome</th>
                            <th><i class="fa fa-map-marker"></i> Localização</th>
                            <th><i class="fa fa-calendar"></i> Fundação</th>
                            <th><i class="fa fa-book"></i> Livros</th>
                            <th><i class="fa fa-info-circle"></i> Contato</th>
                            <th><i class="fa fa-cog"></i> Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($editora = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $editora['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($editora['nome']) ?></strong>
                                    <?php if (!empty($editora['site'])): ?>
                                        <br>
                                        <a href="<?= htmlspecialchars($editora['site']) ?>" target="_blank" class="w3-text-blue">
                                            <i class="fa fa-external-link"></i> Site
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($editora['cidade']) || !empty($editora['pais'])): ?>
                                        <?= htmlspecialchars($editora['cidade']) ?>
                                        <?= !empty($editora['cidade']) && !empty($editora['pais']) ? ', ' : '' ?>
                                        <?= htmlspecialchars($editora['pais']) ?>
                                    <?php else: ?>
                                        <span class="w3-text-grey">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $editora['ano_fundacao'] ? htmlspecialchars($editora['ano_fundacao']) :
                                        '<span class="w3-text-grey">-</span>' ?>
                                </td>
                                <td>
                                    <span class="w3-tag w3-round w3-green">
                                        <?= $editora['total_livros'] ?> livro(s)
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($editora['email']) || !empty($editora['telefone'])): ?>
                                        <?php if (!empty($editora['email'])): ?>
                                            <i class="fa fa-envelope"></i> <?= htmlspecialchars($editora['email']) ?><br>
                                        <?php endif; ?>
                                        <?php if (!empty($editora['telefone'])): ?>
                                            <i class="fa fa-phone"></i> <?= htmlspecialchars($editora['telefone']) ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="w3-text-grey">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="pagesEditoras.php?editar=<?= $editora['id'] ?>"
                                       class="w3-button w3-blue w3-round w3-small">
                                        <i class="fa fa-pencil"></i> Editar
                                    </a>
                                    <a href="pagesEditoras.php?excluir=<?= $editora['id'] ?>"
                                        onclick="return confirm('Tem certeza que deseja excluir esta editora?')"
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
                <p><i class="fa fa-info-circle"></i> Nenhuma editora cadastrada ainda.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php $conn->close(); ?>

</body>

</html>