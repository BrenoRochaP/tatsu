<?php session_start();
include('data/conexao.php');

// Função para enviar e-mail de confirmação
function enviarEmailConfirmacao($email, $nome)
{
    require 'vendor/autoload.php'; // Inclua o autoload do Composer
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tatsusushibar@gmail.com'; // Seu e-mail
        $mail->Password = 'tatsu2024'; // Sua senha (considerar usar variáveis de ambiente)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatários
        $mail->setFrom('tatsusushibar@gmail.com', 'Reserva Tatsu');
        $mail->addAddress($email, $nome); // Adiciona um destinatário

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Reserva';
        $mail->Body = "Olá $nome,<br> Sua reserva foi confirmada com sucesso!<br> Obrigado por escolher o Reserva Tatsu.";
        $mail->AltBody = "Olá $nome, Sua reserva foi confirmada com sucesso! Obrigado por escolher o Reserva Tatsu.";
        $mail->send();
        return true; // Retorna verdadeiro se o e-mail foi enviado com sucesso
    } catch (Exception $e) {
        error_log("E-mail não pôde ser enviado. Erro: {$mail->ErrorInfo}");
        return false; // Retorna falso se houve erro no envio
    }
}

// Ação de confirmação
if (isset($_POST['confirmar'])) {
    $reserva_id = (int) $_POST['reserva_id']; // Cast para inteiro para maior segurança
    // Buscar dados da reserva para enviar o e-mail
    $sql = "SELECT NOME_CLIENTE, EMAIL_CLIENTE FROM reserva WHERE ID_RESERVA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id); // Previne SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = htmlspecialchars($row['NOME_CLIENTE']);
        $email = htmlspecialchars($row['EMAIL_CLIENTE']);
        // Enviar e-mail de confirmação
        if (enviarEmailConfirmacao($email, $nome)) {
            echo "<script>alert('Reserva confirmada e e-mail enviado para $email!');</script>";
        } else {
            echo "<script>alert('Erro ao enviar o e-mail de confirmação.');</script>";
        }
    } else {
        echo "<script>alert('Reserva não encontrada.');</script>";
    }
}

// Ação de exclusão
if (isset($_POST['excluir'])) {
    $reserva_id = (int) $_POST['reserva_id']; // Cast para inteiro
    $sql = "DELETE FROM reserva WHERE ID_RESERVA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id); // Previne SQL Injection
    if ($stmt->execute()) {
        echo "<script>alert('Reserva excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir a reserva.');</script>";
    }
}

// Executa a consulta SQL
$sqlSelect = "SELECT * FROM reserva";
$stmt = $conn->query($sqlSelect);
?>
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
    <style>
        body {
            background-color: #121212;
            /* Fundo escuro */
            color: #e0e0e0;
            /* Texto claro */
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 5%;
            width: 98%;
            padding: 2rem;
            background-color: #1f1f1f;
            /* Fundo do container */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            filter: brightness(90%);
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 4rem;
            text-align: center;
            text-transform: uppercase;
            padding: 5px;
            font-weight: 400;
            border-radius: 10px;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 40%), hsl(0, 100%, 10%), hsl(0, 100%, 30%));
            color: #fff;
            /* Cor do texto do título */
        }

        /* Estilo da tabela */
        /* Para a tabela */
        .dataTable {
            color: white;
            /* Cor do texto */
            background-color: #333;
            /* Cor de fundo escura */
        }

        /* Para os cabeçalhos da tabela */
        .dataTable th {
            color: white;
            /* Cor do texto dos cabeçalhos */
            background-color: #444;
            /* Cor de fundo dos cabeçalhos */
        }

        /* Para as linhas ímpares */
        .dataTable tbody tr.odd {
            background-color: #555;
            /* Cor de fundo das linhas ímpares */
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #222;
            /* Borda da tabela */
        }

        th {
            background-color: #590209;
            /* Fundo do cabeçalho da tabela */
            color: #fff;
            /* Texto do cabeçalho */
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
            /* Cor das linhas pares */
        }

        /* Estilo do campo de pesquisa */
        .search-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #333;
            /* Fundo do campo de pesquisa */
            color: #fff;
            /* Texto do campo de pesquisa */
            border: 1px solid #555;
            /* Borda do campo de pesquisa */
            border-radius: 5px;
            /* Bordas arredondadas */
        }

        table.dataTable .dataTables_info {
            color: #fff
        }

