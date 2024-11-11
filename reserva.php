<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Reserva Tatsu</title>
    <link href="assets/css_CRUD/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/css_CRUD/style.css" rel="stylesheet" media="screen">
    <script language="JavaScript" type="text/javascript" src="assets/js_CRUD/jquery-1.11.1.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js_CRUD/bootstrap-3.1.1.min.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js_CRUD/jquery.validationEngine-2.6.2.js"></script>
    <script language="JavaScript" type="text/javascript" src="assets/js_CRUD/jquery.validationEngine-pt.js"></script>
    <link href="assets/css_CRUD/validationEngine.jquery.css" rel="stylesheet" media="screen">
    <script language="JavaScript" type="text/javascript" src="assets/js_CRUD/jquery.dataTables-1.10.0.min.js"></script>
    <link href="assets/css_CRUD/jquery.dataTables.min.css" rel="stylesheet" media="screen">
    <link rel="icon" href="assets/images/dragaoicone.png" type="image/x-icon">
</head>

<body style="background-color: #000; color: #a3a3a3; font-weight: 100;">
    <style>
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
    <?php
    session_start(); // Inicia a sessão
    
    // Verifica se a sessão está ativa
    if (!isset($_SESSION['email'])) {
        echo '<script>alert("Você precisa estar logado para acessar esta página.");</script>';
        // Usar exit() após echo pode prevenir o redirecionamento.
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }

    include('data/conexao.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nomeCliente'])) {
        $nomeCliente = $_POST['nomeCliente'];
        $emailCliente = $_POST['emailCliente'];
        $quantidadePessoas = $_POST['quantidadePessoas'];
        $diaReserva = $_POST['diaReserva'];
        $horaReserva = $_POST['horaReserva'];
        $areaRestaurante = $_POST['areaRestaurante'];
        $tipoReserva = $_POST['tipoReserva'];
        $observacoes = $_POST['observacoes'];

        $sql = "INSERT INTO RESERVA (NOME_CLIENTE, EMAIL_CLIENTE, QUANTIDADE_PESSOAS, DIA_RESERVA, HORA_RESERVA, AREA_RESTAURANTE, TIPO_RESERVA, OBSERVACOES)
         VALUES ('$nomeCliente', '$emailCliente', '$quantidadePessoas', '$diaReserva', '$horaReserva', '$areaRestaurante', '$tipoReserva', '$observacoes')";

        if ($conn->query($sql) === TRUE) {
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }

    }
    ?>
    <?php
            echo "<a href='index.php' class='btnvoltar' data-btn>Voltar</a>";
    ?>        
    <div class="container">
        <h1
            style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size: 48px; text-align: center; text-transform: uppercase; background-color: #000; color: #fff; padding: 20px;">
            Reserva Tatsu
        </h1>
        <form class="form-horizontal" role="form" id="formID" action="reserva.php" method="POST"
            style="background-color: #000; color: #afafaf; font-size: 15px;">
            <div class="form-group">
                <label for="nomeCliente" class="col-sm-2 control-label">Nome do Cliente</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control validate[required]" id="nomeCliente" name="nomeCliente"
                        placeholder="Nome do Cliente"
                        style="color: #fff; background-color: transparent; border-color: #941111;">
                </div>
            </div>
            <div class="form-group">
                <label for="emailCliente" class="col-sm-2 control-label">Email do Cliente</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control validate[required]" id="emailCliente" name="emailCliente"
                        placeholder="Email do Cliente"
                        style="color: #fff; background-color: transparent; border-color: #941111;">
                </div>
            </div>
            <div class="form-group">
                <label for="quantidadePessoas" class="col-sm-2 control-label">Quantidade de Pessoas</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control validate[required,custom[number]]" id="quantidadePessoas"
                        name="quantidadePessoas" placeholder="Quantidade de Pessoas"
                        style="color: #fff; background-color: transparent; border-color: #941111;">
                </div>
            </div>
            <div class="form-group">
                <label for="diaReserva" class="col-sm-2 control-label">Dia da Reserva</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control validate[required]" id="diaReserva" name="diaReserva"
                        placeholder="Dia da Reserva"
                        style="color: #fff; background-color: transparent; border-color: #941111;">
                </div>
            </div>
            <div class="form-group">
                <label for="horaReserva" class="col-sm-2 control-label">Hora da Reserva</label>
                <div class="col-sm-6">
                    <input type="time" class="form-control validate[required]" id="horaReserva" name="horaReserva"
                        placeholder="Hora da Reserva"
                        style="color: #fff; background-color: transparent; border-color: #941111;">
                </div>
            </div>
            <div class="form-group">
                <label for="areaRestaurante" class="col-sm-2 control-label">Área do Restaurante</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <label>
                            <input type="radio" class="validate[required]" name="areaRestaurante" value="Externa"
                                style="color: #fff; background-color: transparent; border-color: #941111;">
                            Externa
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" class="validate[required]" name="areaRestaurante" value="Interna"
                                style="color: #fff; background-color: transparent; border-color: #941111;">
                            Interna
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tipoReserva" class="col-sm-2 control-label">Tipo da Reserva</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <label>
                            <input type="radio" class="validate[required]" name="tipoReserva" value="Especial"
                                style="color: #fff; background-color: transparent; border-color: #941111;">
                            Especial
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" class="validate[required]" name="tipoReserva" value="Normal"
                                style="color: #fff; background-color: transparent; border-color: #941111;">
                            Normal
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="observacoes" class="col-sm-2 control-label">Observações</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="observacoes" name="observacoes" placeholder="Observações"
                        style="color: #fff; background-color: transparent; border-color: #941111;"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-2">
                    <button type="submit" class="submit btn btn-danger" id="save">Salvar</button>
                </div>
            </div>
        </form>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        $(document).ready(function() {
            $('#formID').slideDown();

            $('#save').click(function(event) {
                event.preventDefault(); //IMPEDE O ENVIO IMEDIATO DO FORMULÁRIO

                $("<center><div>Reserva enviada!</div></center>").dialog({
                    title: "Tatsu Reservas!",
                    modal: true,
                    buttons: {
                        "OK": function() {
                            $(this).dialog("close");
                            setTimeout(function() {
                                $('#formID')
                                    .submit(); // ENVIA O FORMULÁRIO APÓS O FECHAMENTO DO "MODAL"
                            }, 500); // AGUARDA 0,5 SEGUNDOS
                        }
                    },
                    classes: {
                        "ui-dialog": "ui-widget"
                    },
                    dialogClass: "my-dialog" // ADICIONA A CLASSE RESPONSAVEL PELA CAIXA DE DIALOG
                });
            });
        });
        </script>
    </div>

</body>

</html>