<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Atualizar Cadastro</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="./assets/css/style2.css">

</head>

<body>

    <!-- PHP -->
    <?php
    include('data/conexao.php');
    session_start();

    // Função para atualizar os dados do usuário
    // Função para atualizar os dados do usuário
    function atualizarDados($conn, $email, $nome, $email_novo, $senha, $telefone, $data_nasc, $genero, $endereco, $cidade, $estado)
    {
        // Verifica se o novo email já está em uso
        $query_check_email = $conn->prepare("SELECT * FROM usuario WHERE email_usuario = ? AND email_usuario != ?");
        $query_check_email->bind_param("ss", $email_novo, $email);
        $query_check_email->execute();
        $result_check = $query_check_email->get_result();

        if ($result_check->num_rows > 0) {
            return "Este email já está em uso por outro usuário.";
        }

        // Condicionando a atualização da senha
        if (!empty($senha)) {
            $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            // Mantenha a senha atual se não for fornecida
            $hashed_senha = getSenhaAtual($conn, $email);
        }

        // Atualização dos dados do usuário
        $query = $conn->prepare("UPDATE usuario SET nome_usuario = ?, email_usuario = ?, senha_usuario = ?, telefone_usuario = ?, data_nasc_usuario = ?, genero_usuario = ?, endereco_usuario = ?, cidade_usuario = ?, estado_usuario = ? WHERE email_usuario = ?");
        $query->bind_param("ssssssssis", $nome, $email_novo, $hashed_senha, $telefone, $data_nasc, $genero, $endereco, $cidade, $estado, $email);

        if ($query->execute()) {
            // Excluir o registro antigo apenas se o email foi alterado
            if ($email !== $email_novo) {
                $query_delete = $conn->prepare("DELETE FROM usuario WHERE email_usuario = ?");
                $query_delete->bind_param("s", $email);
                $query_delete->execute();
                $query_delete->close();
            }

            return "Dados atualizados com sucesso!";
        } else {
            return "Erro ao atualizar os dados: " . $conn->error;
        }
    }

    function getSenhaAtual($conn, $email)
    {
        $query = $conn->prepare("SELECT senha_usuario FROM usuario WHERE email_usuario = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();
        $usuario = $result->fetch_assoc();
        return $usuario['senha_usuario'];
    }

    // Verifica se o usuário está logado
    if (!isset($_SESSION['email'])) {
        header('Location: login.php');
        exit();
    }

    $email = $_SESSION['email'];

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email_novo = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $data_nasc = $_POST['data_nasc'];
        $genero = $_POST['genero'];
        $endereco = $_POST['endereco'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        // Chama a função para atualizar os dados
        $resultado = atualizarDados($conn, $email, $nome, $email_novo, $senha, $telefone, $data_nasc, $genero, $endereco, $cidade, $estado);

        // Mensagem de feedback
        $_SESSION['message'] = $resultado;
        if (strpos($resultado, "sucesso") !== false) {
            $_SESSION['email'] = $email_novo; // Atualiza o email na sessão
            header('Location: crud_usuario.php');
            exit();
        }
    }
    ?>
    <!-- FIM PHP -->

    <a href="index.php" class="btn" data-btn>Voltar</a>
    <br />
    <section class="container">
        <header>Atualizar Cadastro</header>
        <form class="form" action="cadastro.php" method="POST">
            <div class="input-box">
                <label>Nome Completo</label>
                <input required="" type="text" name="nome" id="nome">
            </div>
            <br />
            <div class="input-box">
                <label>Email</label>
                <input required="" type="email" name="email" id="email">
            </div>
            <br />
            <div class="input-box">
                <label>Senha</label>
                <input required="" type="password" name="senha" id="senha">
            </div>
            <br />
            <div class="column">
                <div class="input-box">
                    <label>Número de Telefone</label>
                    <input required="" type="telephone" name="telefone" id="telefone">
                </div>
                <div class="input-box">
                    <label>Data de Nascimento</label>
                    <input required="" type="date" name="data_nasc" id="data_nasc">
                </div>
            </div>
            <br />
            <div class="gender-box">
                <label>Gênero</label>
                <div class="gender-option">
                    <div class="gender">
                        <input checked="" name="genero" type="radio" id="masculino" value="Masculino">
                        <label for="masculino">Masculino</label>
                    </div>
                    <div class="gender">
                        <input name="genero" type="radio" id="feminino" value="Feminino">
                        <label for="feminino">Feminino</label>
                    </div>
                </div>
            </div>
            <br />
            <div class="input-box address">
                <label>Endereço</label>
                <input required="" placeholder="Rua" type="text" name="endereco" id="endereco">
                <div class="column">
                    <div class="select-box">
                        <select name="estado">
                            <option hidden="">Estado</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                    <input required="" placeholder="Cidade" type="text" name="cidade" id="cidade">
                </div>
            </div>
            <br />
            <input type="submit" name="cadastrar" value="Atualizar" class="btn btn-primary mt-4">
        </form>

        <?php if (isset($_SESSION['message'])): ?>
            <p style="color: red;"><?php echo $_SESSION['message'];
            unset($_SESSION['message']); ?></p>
        <?php endif; ?>
    </section>

    <!-- SCRIPTS DO JS -->
    <script src="./assets/js/script2.js"></script>
    <script src="https://kit.fontawesome.com/56bcd8394b.js" crossorigin="anonymous"></script>

</body>

</html>