/* Estilo para o seletor de comprimento */
.dataTables_paginate select {
    background-color: #444; /* Cor de fundo escura para o seletor */
    color: white; /* Cor do texto em branco */
    border: 1px solid #555; /* Borda escura */
}

        .dataTables_filter input {
            background-color: #444;
            /* Cor de fundo escura para o campo de busca */
            color: white;
            /* Cor do texto em branco */
            border: 1px solid #555;
            /* Borda do campo de busca */
        }

        .dataTables_length select {
            background-color: #444;
            /* Cor de fundo escura para o seletor */
            color: white;
            /* Cor do texto em branco */
            border: 1px solid #555;
            /* Borda do seletor */
        }

        .dataTables_filter label,
        .dataTables_length label,
        .dataTables_info,
        .dataTables_paginates {
            color: white !important;
        }

        .search-field::placeholder {
            color: #bbb;
            /* Cor do texto do placeholder */
        }

        /* Estilo dos botões */
        .btn {
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
            border: none;
            /* Remover borda padrão */
            cursor: pointer;
            /* Mudar cursor ao passar o mouse */
            transition: background-color 0.3s;
            /* Transição suave para hover */
        }

        .btn-info {
            background-color: #007bff;
            /* Cor do botão de confirmação */
        }

        .btn-danger {
            background-color: #dc3545;
            /* Cor do botão de exclusão */
        }

        .btn-info:hover {
            background-color: #0056b3;
            /* Tom mais escuro ao passar o mouse */
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Tom mais escuro ao passar o mouse */
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
            left: 6vw;
            top: 20px;
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
    <?php echo "<a href='index.php' class='btnvoltar' data-btn>Voltar</a>"; ?>
    <div class="container">
        <h1>Reserva Tatsu</h1>
        <?php
        try {
            echo "<table class='dataTable' id='minhaTabela'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID Reserva</th>";
            echo "<th>Nome do Cliente</th>";
            echo "<th>Email</th>";
            echo "<th>Quantidade</th>"; // Coluna Quantidade
            echo "<th>Data</th>"; // Coluna Data
            echo "<th>Hora</th>"; // Coluna Hora
            echo "<th>Área</th>"; // Coluna Área
            echo "<th>Tipo</th>"; // Coluna Tipo
            echo "<th>Observações</th>"; // Coluna Observações
            echo "<th>Ações</th>"; // Coluna Ações
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $stmt->fetch_assoc()) {
                $id_reserva = htmlspecialchars($row['ID_RESERVA']);
                $nome_cliente = htmlspecialchars($row['NOME_CLIENTE']);
                $email_cliente = htmlspecialchars($row['EMAIL_CLIENTE']);
                $quantidade = htmlspecialchars($row['QUANTIDADE_PESSOAS']);
                $data = htmlspecialchars($row['DIA_RESERVA']);
                $hora = htmlspecialchars($row['HORA_RESERVA']);
                $area = htmlspecialchars($row['AREA_RESTAURANTE']);
                $tipo = htmlspecialchars($row['TIPO_RESERVA']);
                $observacoes = htmlspecialchars($row['OBSERVACOES']);
                echo "<tr class='odd'>";
                echo "<td>$id_reserva</td>";
                echo "<td>$nome_cliente</td>";
                echo "<td>$email_cliente</td>";
                echo "<td>$quantidade</td>"; // Preenchendo a coluna Quantidade
                echo "<td>$data</td>"; // Preenchendo a coluna Data
                echo "<td>$hora</td>"; // Preenchendo a coluna Hora
                echo "<td>$area</td>"; // Preenchendo a coluna Área
                echo "<td>$tipo</td>"; // Preenchendo a coluna Tipo
                echo "<td>$observacoes</td>"; // Preenchendo a coluna Observações
                echo "<td>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='reserva_id' value='$id_reserva'>
                        <button type='submit' name='confirmar' class='btn btn-info'>Confirmar</button>
                    </form>
                    <form method='post' style='display:inline-block;'>
                        <input type='hidden' name='reserva_id' value='$id_reserva'>
                        <button type='submit' name='excluir' class='btn btn-danger'>Excluir</button>
                    </form>
                  </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } catch (Exception $e) {
            echo "Erro ao buscar reservas: " . $e->getMessage();
        }
        ?>
    </div>
    <script>
        $('#minhaTabela').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "<span class='dataTables_info'>Mostrando página _PAGE_ de _PAGES_</span>",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros totais)",
                "search": "Buscar:",
                "paginate": {
                    "first": "<span class='dataTables_paginates'>Primeiro</span>",
                    "last": "<span class='dataTables_paginates'>Último</span>",
                    "next": "<span class='dataTables_paginates'>Próximo</span>",
                    "previous": "<span class='dataTables_paginates'>Anterior</span>"
                }
            }
        });
    </script>
</body>

</html>