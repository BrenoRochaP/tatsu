<!-- INICIO PHP -->
<?php
include('data/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO enderecos (rua, numero, complemento, cep, bairro, cidade, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $rua, $numero, $complemento, $cep, $bairro, $cidade, $estado);
        $stmt->execute();

        $endereco_id = mysqli_insert_id($conn);

        session_start();
        $_SESSION['endereco_id'] = $endereco_id;

        header("Location: pagamento.php?endereco_id=" . $endereco_id);
        exit;
    } catch (Exception $e) {
        echo "Erro ao cadastrar o endereço: " . $e->getMessage();
    }
}
?>
<!-- FIM PHP -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Informações de Endereço</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- INICIO CSS -->
    <style>
        body {
            background-color: rgb(18, 18, 18);
            font-family: 'Arial', sans-serif;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            flex-direction: column;
        }

        .container {
            margin-top: 40px;
            width: 90%;
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-family: 'Impact', sans-serif;
            filter: brightness(90%);
            position: relative;
            z-index: 1;
            font-size: 3rem;
            text-align: center;
            text-transform: uppercase;
            padding: 5px;
            font-weight: 400;
            border-radius: 10px;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 40%), hsl(0, 100%, 10%), hsl(0, 100%, 30%));
        }

        .form-container {
            width: 100%;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 96%;
            align-self: center;
        }

        label {
            margin-bottom: 5px;
            font-size: 1.2rem;
            color: #f0f0f0;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #333;
            border-radius: 10px;
            background-color: #333;
            color: #f0f0f0;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #800000;
            outline: none;
        }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background-color: #800000;
            color: #f0f0f0;
            font-size: 1.2rem;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #660000;
        }
    </style>
    <!-- FIM CSS -->
</head>
<!-- INICIO HTML -->

<body>
    <div class="container">
        <h2>Informações de Endereço</h2>
        <div class="form-container">
            <form method="post">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" required>

                <label for="rua">Rua:</label>
                <input type="text" id="rua" name="rua" required>

                <label for="numero">Número:</label>
                <input type="number" id="numero" name="numero" required>

                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" required>

                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" required>

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" required>

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" required>

                <button type="submit">Cadastrar Endereço</button>
            </form>
        </div>
    </div>
    <!-- INICIO JS -->
    <script>
        $(document).ready(function () {
            $('#cep').on('blur', function () {
                var cep = $(this).val();
                $.ajax({
                    url: 'https://viacep.com.br/ws/' + cep + '/json/',
                    dataType: 'json',
                    success: function (data) {
                        $('#rua').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    }
                });
            });
        });
    </script>
    <!-- FIM JS -->
</body>
<!-- FIM HTML -->

</html>