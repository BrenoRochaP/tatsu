<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login Tatsu</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="./assets/css/style2.css">
</head>

<body>
    <!-- INICIO PHP -->
    <?php
    session_start();
    include('data/conexao.php');
    $erro = ""; // INICIALIZA A VARIÁVEL DE ERRO
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (empty($email) || empty($senha)) {
            $erro = "Por favor, preencha todos os campos.";
        } else {
            $sql = "SELECT * FROM usuario WHERE email_usuario = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if (password_verify($senha, $row['SENHA_USUARIO'])) {
                        $_SESSION['email'] = $email;
                        header("Location: index.php");
                        exit();
                    } else {
                        $erro = "Senha incorreta!";
                    }
                } else {
                    $erro = "Usuário não encontrado!";
                }

                $stmt->close();
            } else {
                $erro = "Erro ao preparar a consulta: " . $conn->error;
            }
        }
    }
    ?>
    <!-- FIM PHP -->

    <a href="index.php" class="btn" data-btn>Voltar</a><br />
    <section class="container">
        <header>Entrar</header>
        <form class="form" action="login.php" method="POST">
            <div class="input-box">
                <label>Email</label>
                <input required="" type="email" name="email">
            </div>
            <br />
            <div class="input-box">
                <label>Senha</label>
                <input required="" type="password" name="senha">
            </div>
            <br />
            <button type="submit" name="login">Entrar</button>
            <?php if (isset($erro)): ?>
                <p style="color: red;"><?php echo $erro; ?></p>
            <?php endif; ?>
            <p style="color: #b8b8b8;">Não possui uma conta?<a href="cadastro.php"
                    style="text-decoration: none; color: white;"> Cadastre-se</a></p>
        </form>
    </section>
    <script src="./assets/js/script2.js"></script>
    <script src="https://kit.fontawesome.com/56bcd8394b.js" crossorigin="anonymous"></script>
</body>

</html>
<!-- FIM HTML -->