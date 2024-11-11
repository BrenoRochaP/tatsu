<?php
session_start();
include('data/conexao.php');

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

$usuario_id = 1; // Usuário simulado
$endereco = $_POST['endereco'] ?? '';
$numero = $_POST['numero'] ?? '';
$cidade = $_POST['cidade'] ?? '';
$cep = $_POST['cep'] ?? '';
$pagamento = $_POST['pagamento'] ?? '';

$endereco_id = 1; // Insira aqui o ID do endereço desejado
$status_pagamento = isset($_POST['status_pagamento']) ? $_POST['status_pagamento'] : 'pendente';

$total = isset($_POST['total']) ? $_POST['total'] : 0;

$sql_pedido = "INSERT INTO pedidos (usuario_id, endereco_id, total, status_pagamento, data_pedido) VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql_pedido);
$stmt->bind_param("iiis", $usuario_id, $endereco_id, $total, $status_pagamento);
$stmt->execute();
$pedido_id = $stmt->insert_id;

foreach ($_SESSION['carrinho'] as $product_id => $quantidade) {
    $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade) VALUES (?, ?, ?)";
    $stmt_item = $conn->prepare($sql_item);
    $stmt_item->bind_param("iii", $pedido_id, $product_id, $quantidade);
    $stmt_item->execute();
}

unset($_SESSION['carrinho']);
header("Location: pedidos.php");
exit;
?>
