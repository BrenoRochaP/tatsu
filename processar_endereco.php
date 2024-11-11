<!-- INICIO PHP -->
<?php
session_start();
include('data/conexao.php');

if (!isset($_SESSION['email'])) {
    echo '<script>alert("Você precisa estar logado para acessar esta página.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}

if (isset($_POST['endereco_id'])) {
    $_SESSION['endereco_id'] = intval($_POST['endereco_id']);
    echo '<script>alert("Endereço selecionado com sucesso.");</script>';
    echo '<script>window.location.href = "carrinho.php";</script>';
} else {
    echo '<script>alert("Nenhum endereço selecionado.");</script>';
    echo '<script>window.location.href = "endereco.php";</script>';
}
?>
<!-- FIM PHP -->