<?php
session_start();
include('data/conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedido_id = $_POST['pedido_id'];
    $status = $_POST['status'];

    // Atualiza o status no banco de dados
    $sqlUpdate = "UPDATE pedidos SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("si", $status, $pedido_id);

    if ($stmt->execute()) {
        // Redireciona de volta para a página de pedidos
        header("Location: delivery_adm.php");
        exit();
    } else {
        echo "Erro ao atualizar o status: " . $stmt->error;
    }
}
$conn->close();
?>