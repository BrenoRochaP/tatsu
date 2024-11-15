<!-- INICIO PHP -->
<?php
session_start();
include('data/conexao.php');
?>
<!-- FIM PHP -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos Tatsu</title>
    <link href="assets/css_CRUD/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/css_CRUD/style.css" rel="stylesheet" media="screen">
    <link href="assets/css_CRUD/validationEngine.jquery.css" rel="stylesheet" media="screen">
    <link href="assets/css_CRUD/jquery.dataTables.min.css" rel="stylesheet" media="screen">
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <script src="assets/js_CRUD/jquery-1.11.1.min.js"></script>
    <script src="assets/js_CRUD/bootstrap-3.1.1.min.js"></script>
    <script src="assets/js_CRUD/jquery.validationEngine-2.6.2.js"></script>
    <script src="assets/js_CRUD/jquery.validationEngine-pt.js"></script>
    <script src="assets/js_CRUD/jquery.dataTables-1.10.0.min.js"></script>
    <!-- INICIO CSS -->
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 98%;
            margin-top: 5%;
            padding: 2rem;
            background-color: #1f1f1f;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            filter: brightness(90%);
            position: relative;
            z-index: 1;
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 4rem;
            text-align: center;
            text-transform: uppercase;
            padding: 5px;
            font-weight: 400;
            border-radius: 10px;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 40%), hsl(0, 100%, 10%), hsl(0, 100%, 30%));
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #222;
            color: #f0f0f0;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #333;
        }

        th {
            background-color: #590209;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        .btn {
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
        }

        .btn-info {
            background-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btnvoltar {
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
            left: 6vw;
            top: 20px;
            text-decoration: none;
        }

        .btnvoltar::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
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

        select[name="status"] {
            padding: 5px;
            background-color: #000;
            color: #f0f0f0;
            border: 1px solid #000;
            border-radius: 10px;
        }

        .btn-update-status {
            margin-left: 5px;
            margin-right: -5px;
            background-color: #800000;
            color: #fff;
            padding: 5px 8px;
            border-radius: 30px;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-update-status:hover {
            background-color: #600000;
        }
    </style>
    <!-- FIM CSS -->
</head>
<!-- INICIO HTML -->

<body>

    <?php echo "<a href='index.php' class='btnvoltar' data-btn>Voltar</a>"; ?>

    <div class="container">
        <h1>Pedidos Tatsu</h1>

        <?php
        $sqlSelect = "
        SELECT p.id AS pedido_id, 
               u.NOME_USUARIO AS nome_cliente, 
               p.data_pedido, 
               e.rua AS endereco_pedido, 
               e.numero AS numero_casa, 
               e.bairro, 
               e.cidade,
               p.status_pagamento, 
               p.status
        FROM pedidos p
        LEFT JOIN usuario u ON p.usuario_id = u.ID_USUARIO
        LEFT JOIN enderecos e ON p.endereco_id = e.id
        ORDER BY p.data_pedido DESC, p.id ASC
        ";

        $stmt = $conn->query($sqlSelect);

        echo "<table class='table'>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Nome do Cliente</th>
                    <th>Data do Pedido</th>
                    <th>Total</th>
                    <th>Endereço</th>
                    <th>Status de Pagamento</th>
                    <th>Status</th>
                    <th>Itens e Quantidade</th>
                    <th>Atualizar Situação</th>
                </tr>
            </thead>
            <tbody>";

        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                $pedido_id = $row["pedido_id"];

                // Formatar o endereço completo
                $endereco_completo = isset($row['endereco_pedido']) ? $row['endereco_pedido'] . ", " : '';
                $endereco_completo .= isset($row['numero_casa']) ? $row['numero_casa'] . ", " : '';
                $endereco_completo .= isset($row['bairro']) ? $row['bairro'] . ", " : '';
                $endereco_completo .= isset($row['cidade']) ? $row['cidade'] : 'Cidade não disponível';

                // Consultar os itens do pedido e calcular o total
                $sqlItens = "
                SELECT i.nome AS nome_item, 
                       ip.quantidade,
                       i.preco
                FROM itens_pedido ip
                JOIN item i ON ip.item_id = i.id
                WHERE ip.pedido_id = ?
                ";
                $stmt_itens = $conn->prepare($sqlItens);
                $stmt_itens->bind_param("i", $pedido_id);
                $stmt_itens->execute();
                $result_itens = $stmt_itens->get_result();

                // Preparar os itens para exibição e calcular o total
                $itens_display = [];
                $total_pedido_calculado = 0;
                while ($item_row = $result_itens->fetch_assoc()) {
                    $item_nome = $item_row['nome_item'];
                    $quantidade = $item_row['quantidade'];
                    $preco = $item_row['preco'];

                    // Calcular o valor total para o item
                    $total_item = $preco * $quantidade;
                    $total_pedido_calculado += $total_item;

                    $itens_display[] = $item_nome . " (" . $quantidade . " x R$ " . number_format($preco, 2, ',', '.') . ")";
                }

                // Formatar o total
                $total_pedido_display = number_format($total_pedido_calculado, 2, ',', '.');

                $itens_display_str = implode(", ", $itens_display);

                // Exibir os dados
                echo "<tr>
                    <td>" . htmlspecialchars($row["pedido_id"]) . "</td>
                    <td>" . htmlspecialchars($row["nome_cliente"]) . "</td>
                    <td>" . htmlspecialchars($row["data_pedido"]) . "</td>
                    <td>R$ " . $total_pedido_display . "</td>
                    <td>" . $endereco_completo . "</td>
                    <td>" . htmlspecialchars($row["status_pagamento"]) . "</td>
                    <td>" . htmlspecialchars($row["status"]) . "</td>
                    <td>" . ($itens_display_str ? $itens_display_str : 'Sem itens') . "</td>
                    <td>
                        <form method='POST' action='atualiza_status.php'>
                            <input type='hidden' name='pedido_id' value='" . htmlspecialchars($row["pedido_id"]) . "'>
                            <select name='status'>
                                <option value='Pendente'>Pendente</option>
                                <option value='Enviado'>Enviado</option>
                                <option value='Cancelado'>Cancelado</option>
                            </select>
                            <button type='submit' class='btn-update-status'><center><img src='assets/images/atualizar.png'></center></button>
                        </form>
                    </td>
                  </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Nenhum pedido encontrado</td></tr>";
        }

        echo "</tbody></table>";
        $conn->close();
        ?>
    </div>
</body>

</html>
<!-- FIM HTML -->