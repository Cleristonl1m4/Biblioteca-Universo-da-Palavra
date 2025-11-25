<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Biblioteca Universo da Palavra</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-light-grey w3-margin-0 w3-padding-0">

<?php
include("dados/conexao/conexao.php");
include("Components/menu/menu.html");

$sqlLivros = "SELECT titulo, autor, capa FROM livros ORDER BY id DESC LIMIT 5";
$resultLivros = $conn->query($sqlLivros);

$sqlAutores = "SELECT Nome, Biografia FROM autor ORDER BY RAND() LIMIT 3";
$resultAutores = $conn->query($sqlAutores);
?>

<header class="w3-center w3-padding-32 w3-card w3-white">
    <h1 class="w3-text-green">📖 Biblioteca Universo da Palavra</h1>
    <p class="w3-large w3-text-grey">Descubra o poder das palavras</p>
</header>

<section class="w3-card w3-white w3-padding w3-margin w3-round-large">
    <form method="GET" action="buscar.php" class="w3-container">
        <input class="w3-input w3-border w3-round w3-margin-bottom" type="text" name="q" placeholder="Buscar livros, autores, editoras...">
        <button class="w3-button w3-green w3-round w3-large">
            <i class="fa fa-search"></i> Pesquisar
        </button>
    </form>
</section>

<section class="w3-margin-bottom w3-container">
    <h2 class="w3-text-indigo">📚 Últimos Livros</h2>
    <div class="w3-row-padding">
        <?php while($livro = $resultLivros->fetch_assoc()): ?>
            <div class="w3-third w3-card w3-white w3-padding w3-center w3-hover-shadow w3-round-large w3-margin-bottom">
                <?php if(!empty($livro['capa'])): ?>
                    <img src="Pages/imagens/<?= $livro['capa'] ?>" alt="<?= $livro['titulo'] ?>" class="w3-image w3-round" style="max-width:150px">
                <?php else: ?>
                    <img src="Pages/imagens/alquimista.jpg" alt="Sem capa" class="w3-image w3-round" style="max-width:150px">
                <?php endif; ?>
                <h3 class="w3-text-brown"><?= $livro['titulo'] ?></h3>
                <p class="w3-text-grey"><?= $livro['autor'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<section class="w3-margin-bottom w3-container">
    <h2 class="w3-text-indigo">✍️ Autores em Destaque</h2>
    <div class="w3-row-padding">
        <?php while($autor = $resultAutores->fetch_assoc()): ?>
            <div class="w3-third w3-card w3-white w3-padding w3-margin-bottom w3-hover-shadow w3-round-large">
                <h3 class="w3-text-brown"><?= $autor['Nome'] ?></h3>
                <p class="w3-text-grey"><?= $autor['Biografia'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<footer class="w3-center w3-padding-16 w3-brown w3-text-white">
    <p>© 2025 Biblioteca Universo da Palavra</p>
</footer>

</body>
</html>