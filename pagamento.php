<!-- INICIO PHP -->
<?php
session_start();
include('data/conexao.php');

$endereco_id = $_GET['endereco_id'];

$total_pedido = 0;
$sql = "SELECT id, preco FROM item WHERE id = ?";
$stmt = $conn->prepare($sql);

foreach ($_SESSION['carrinho'] as $item_id => $quantidade) {
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
        $preco = $item['preco'];
        $total_pedido += $preco * $quantidade;
    }
}

// Função para gerar QR Code do PIX usando uma API (por exemplo, via QRCode API)
function gerarQRCode($valor)
{
    return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Pix: $valor";
}

$qrCodeURL = gerarQRCode($total_pedido);
?>
<!-- FIM PHP -->
<!DOCTYPE html>
<html lang="pt-BR">
<link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
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
            height: 100vh;
            text-align: center;
        }

        .container {
            background-color: rgba(25, 25, 25, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            max-width: 400px;
            width: 90%;
        }

        h2 {
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 2.5rem;
            color: #fff;
            padding: 10px;
            font-weight: 400;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 40%), hsl(0, 100%, 10%), hsl(0, 100%, 30%));
            border-radius: 10px;
            margin: 20px 0;
        }

        img {
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            max-width: 100%;
            height: auto;
        }

        p {
            font-size: 1.5rem;
            margin: 10px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: #800000;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
            width: 100%;
            font-size: 1.2rem;
            max-width: 200px;
        }

        button:hover {
            background-color: #600000;
        }

        input[type="hidden"] {
            display: none;
        }

        @media (max-width: 600px) {
            h2 {
                font-size: 2rem;
            }

            p {
                font-size: 1.2rem;
            }

            button {
                font-size: 1rem;
            }
        }
    </style>
    <!-- FIM CSS -->
</head>
<!-- INICIO HTML -->

<body>
    <div class="container">
        <h2>Pagamento do Pedido</h2>
        <img src="<?php echo $qrCodeURL; ?>" alt="QR Code do Pix">
        <p>Valor do Pedido: R$ <?php echo number_format($total_pedido, 2, ',', '.'); ?></p>

        <form action="finalizar_pedido.php" method="POST">
            <input type="hidden" name="endereco_id" value="<?php echo $endereco_id; ?>">
            <input type="hidden" name="valor" value="<?php echo $total_pedido; ?>">
            <button type="submit" name="status_pagamento" value="Pago">Pago</button>
            <button type="submit" name="status_pagamento" value="Pago na Entrega">Pagarei na Entrega</button>
        </form>
    </div>
</body>

</html>
<!-- FIM HTML -->