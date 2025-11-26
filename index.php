<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Biblioteca Universo da Palavra</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php
    include("dados/conexao/conexao.php");
    include("Components/menu/menu.html");

    $sqlLivros = "SELECT titulo, autor, capa FROM livros ORDER BY id DESC LIMIT 6";
    $resultLivros = $conn->query($sqlLivros);

    $sqlAutores = "SELECT Nome, Biografia FROM autor ORDER BY RAND() LIMIT 3";
    $resultAutores = $conn->query($sqlAutores);
    ?>

    <header class="w3-container w3-brown w3-padding-64 w3-center">
        <h1 class="w3-jumbo w3-animate-top">📖 Universo da Palavra</h1>
        <p class="w3-xlarge">Explore mundos infinitos através da leitura</p>
    </header>

    <div class="w3-container w3-padding-32">
        <div class="w3-card-4 w3-white w3-round-large w3-padding" style="max-width:800px; margin:0 auto;">
            <form method="GET" action="buscar.php">
                <div class="w3-row">
                    <div class="w3-col s9 m10">
                        <input class="w3-input w3-border-0" type="text" name="q"
                            placeholder="🔍 Buscar livros, autores, editoras...">
                    </div>
                    <div class="w3-col s3 m2">
                        <button class="w3-button w3-green w3-round w3-block">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="w3-container w3-padding-32">
        <div class="w3-center w3-padding-16">
            <h2 class="w3-xxxlarge w3-text-green"><i class="fa fa-book"></i> Últimos Livros</h2>
            <div class="w3-border-top w3-border-green"
                style="width:80px; margin:10px auto; border-width:3px !important;"></div>
        </div>

        <?php if ($resultLivros->num_rows > 0): ?>
            <div class="w3-row-padding w3-margin-top">
                <?php while ($livro = $resultLivros->fetch_assoc()): ?>
                    <div class="w3-col l4 m6 s12 w3-margin-bottom">
                        <div class="w3-card-4 w3-white w3-round-large w3-hover-shadow">
                            <div class="w3-container w3-center w3-padding-32">
                                <?php if (!empty($livro['capa']) && file_exists("Pages/imagens/" . $livro['capa'])): ?>
                                    <img src="Pages/imagens/<?= htmlspecialchars($livro['capa']) ?>"
                                        alt="<?= htmlspecialchars($livro['titulo']) ?>" class="w3-round"
                                        style="max-width:150px; height:200px; object-fit:cover;">
                                <?php else: ?>
                                    <div class="w3-display-container w3-light-grey w3-round"
                                        style="width:150px; height:200px; margin:0 auto;">
                                        <div class="w3-display-middle">
                                            <i class="fa fa-book fa-4x w3-text-grey"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <h3 class="w3-text-brown w3-margin-top"><?= htmlspecialchars($livro['titulo']) ?></h3>
                                <p class="w3-text-grey"><i class="fa fa-user"></i> <?= htmlspecialchars($livro['autor']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="w3-panel w3-pale-yellow w3-border w3-round-large w3-center">
                <p><i class="fa fa-info-circle"></i> Nenhum livro cadastrado ainda.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="w3-container w3-light-grey w3-padding-64">
        <div class="w3-center w3-padding-16">
            <h2 class="w3-xxxlarge w3-text-brown"><i class="fa fa-pencil"></i> Autores em Destaque</h2>
            <div class="w3-border-top w3-border-brown"
                style="width:80px; margin:10px auto; border-width:3px !important;"></div>
        </div>

        <?php if ($resultAutores->num_rows > 0): ?>
            <div class="w3-row-padding w3-margin-top">
                <?php while ($autor = $resultAutores->fetch_assoc()): ?>
                    <div class="w3-col l4 m6 s12 w3-margin-bottom">
                        <div class="w3-card-4 w3-white w3-round-large w3-hover-shadow w3-leftbar w3-border-green w3-padding">
                            <h3 class="w3-text-brown">
                                <i class="fa fa-user-circle"></i> <?= htmlspecialchars($autor['Nome']) ?>
                            </h3>
                            <p class="w3-text-grey">
                                <?= htmlspecialchars(substr($autor['Biografia'], 0, 150)) ?>
                                <?= strlen($autor['Biografia']) > 150 ? '...' : '' ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="w3-panel w3-pale-yellow w3-border w3-round-large w3-center">
                <p><i class="fa fa-info-circle"></i> Nenhum autor cadastrado ainda.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="w3-container w3-padding-64 w3-center">
        <?php
        $sqlStats = "SELECT 
    (SELECT COUNT(*) FROM livros) as total_livros,
    (SELECT COUNT(*) FROM autor) as total_autores,
    (SELECT COUNT(DISTINCT editora) FROM livros) as total_editoras";
        $resultStats = $conn->query($sqlStats);
        $stats = $resultStats->fetch_assoc();
        ?>

        <div class="w3-row-padding">
            <div class="w3-third">
                <div class="w3-card-4 w3-green w3-round-large w3-padding-32 w3-animate-zoom">
                    <i class="fa fa-book fa-3x"></i>
                    <h3 class="w3-jumbo"><?= $stats['total_livros'] ?></h3>
                    <p class="w3-large">Livros</p>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-brown w3-round-large w3-padding-32 w3-animate-zoom">
                    <i class="fa fa-users fa-3x"></i>
                    <h3 class="w3-jumbo"><?= $stats['total_autores'] ?></h3>
                    <p class="w3-large">Autores</p>
                </div>
            </div>
            <div class="w3-third">
                <div class="w3-card-4 w3-amber w3-round-large w3-padding-32 w3-animate-zoom">
                    <i class="fa fa-building fa-3x"></i>
                    <h3 class="w3-jumbo"><?= $stats['total_editoras'] ?></h3>
                    <p class="w3-large">Editoras</p>
                </div>
            </div>

            
        </div>
    </div>
    <footer class="w3-container w3-brown w3-padding-32 w3-center">
        <p class="w3-large"><i class="fa fa-heart"></i> © 2025 Biblioteca Universo da Palavra</p>
        
    </footer>

    <?php
    $conn->close();
    ?>

</body>

</html>