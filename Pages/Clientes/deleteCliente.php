<?php
include('../../dados/conexao/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = $_GET['id'];

    $sql = "DELETE FROM clientes WHERE id = ?";
    $result = $conn->prepare($sql);
    $result->bind_param("i", $id);

    if ($result->execute()) {
        echo '<div class="w3-panel w3-green">
            <h3>Concluido!</h3>
            <p>Exclusão realizada</p>
            </div>';
    } else {
        echo '<div class="w3-panel w3-red">
            <h3>Falha</h3>
            <p>Erro ao excluir registros</p>
            </div>';
    }
    $result->close();
    $conn->close();
} else {
    echo '<div class="w3-panel w3-yellow">
            <h3>Aviso</h3>
            <p>Aluno não encontrado</p>
            </div>';
}

header("location: /Universo-da-Palavra/Pages/Clientes/pageClientesCadastro.php");