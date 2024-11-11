<?php
session_start();
include('data/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    echo '<script>alert("Você precisa estar logado para acessar esta página.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}

// Verifica se o endereco_id foi enviado
if (isset($_POST['endereco_id'])) {
    $_SESSION['endereco_id'] = intval($_POST['endereco_id']);
    echo '<script>alert("Endereço selecionado com sucesso.");</script>';
    echo '<script>window.location.href = "carrinho.php";</script>'; // Redireciona para a página do carrinho
} else {
    echo '<script>alert("Nenhum endereço selecionado.");</script>';
    echo '<script>window.location.href = "endereco.php";</script>'; // Redireciona de volta para seleção de endereço
}
?>