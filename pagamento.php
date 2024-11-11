<?php
$endereco_id = $_GET['endereco_id'];
$valor = 100.00; // Valor fictício para teste. Alterar conforme a lógica real.

// Função para gerar QR Code do PIX usando uma API (por exemplo, via QRCode API)
function gerarQRCode($valor)
{
    return "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Pix: $valor";
}

$qrCodeURL = gerarQRCode($valor);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>
    <style>
        body {
            background-color: rgb(18, 18, 18);
            font-family: 'Arial', sans-serif;
            color: #f0f0f0;
            margin: 20;
            padding: 20;
            margin-right: 600px;
            display: flex;
            justify-self: center;
            align-self: center;
        }

        h2 {
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 2.5rem;
            text-align: center;
            color: #fff;
            padding: 5px;
            font-weight: 400;
            background: #590209;
            border-radius: 25px;
            margin: 20px 0;
        }

        img {
            display: block;
            margin: 0 auto;
            border-radius: 8px;
        }

        p {
            text-align: center;
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
            width: 200px;
            font-size: 1.2rem;
        }

        button:hover {
            background-color: #600000;
        }

        input[type="hidden"] {
            display: none;
        }
    </style>
</head>

<body>
    <center>
        <h2>Pagamento do Pedido</h2>
        <img src="<?php echo $qrCodeURL; ?>" alt="QR Code do Pix">
        <p>Valor do Pedido: R$ <?php echo number_format($valor, 2, ',', '.'); ?></p>

        <form action="finalizar_pedido.php" method="POST">
            <input type="hidden" name="endereco_id" value="<?php echo $endereco_id; ?>">
            <input type="hidden" name="valor" value="<?php echo $valor; ?>">
            <button type="submit" name="status_pagamento" value="Pago">Pago</button>
            <button type="submit" name="status_pagamento" value="Pago na Entrega">Pagarei na Entrega</button>
        </form>
    </center>
</body>

</html>