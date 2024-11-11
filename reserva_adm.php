<!-- INCIIO PHP -->
<?php
session_start();
include('data/conexao.php');

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function enviarEmailConfirmacao($email, $nome)
{
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tatsusushibar@gmail.com';
        $mail->Password = 'tatsu2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tatsusushibar@gmail.com', 'Reserva Tatsu');
        $mail->addAddress($email, $nome);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Reserva';
        $mail->Body = "Olá $nome,<br> Sua reserva foi confirmada com sucesso!<br> Obrigado por escolher o Reserva Tatsu.";
        $mail->AltBody = "Olá $nome, Sua reserva foi confirmada com sucesso! Obrigado por escolher o Reserva Tatsu.";

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        error_log("E-mail não pôde ser enviado. Erro: {$mail->ErrorInfo}");
        return false;
    }
}

if (isset($_POST['confirmar'])) {
    $reserva_id = (int) $_POST['reserva_id'];
    $sql = "SELECT NOME_CLIENTE, EMAIL_CLIENTE FROM reserva WHERE ID_RESERVA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = htmlspecialchars($row['NOME_CLIENTE']);
        $email = htmlspecialchars($row['EMAIL_CLIENTE']);
        if (enviarEmailConfirmacao($email, $nome)) {
            echo "<script>alert('Reserva confirmada e e-mail enviado para $email!');</script>";
        } else {
            echo "<script>alert('Erro ao enviar o e-mail de confirmação.');</script>";
        }
    } else {
        echo "<script>alert('Reserva não encontrada.');</script>";
    }
}

if (isset($_POST['excluir'])) {
    $reserva_id = (int) $_POST['reserva_id'];
    $sql = "DELETE FROM reserva WHERE ID_RESERVA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);
    if ($stmt->execute()) {
        echo "<script>alert('Reserva excluída com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao excluir a reserva.');</script>";
    }
}

$sqlSelect = "SELECT * FROM reserva";
$stmt = $conn->query($sqlSelect);
?>
<!-- FIM PHP -->
<!-- INICIO HTML -->
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
            margin-top: 5%;
            width: 98%;
            padding: 2rem;
            background-color: #1f1f1f;
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
        }

        .dataTable {
            color: white;
            background-color: #590209;
        }

        .dataTable th {
            color: white;
            background-color: #444;
        }

        .dataTable tbody tr.odd {
            background-color: #555;
        }

        .dataTable tbody tr.even {
            background-color: #333;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #222;
        }

        th {
            background-color: #590209;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        .search-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
            border-radius: 5px;
        }

        table.dataTable .dataTables_info {
            color: #fff
        }

        .dataTables_filter input {
            background-color: #444;
            color: white;
            border: 1px solid #555;
        }

        .dataTables_length select {
            background-color: #444;
            color: white;
            border: 1px solid #555;
        }

        .dataTables_filter label,
        .dataTables_length label,
        .dataTables_info,
        .dataTables_paginates {
            color: white !important;
        }

        .search-field::placeholder {
            color: #bbb;
        }

        .btn {
            padding: 5px 10px;
            color: #fff;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-info {
            background-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-info:hover {
            background-color: #0056b3;
        }

        .btn-danger:hover {
            background-color: #c82333;
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
    <!-- FIM CSS -->
</head>

<body>
    <!-- INICIO PHP -->
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
            echo "<th>Quantidade</th>";
            echo "<th>Data</th>";
            echo "<th>Hora</th>";
            echo "<th>Área</th>";
            echo "<th>Tipo</th>";
            echo "<th>Observações</th>";
            echo "<th>Ações</th>";
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
                echo "<td>$quantidade</td>";
                echo "<td>$data</td>";
                echo "<td>$hora</td>";
                echo "<td>$area</td>";
                echo "<td>$tipo</td>";
                echo "<td>$observacoes</td>";
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
        <!-- FIM PHP -->
    </div>
    <!-- INICIO JS -->
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
    <!-- FIM JS -->
</body>

</html>