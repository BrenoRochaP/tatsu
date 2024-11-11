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

// Consulta para obter o usuario_id a partir do email
$sql_usuario = "SELECT ID_USUARIO FROM usuario WHERE EMAIL_USUARIO = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();

// Verifica se o usuário existe
if ($result_usuario->num_rows === 0) {
    echo "Erro: Usuário não encontrado.";
    exit();
}

// Obtém o usuario_id
$usuario = $result_usuario->fetch_assoc();
$usuario_id = $usuario['ID_USUARIO'];

// Consulta para obter todos os pedidos e informações associadas
$query = "
    SELECT p.id AS pedido_id, 
           u.NOME_USUARIO AS nome_cliente, 
           p.data_pedido, 
           p.total AS total_pedido,
           e.rua AS endereco_pedido, 
           e.numero AS numero_casa, 
           e.bairro, 
           e.cidade,
           p.status_pagamento AS pagamento_tipo,
           p.status
    FROM pedidos p
    LEFT JOIN usuario u ON p.usuario_id = u.ID_USUARIO
    LEFT JOIN enderecos e ON p.endereco_id = e.id
    WHERE p.usuario_id = ?
    ORDER BY p.data_pedido DESC, p.id ASC;
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    echo "Erro na execução da consulta: " . $conn->error;
    exit();
}

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedido_id = $row['pedido_id'];
    $pedidos[$pedido_id] = [
        'data_pedido' => $row['data_pedido'],
        'total_pedido' => 0, // Inicia com 0
        'endereco_pedido' => $row['endereco_pedido'],
        'numero_casa' => $row['numero_casa'],
        'bairro' => $row['bairro'],
        'cidade' => $row['cidade'],
        'pagamento_tipo' => $row['pagamento_tipo'],
        'nome_cliente' => $row['nome_cliente'],
        'itens' => [] // Inicializa a chave 'itens'
    ];

    // Agora, vamos buscar os itens do pedido
    $query_itens = "
        SELECT i.nome AS nome_item, 
               ip.quantidade, 
               ip.preco
        FROM itens_pedido ip
        JOIN item i ON ip.item_id = i.id
        WHERE ip.pedido_id = ?;
    ";

    $stmt_itens = $conn->prepare($query_itens);
    $stmt_itens->bind_param("i", $pedido_id);
    $stmt_itens->execute();
    $result_itens = $stmt_itens->get_result();

    $total_pedido = 0; // Inicializa o total do pedido

    while ($item_row = $result_itens->fetch_assoc()) {
        $quantidade = $item_row['quantidade'];
        $preco_item = $item_row['preco'];
        $total_item = $quantidade * $preco_item;

        // Soma o valor total de cada item no pedido
        $total_pedido += $total_item;

        // Adiciona os itens no pedido
        $pedidos[$pedido_id]['itens'][] = [
            'nome_item' => $item_row['nome_item'],
            'quantidade' => $quantidade,
            'preco_item' => $preco_item,
            'total_item' => $total_item
        ];
    }

    // Após percorrer todos os itens, atribui o total calculado ao pedido
    $pedidos[$pedido_id]['total_pedido'] = $total_pedido;

    $stmt_itens->close();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Pedidos Tatsu Sushi Bar</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        h1 {
            position: relative;
            z-index: 1;
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 4rem;
            text-align: center;
            text-transform: uppercase;
            color: #fff;
            padding: 5px;
            font-weight: 400;
            box-shadow: 5px 0 0 0 #590209, -5px 0 0 0 #590209;
            background: #590209;
            border-radius: 25px;
        }

        .header {
            margin-top: 3%;
            margin-bottom: 3%;
            filter: brightness(85%);
            border-style: solid #000;
            border-radius: 20px 10px 50px;
            box-shadow: 0 2px 10px #000;
            background-image: url('assets/images/fundo_header.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150%;
            margin-left: -24%;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
        }

        .pedido {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .pedido-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #444;
            padding-bottom: 10px;
        }

        .pedido-header h2 {
            margin: 0;
            font-size: 1.2em;
            color: #E63939;
        }

        .pedido-header span {
            font-size: 0.9em;
            color: #bbb;
        }

        .itens {
            margin-top: 10px;
            padding-left: 15px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .item span {
            display: inline-block;
            width: 25%;
        }

        .item span.total {
            color: #E63939;
        }

        .pedido-total {
            text-align: right;
            font-size: 1em;
            font-weight: bold;
            color: #E63939;
            border-top: 1px solid #444;
            padding-top: 10px;
            margin-top: 10px;
        }

        .btnvoltar {
            z-index: 10;
            position: relative;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 50%), hsl(0, 100%, 13%), hsl(0, 100%, 58%));
            color: rgb(255, 255, 255);
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 300;
            width: 20vw;
            max-width: max-content;
            min-width: 100px;
            height: 50px;
            display: grid;
            place-items: center;
            padding-inline: 30px;
            clip-path: polygon(0% 0%, 90% 0, 100% 30%, 100% 100%, 0 100%);
            overflow: hidden;
            left: -14vw;
            top: 5px;
            text-decoration: none;
        }

        .btnvoltar::before {
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            content: "";
            position: absolute;
            top: var(--top, 50%);
            left: var(--left, 50%);
            width: 100%;
            padding-block-end: 100%;
            background-color: rgb(255, 66, 66);
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            z-index: -1;
            transition: transform 500ms ease;
        }

        .btnvoltar:is(:hover, :focus-visible)::before {
            transform: translate(-50%, -50%) scale(1);
        }
    </style>
</head>

<body>

    <div class="container">
        <a href='index.php' class='btnvoltar' data-btn>Voltar</a>
        <center>
            <div class="header">
                <h1>Histórico de Pedidos</h1>
            </div>
        </center>
        <?php if (empty($pedidos)): ?>
            <p>Nenhum pedido encontrado.</p>
        <?php else: ?>
            <?php foreach ($pedidos as $pedido_id => $pedido): ?>
                <div class="pedido">
                    <div class="pedido-header">
                        <h2>Pedido #<?php echo $pedido_id; ?></h2>
                        <span><?php echo date('d/m/Y H:i:s', strtotime($pedido['data_pedido'])); ?></span>
                    </div>
                    <div class="endereco">
                        <p>Endereço: <?php echo $pedido['endereco_pedido'] . ', ' . $pedido['numero_casa'] . ', ' . $pedido['bairro'] . ' - ' . $pedido['cidade']; ?></p>
                    </div>
                    <div class="pagamento">
                        <p>Pagamento: <?php echo ($pedido['pagamento_tipo']); ?></p>
                    </div>
                    <div class="itens">
                        <?php foreach ($pedido['itens'] as $item): ?>
                            <div class="item">
                                <span><?php echo $item['nome_item']; ?></span>
                                <span>Qtd: <?php echo $item['quantidade']; ?></span>
                                <span>Unid: R$ <?php echo number_format($item['preco_item'], 2, ',', '.'); ?></span>
                                <span class="total">Total: R$ <?php echo number_format($item['quantidade'] * $item['preco_item'], 2, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pedido-total">
                        Total do Pedido: R$ <?php echo number_format($pedido['total_pedido'], 2, ',', '.'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>