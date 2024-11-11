<?php
session_start();
include('data/conexao.php');

// Verifica se o carrinho está vazio
if (empty($_SESSION['carrinho'])) {
    echo "Erro: O carrinho está vazio.";
    exit();
}

// Simulando o ID do usuário logado
$usuario_id = 1; // Altere conforme necessário

// Calcula o total do pedido
$total_pedido = 0;
$itens_pedido = [];

// Prepara a consulta para obter o preço dos itens do carrinho
$sql = "SELECT id, preco FROM item WHERE id = ?";
$stmt = $conn->prepare($sql);

// Processa cada item no carrinho
foreach ($_SESSION['carrinho'] as $item_id => $quantidade) {
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o item existe no banco de dados
    if ($result->num_rows === 0) {
        echo "Erro: Item com ID $item_id não encontrado no banco de dados.";
        exit();
    }

    // Obtém o preço do item
    $item = $result->fetch_assoc();
    $preco = $item['preco'];

    // Calcula o subtotal do item e adiciona ao total do pedido
    $subtotal = $preco * $quantidade;
    $total_pedido += $subtotal;

    // Adiciona o item ao array de itens do pedido
    $itens_pedido[] = [
        'item_id' => $item_id,
        'quantidade' => $quantidade,
        'preco' => $preco
    ];
}

// Insere o pedido na tabela `pedidos`
$sql_pedido = "INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("id", $usuario_id, $total_pedido);

if ($stmt_pedido->execute()) {
    $pedido_id = $stmt_pedido->insert_id;

    // Insere cada item do pedido na tabela `itens_pedido`
    $sql_item_pedido = "INSERT INTO itens_pedido (pedido_id, item_id, quantidade, preco) VALUES (?, ?, ?, ?)";
    $stmt_item_pedido = $conn->prepare($sql_item_pedido);

    foreach ($itens_pedido as $item) {
        $stmt_item_pedido->bind_param("iiid", $pedido_id, $item['item_id'], $item['quantidade'], $item['preco']);
        $stmt_item_pedido->execute();
    }

    // Limpa o carrinho após processar o pedido
    unset($_SESSION['carrinho']);

    // Redireciona para a página de pedidos com uma mensagem de sucesso
    header("Location: pedidos.php?sucesso=1");
    exit();
} else {
    echo "Erro ao registrar o pedido: " . $stmt_pedido->error;
}

$stmt->close();
$stmt_pedido->close();
$stmt_item_pedido->close();
$conn->close();
?>
