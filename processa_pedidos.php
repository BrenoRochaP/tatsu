<?php
session_start();
include('data/conexao.php');

// Verifica se a sessão está ativa
if (!isset($_SESSION['email'])) {
    echo '<script>alert("Você precisa estar logado para acessar esta página.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}

// Obtém o email do usuário logado
$email = $_SESSION['email'];

// Obtém o usuario_id a partir do email
$sql_usuario = "SELECT ID_USUARIO FROM usuario WHERE EMAIL_USUARIO = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
if ($result_usuario->num_rows > 0) {
    $usuario = $result_usuario->fetch_assoc();
    $usuario_id = $usuario['ID_USUARIO'];
} else {
    echo '<script>alert("Usuário não encontrado.");</script>';
    exit();
}

// Verifica se o endereço está na sessão
if (!isset($_SESSION['endereco_id'])) {
    echo '<script>alert("Você precisa selecionar um endereço.");</script>';
    echo '<script>window.location.href = "endereco.php";</script>';
    exit();
}

$endereco_id = $_SESSION['endereco_id']; // O ID do endereço deve ser armazenado na sessão
$status_pagamento = isset($_POST['status_pagamento']) ? $_POST['status_pagamento'] : 'pendente';

// Calcula o total do pedido
// Calcula o total do pedido
$total = 0;
if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $product_id => $quantidade) {
        // Obtém o preço do item a partir do seu ID
        $sql_preco = "SELECT preco FROM item WHERE id = ?";
        $stmt_preco = $conn->prepare($sql_preco);
        $stmt_preco->bind_param("i", $product_id);
        $stmt_preco->execute();
        $result_preco = $stmt_preco->get_result();

        // Verifica se o preço foi encontrado e é válido
        if ($result_preco->num_rows > 0) {
            $produto = $result_preco->fetch_assoc();
            $preco = $produto['preco'];

            // Verifica se o preço é válido (não é NULL ou inválido)
            if ($preco !== null && is_numeric($preco)) {
                $total += $preco * $quantidade;
            } else {
                echo '<script>alert("Preço do produto não encontrado ou inválido.");</script>';
                exit();
            }
        } else {
            echo '<script>alert("Produto não encontrado.");</script>';
            exit();
        }
    }
} else {
    echo '<script>alert("Carrinho vazio.");</script>';
    exit();
}


// Exibe o total do pedido
echo "<h2>Total do Pedido: R$ " . number_format($total, 2, ',', '.') . "</h2>";
echo '<form method="POST" action="finalizar_pedido.php">';
echo '<input type="hidden" name="total" value="' . $total . '">';
echo '<button type="submit">Finalizar Pedido</button>';
echo '</form>';
// O restante do código para inserir o pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insere o pedido
    $sql_pedido = "INSERT INTO pedidos (usuario_id, endereco_id, total, status_pagamento, data_pedido) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql_pedido);
    $stmt->bind_param("iiis", $usuario_id, $endereco_id, $total, $status_pagamento);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;

    // Insere os itens do pedido
    foreach ($_SESSION['carrinho'] as $product_id => $quantidade) {
        // Insere o item do pedido
        $sql_item = "INSERT INTO itens_pedido (pedido_id, item_id, quantidade, preco) VALUES (?, ?, ?, ?)";
        $stmt_item = $conn->prepare($sql_item);
        $stmt_item->bind_param("iids", $pedido_id, $product_id, $quantidade, $preco);
        $stmt_item->execute();
    }

    unset($_SESSION['carrinho']);
    header("Location: pedidos.php");
    exit;
}

$stmt_usuario->close();
$conn->close();
?>