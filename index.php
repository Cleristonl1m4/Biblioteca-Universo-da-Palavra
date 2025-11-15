<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 Biblioteca Universo da Palavra</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="w3-conteiner">
    <?php include("Components/menu/menu.html")?>
    <header class="w3-center w3-padding-32">
        <h1 class="w3-text-green">📖 Biblioteca Universo da Palavra</h1>
        <p>Descubra o poder das palavras</p>
    </header>

    <section class="w3-card w3-padding w3-margin-bottom">
        <form method="GET" action="buscar.php" class="w3-conteiner">
            <input class="w3-input w3-border" type="text" name="q" placeholder="Buscar Livros, Autors, Editoras...">
            <button class="w3-button w3-green w3-margin-top"> <i class="fa fa-search"></i>pesquisar</button>
        </form>
    </section>

    <section class="w3-margin-bottom">
        <h2 class="w3-text-blue">📚 Últimos Livros</h2>
        <ul class="w3-ul w3-card">
            <li><Strong>O Alquimista</Strong> - Paulo Coelho</li>
            <li><Strong>Dom  Casmuro</Strong> - Machado de Assis</li>
            <li><Strong>Grande Sertão: Veredas</Strong> - Guimarães Rosa</li>
        </ul>

    </section>


</body>
</html>