<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Biblioteca Universo da Palavra</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-container">

<?php
include("dados/conexao/conexao.php");
include("Components/menu/menu.html");


$sqlLivros = "SELECT titulo, autor, capa FROM livros ORDER BY id DESC LIMIT 5";
$resultLivros = $conn->query($sqlLivros);


$sqlAutores = "SELECT Nome, Biografia FROM autor ORDER BY RAND() LIMIT 3";
$resultAutores = $conn->query($sqlAutores);
?>

<header class="w3-center w3-padding-32">
    <h1 class="w3-text-green">📖 Biblioteca Universo da Palavra</h1>
    <p>Descubra o poder das palavras</p>
</header>


<section class="w3-card w3-padding w3-margin-bottom">
    <form method="GET" action="buscar.php" class="w3-container">
        <input class="w3-input w3-border" type="text" name="q" placeholder="Buscar livros, autores, editoras...">
        <button class="w3-button w3-green w3-margin-top">
            <i class="fa fa-search"></i> Pesquisar
        </button>
    </form>
</section>

<section class="w3-margin-bottom">
    <h2 class="w3-text-blue">📚 Últimos Livros</h2>
    <div class="w3-row-padding">
        <?php while($livro = $resultLivros->fetch_assoc()): ?>
            <div class="w3-third w3-card w3-padding w3-center w3-hover-shadow">
                <?php if(!empty($livro['capa'])): ?>
                    <img src="Pages/imagens/<?= $livro['capa'] ?>" alt="<?= $livro['titulo'] ?>" style="width:150px; height:auto;">
                <?php else: ?>
                    <img src="Pages/imagens/alquimista.jpg" alt="Sem capa" style="width:150px; height:auto;">
                <?php endif; ?>
                <h3><?= $livro['titulo'] ?></h3>
                <p><?= $livro['autor'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>


<section class="w3-margin-bottom">
    <h2 class="w3-text-blue">✍️ Autores em Destaque</h2>
    <div class="w3-row-padding">
        <?php while($autor = $resultAutores->fetch_assoc()): ?>
            <div class="w3-third w3-card w3-padding w3-margin-bottom w3-hover-shadow">
                <h3><?= $autor['Nome'] ?></h3>
                <p><?= $autor['Biografia'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<footer class="w3-center w3-padding-16 w3-light-grey">
    <p>© 2025 Biblioteca Universo da Palavra</p>
</footer>

</body>
</html>
