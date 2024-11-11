<!-- INICIO PHP -->
<?php
session_start();
include('data/conexao.php');
if (!isset($_SESSION['email'])) {
    echo '<script>alert("Você precisa estar logado para acessar esta página.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}
;

$products = [
    1 => ['nome' => 'Sushi de Salmão', 'preco' => 35.00, 'imagem' => 'assets/images/prato_1.jpg'],
    2 => ['nome' => 'Rámen', 'preco' => 45.00, 'imagem' => 'assets/images/prato_2.jpg'],
    3 => ['nome' => 'Tempurá', 'preco' => 40.00, 'imagem' => 'assets/images/prato_3.jpg'],
    4 => ['nome' => 'Cheesecake', 'preco' => 22.00, 'imagem' => 'assets/images/doce_4.jpg'],
    5 => ['nome' => 'Mochi', 'preco' => 18.00, 'imagem' => 'assets/images/doce_3.jpg'],
    6 => ['nome' => 'Dorayaki', 'preco' => 15.00, 'imagem' => 'assets/images/doce_2.jpg'],
    7 => ['nome' => 'Taiyaki', 'preco' => 20.00, 'imagem' => 'assets/images/doce_1.jpg'],
    8 => ['nome' => 'Yakisoba', 'preco' => 30.00, 'imagem' => 'assets/images/prato_4.jpg'],
    9 => ['nome' => 'Ceviche', 'preco' => 40.00, 'imagem' => 'assets/images/prato_5.jpg'],
];
?>
<!-- FIM PHP -->
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Tatsu Sushi Bar</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <!-- INICIO CSS -->
    <style>
        body {
            background-color: rgb(18, 18, 18);
            font-family: 'Arial', sans-serif;
            color: #f0f0f0;
            margin: 0;
            padding: 0;
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
            width: 88%;
        }

        .menu {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product {
            width: calc(25% - 20px);
            height: fit-content;
            padding: 15px;
            margin: 10px;
            border-style: solid #000;
            border-radius: 20px 10px 50px;
            box-shadow: 0 2px 10px #000;
            background-color: #222;
            color: #f0f0f0;
            transition: transform 0.2s;
        }

        .product img {
            max-width: 100%;
            border-radius: 8px;
        }

        .product:hover {
            transform: translateY(-5px);
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background-color: #800000;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #600000;
        }

        .quantidade-input {
            padding: 10px;
            margin-bottom: 5%;
            border: 1px solid rgb(18, 18, 18);
            border-radius: 30px;
            background-color: #171717;
            color: #f0f0f0;
            width: 90%;
        }

        .quantidade-input:focus {
            border-color: #800000;
            outline: none;
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

        @media (max-width: 1200px) {
            .product {
                width: calc(33.33% - 20px);
            }
        }

        @media (max-width: 800px) {
            .product {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 600px) {
            .product {
                width: 100%;
            }
        }
    </style>
    <!-- FIM CSS -->
</head>

<!-- INICIO HTML -->

<body>
    <?php
    echo "<a href='index.php' class='btnvoltar' data-btn>Voltar</a>";
    ?>
    <center>
        <div class="header">
            <h1>Menu Tatsu Sushi bar</h1>
        </div>
    </center>
    <div class="menu">
        <?php foreach ($products as $id => $product): ?>
            <div class="product">
                <img src="<?php echo $product['imagem']; ?>" alt="<?php echo $product['nome']; ?>">
                <h2><?php echo $product['nome']; ?></h2>
                <h2>Preço: R$ <?php echo number_format($product['preco'], 2, ',', '.'); ?></h2>
                <form action="carrinho.php" method="post" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <input type="number" name="quantidade" min="1" class="quantidade-input" placeholder="Quantidade"
                        required>
                    <button type="submit">Adicionar ao carrinho</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>
<!-- FIM HTML -->