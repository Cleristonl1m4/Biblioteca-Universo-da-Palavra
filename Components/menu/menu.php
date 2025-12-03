<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="w3-bar w3-brown">
    <a class="w3-bar-item w3-button fa fa-home" href="/Biblioteca-Universo-da-Palavra/index.php"> Home</a>
    <a class="w3-bar-item w3-button"
        href="/Biblioteca-Universo-da-Palavra/Pages/Alunos/pageAlunosCadastro.php">Alunos</a>
    <a class="w3-bar-item w3-button" href="/Biblioteca-Universo-da-Palavra/Pages/Autor/pageAutor.php">Autores</a>
    <a class="w3-bar-item w3-button" href="/Biblioteca-Universo-da-Palavra/Pages/livros/pagelivros.php">Livros</a>
    <a class="w3-bar-item w3-button"
        href="/Biblioteca-Universo-da-Palavra/Pages/Editoras/pagesEditoras.php">Editoras</a>
    <a class="w3-bar-item w3-button"
        href="/Biblioteca-Universo-da-Palavra/Pages/Categorias/pageCategorias.php">Categorias</a>
    <a class="w3-bar-item w3-button w3-right" href="http://localhost/Biblioteca-Universo-da-Palavra/Controllers/logout/logout.php
">Sair</a>
    <a class="w3-bar-item w3-right"><strong><?php echo $_SESSION['username']; ?></strong>!</a>
</div>