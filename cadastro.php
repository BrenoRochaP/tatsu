<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro Tatsu</title>
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
    <link rel="stylesheet" href="./assets/css/style2.css">

</head>

<body>
    <!-- INICIO PHP -->
    <?php
    include('data/conexao.php');
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        header("Location: index.php");
        $nome = $_POST['nome']; 
        $email = $_POST['email']; 
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); 
        $data_nasc = $_POST['data_nasc']; 
        $genero = $_POST['genero']; 
        $endereco = $_POST['endereco']; 
        $estado = $_POST['estado']; 
    
        $sql = "INSERT INTO usuario(NOME_USUARIO, EMAIL_USUARIO, SENHA_USUARIO, DATA_NASC, GENERO, ENDERECO, ESTADO)
 
	VALUES ('$nome', '$email', '$senha', '$data_nasc', '$genero', '$endereco', '$estado')";
    
        if ($conn->query($sql) === TRUE) { 
            echo "Cadastro realizado com sucesso!";
        } else {
        }
    }
    ?>
    <!-- FIM PHP -->
<!-- INICIO HTML -->
    <a href="index.php" class="btn" data-btn>Voltar</a>
    <br />
    <section class="container">
        <header>Cadastre-se</header>
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
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary mt-4">
            <p style="color: #b8b8b8;">Já possui uma conta?<a href="login.php"
                    style="text-decoration: none; color: white;">
                    Login</a></p>
        </form>

    </section>

    <!-- SCRIPTS DO JS -->
    <script src="./assets/js/script2.js"></script>
    <script src="https://kit.fontawesome.com/56bcd8394b.js" crossorigin="anonymous"></script>

</body>

</html>
<!-- FIM HTML -->