<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dados do Usuário</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <!-- INICIO CSS -->
    <style>
        body {
            background-color: #1c1c1c;
            color: #f0f0f0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        header {
            filter: brightness(90%);
            position: relative;
            z-index: 1;
            font-family: Impact, Haettenschweiler, 'Arial Narrow', sans-serif;
            font-size: 2.5rem;
            text-align: center;
            text-transform: uppercase;
            padding: 5px;
            font-weight: 400;
            border-radius: 10px;
            background-image: linear-gradient(to right bottom, hsl(0, 100%, 40%), hsl(0, 100%, 10%), hsl(0, 100%, 30%));
        }

        .user-data p {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #3a3a3a;
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
    <?php
    include('data/conexao.php');
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];

    $query = $conn->prepare("SELECT * FROM usuario WHERE email_usuario = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit();
    }
    ?>
    <!-- FIM PHP -->
    <!-- INICIO HTML -->
    <a href="index.php" class="btnvoltar" data-btn>Voltar</a>
    <br />
    <section class="container">
        <header>Dados do Usuário</header>
        <div class="user-data">
            <p><strong>Nome Completo:</strong> <?php echo htmlspecialchars($usuario['NOME_USUARIO']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['EMAIL_USUARIO']); ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($usuario['DATA_NASC']); ?></p>
            <p><strong>Gênero:</strong> <?php echo htmlspecialchars($usuario['GENERO']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($usuario['ENDERECO']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($usuario['ESTADO']); ?></p>
        </div>
    </section>

    <!-- SCRIPTS DO JS -->
    <script src="./assets/js/script2.js"></script>
    <script src="https://kit.fontawesome.com/56bcd8394b.js" crossorigin="anonymous"></script>

</body>
    <!-- FIM HTML -->

</html>