<?php
session_start();
include 'data/conexao.php';

// Atualizar status do pedido
if (isset($_POST['pedido_id']) && isset($_POST['status'])) {
    $pedido_id = intval($_POST['pedido_id']);
    $status = $_POST['status']; // 'pago' ou 'entregue'

    $sql = "UPDATE pedidos SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $pedido_id);
    $stmt->execute();

    echo "Status do pedido atualizado para: " . htmlspecialchars($status);
    exit();
}
?>