<?php
include('data/conexao.php');
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- META TAGS -->
    <title>Tatsu Sushi Bar</title>
    <meta name="title" content="Tatsu Sushi Bar">
    <meta name="description" content="Tatsu Sushi Bar">

    <!-- ICONES -->
    <link rel="icon" href="./assets/images/dragaoicone.png" type="image/x-icon">

    <!-- LINK GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700&family=Work+Sans:wght@600&display=swap"
        rel="stylesheet">

    <!-- LINK CUSTOMIZADO DO JS -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- PRELOAD DAS IMAGENS -->
    <link rel="preload" as="image" href="./assets/images/sushi-banner-bg.jpg">

</head>

<body id="top">

    <!-- HEADER -->
    <!-- INICIO CSS -->
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #222;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.5);
            z-index: 1;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }

        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            visibility: visible;
        }

        .dropdown-content a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #800000;
        }
    </style>
    <!-- FIM CSS -->
    <!-- INICIO HTML -->
    <header class="header active" data-header>
        <div class="container">

            <a href="#home" class="logo">
                <img src="./assets/images/logo.png" alt="unigine home">
            </a>

            <nav class="navbar" data-navbar>
                <ul class="navbar-list">

                    <li class="navbar-item">
                        <a href="#localizacao" class="navbar-link" data-nav-link>Localização</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#premios" class="navbar-link" data-nav-link>Prêmios</a>
                    </li>

                    <li class="navbar-item">
                        <a href="#sobrenos" class="navbar-link" data-nav-link>Sobre Nós</a>
                    </li>

                </ul>
            </nav>
            <!-- INICIO PHP -->
            <?php if (isset($_SESSION['email'])): ?>
                <!-- Se a sessão estiver ativa, exibe o botão Sair -->
                <a href="carrinho.php" class="btn" data-btn>CARRINHO</a>
                <a href="pedidos.php" class="btn" data-btn>PEDIDOS</a>
                <div class="dropdown">
                    <div><img src="assets/images/perfil.png" style=" width: 55px;">
                        <div class="dropdown-content">
                            <a href="visualizar_usuario.php">Seus Dados</a>
                            <a href="crud_usuario.php">Alterar Usuário</a>
                            <a href="logout.php">Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Se a sessão não estiver ativa, exibe os botões de Cadastro e Login -->
                    <a href="cadastro.php" class="btn" data-btn>CADASTRAR</a>
                    <a href="login.php" class="btn" data-btn>ENTRAR</a>
                <?php endif; ?>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['cod_adm'])) {
                        $cod_adm = $_POST['cod_adm'];
                        if ($cod_adm == '100') {
                            echo "<script>abrirModal();</script>";
                        } else {
                            $erro = "Código inválido. Tente novamente.";
                        }
                    }
                }


                include('data/conexao.php');

                ?>
                <!-- FIM PHP -->
                <button class="nav-toggle-btn" aria-label="toggle menu" data-nav-toggler>
                    <span class="line line-1"></span>
                    <span class="line line-2"></span>
                    <span class="line line-3"></span>
                </button>

            </div>
    </header>

    <main>
        <article>
            <!-- HOME -->
            <div class="home has-before" id="home">
                <div class="container">

                    <p class="section-subtitle">TATSU SUSHI BAR</p>

                    <br />
                    <br />

                    <h1 class="h1 title home-title">SABORES DO JAPÃO<br>A CADA MORDIDA!</h1>

                    <br />
                    <br />
                    <div class="deliveryereserva">
                        <a href="delivery.php" class="btn" data-btn>PEÇA JÁ</a>
                        <a href="reserva.php" class="btn" data-btn>RESERVE JÁ</a>
                    </div>
                    <div class="home-banner">

                        <img src="./assets/images/sushi-banner-bg.jpg" alt="" class="home-banner-bg">
                    </div>

                </div>
            </div>

            <!-- LOCALIZAÇÃO -->
            <section class="section upcoming" aria-labelledby="upcoming-label" id="localizacao">
                <div class="container">

                    <p class="section-subtitle" id="upcoming-label" data-reveal="bottom">
                        Localização
                    </p>

                    <h2 class="h2 section-title" data-reveal="bottom">
                        Nós estamos <br> onde <span class="span">Você está</span>
                    </h2>

                    <p class="section-text" data-reveal="bottom">
                        Em nosso restaurante, não apenas servimos refeições, mas também criamos momentos únicos, estando
                        sempre onde
                        você mais precisa: no paladar, na experiência e na lembrança de cada sabor.
                    </p>

                    <ol class="upcoming-list">

                        <li class="upcoming-item">

                            <div class="upcoming-card left has-before" data-reveal="left">

                                <img src="./assets/images/sjc.png" width="86" height="81" loading="lazy"
                                    alt="São José dos Campos" class="card-banner">

                                <h3 class="h3 card-title">São José dos Campos</h3>

                                <div class="card-meta">Aquarius</div>

                            </div>

                            <div class="upcoming-time" data-reveal="bottom">
                                <time class="time" datetime="10:00">SP</time>

                                <time class="date" datetime="2022-05-25">SINCE 2022</time>

                                <div class="social-wrapper">
                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                    </a>

                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                    </a>
                                </div>
                            </div>

                            <div class="upcoming-card right has-before" data-reveal="right">

                                <img src="./assets/images/cmp.png" width="86" height="81" loading="lazy" alt="Campinas"
                                    class="card-banner">

                                <h3 class="h3 card-title">Campinas</h3>

                                <div class="card-meta">Cambuí</div>

                            </div>

                        </li>

                        <li class="upcoming-item">

                            <div class="upcoming-card left has-before" data-reveal="left">

                                <img src="./assets/images/blh.png" width="86" height="81" loading="lazy"
                                    alt="Belo Horizonte" class="card-banner">

                                <h3 class="h3 card-title">Belo Horizonte</h3>

                                <div class="card-meta">Belvedere</div>

                            </div>

                            <div class="upcoming-time" data-reveal="bottom">
                                <time class="time" datetime="10:00">MG</time>

                                <time class="date" datetime="2022-05-25">SINCE 2023</time>

                                <div class="social-wrapper">
                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                    </a>

                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                    </a>
                                </div>
                            </div>

                            <div class="upcoming-card right has-before" data-reveal="right">

                                <img src="./assets/images/op.jpg" width="86" height="81" loading="lazy" alt="Ouro Preto"
                                    class="card-banner">

                                <h3 class="h3 card-title">Ouro Preto</h3>

                                <div class="card-meta">Pilar</div>

                            </div>

                        </li>

                        <li class="upcoming-item">

                            <div class="upcoming-card left has-before" data-reveal="left">

                                <img src="./assets/images/rj.jpg" width="86" height="81" loading="lazy"
                                    alt="Rio de Janeiro" class="card-banner">

                                <h3 class="h3 card-title">Rio de <br />Janeiro</h3>

                                <div class="card-meta">Leblon</div>

                            </div>

                            <div class="upcoming-time" data-reveal="bottom">
                                <time class="time" datetime="10:00">RJ</time>

                                <time class="date" datetime="2022-05-25">SINCE 2024</time>

                                <div class="social-wrapper">
                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                    </a>

                                    <a href="#" class="social-link">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                    </a>
                                </div>
                            </div>

                            <div class="upcoming-card right has-before" data-reveal="right">

                                <img src="./assets/images/ntr.jpg" width="86" height="81" loading="lazy" alt="Niterói"
                                    class="card-banner">

                                <h3 class="h3 card-title">Niterói</h3>

                                <div class="card-meta">Cambuí</div>

                            </div>

                        </li>

                    </ol>

                </div>
            </section>

            <!-- PRÊMIOS -->

            <section class="section premios" aria-label="our latest premios" id="premios">
                <div class="container">

                    <p class="section-subtitle" data-reveal="bottom">Prêmios</p>

                    <h2 class="h2 section-title" data-reveal="bottom">
                        Nossos pratos <span class="span">Premiados</span>
                    </h2>

                    <p class="section-text" data-reveal="bottom">
                        Sabores que conquistam paladares e prêmios: na Tatsu Sushi Bar, cada prato é uma obra-prima
                        reconhecida.
                    </p>

                    <ul class="premios-list">

                        <li data-reveal="bottom">
                            <div class="premios-card">

                                <figure class="card-banner img-holder" style="--width: 600; --height: 400;">
                                    <img src="./assets/images/sashimi.jpg" width="600" height="400" loading="lazy"
                                        alt="Innovative Business All Over The World." class="img-cover">
                                </figure>

                                <div class="card-content">

                                    <a href="#" class="card-tag">Sashimi</a>

                                    <ul class="card-meta-list">

                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                                            <time class="card-meta-text" datetime="2022-01-01">Jan 01 2022</time>
                                        </li>


                                    </ul>

                                    <h3 class="h3">
                                        <a href="#" class="card-title">San Pellegrino Young Chef.</a>
                                    </h3>

                                    <p class="card-text">
                                        Competição internacional que destaca jovens chefs promissores com menos de 30
                                        anos.
                                    </p>

                                    <a href="#" class="link has-before">Saiba mais</a>

                                </div>

                            </div>
                        </li>

                        <li data-reveal="bottom">
                            <div class="premios-card">

                                <figure class="card-banner img-holder" style="--width: 600; --height: 400;">
                                    <img src="./assets/images/ramen.jpg" width="600" height="400" loading="lazy"
                                        alt="How To Start Initiating An Startup In Few Days." class="img-cover">
                                </figure>

                                <div class="card-content">

                                    <a href="#" class="card-tag">Ramen</a>

                                    <ul class="card-meta-list">

                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                                            <time class="card-meta-text" datetime="2022-01-01">Out 09 2023</time>
                                        </li>

                                    </ul>

                                    <h3 class="h3">
                                        <a href="#" class="card-title">Guia Gault & Millau.</a>
                                    </h3>

                                    <p class="card-text">
                                        Guia francês que classifica restaurantes com base na qualidade da comida,
                                        serviço e ambiente.
                                    </p>

                                    <a href="#" class="link has-before">Saiba mais</a>

                                </div>

                            </div>
                        </li>

                        <li data-reveal="bottom">
                            <div class="premios-card">

                                <figure class="card-banner img-holder" style="--width: 600; --height: 400;">
                                    <img src="./assets/images/sushi.jpg" width="600" height="400" loading="lazy"
                                        alt="Financial Experts Support Help You To Find Out." class="img-cover">
                                </figure>

                                <div class="card-content">

                                    <a href="#" class="card-tag">Sushi</a>

                                    <ul class="card-meta-list">

                                        <li class="card-meta-item">
                                            <ion-icon name="calendar-outline" aria-hidden="true"></ion-icon>

                                            <time class="card-meta-text" datetime="2022-01-01">Dez 15 2024</time>
                                        </li>

                                    </ul>

                                    <h3 class="h3">
                                        <a href="#" class="card-title">50 Best Restaurants.</a>
                                    </h3>

                                    <p class="card-text">
                                        A lista dos "50 Melhores Restaurantes do Mundo" é publicada anualmente pela
                                        "Restaurant".
                                    </p>

                                    <a href="#" class="link has-before">Saiba mais</a>

                                </div>

                            </div>
                        </li>

                    </ul>

                </div>
            </section>

        </article>
    </main>

    <!-- SOBRE NÓS -->
    <footer class="footer" id="sobrenos">

        <div class="section footer-top">
            <div class="container">

                <div class="footer-brand">

                    <a href="#" class="logo">
                        <img src="./assets/images/logo-footer.png" width="2108" height="576" loading="lazy"
                            alt="Unigine logo">
                    </a>

                    <p class="footer-text">
                        Nosso sucesso na arte de criar pratos japoneses refinados se deve em grande parte à nossa equipe
                        talentosa e
                        altamente dedicada.
                    </p>

                    <ul class="social-list">

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" target=_blank class="social-link">
                                <ion-icon name="logo-instagram"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-youtube"></ion-icon>
                            </a>
                        </li>

                    </ul>

                </div>

                <div class="footer-list">

                    <p class="title footer-list-title ">Informações</p>

                    <ul>

                        <li>
                            <a href="#" class="footer-link">Próximas premiações</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Central de ajuda</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Política e privacidade</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Termos de uso</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Contacte-nos</a>
                        </li>

                    </ul>

                </div>

                <div class="footer-list">

                    <p class="title footer-list-title ">Contacte-nos</p>

                    <div class="contact-item">
                        <span class="span">Localização mais próxima:</span>

                        <address class="contact-link">
                            Avenida Cassiano Ricardo, 3193 - Jardim Aquarius, São José dos Campos - SP, 12246-870.
                        </address>
                    </div>

                    <div class="contact-item">
                        <span class="span">Junte-se a nós:</span>

                        <a href="#" class="contact-link">tatsusushibar@gmail.com.br</a>
                    </div>

                    <div class="contact-item">
                        <span class="span">Telefone:</span>

                        <a href="tel:+12345678910" class="contact-link">+55 (12) 3456-7890</a>
                    </div>

                </div>

                <div class="footer-list">

                    <p class="title footer-list-title ">Central do administrador:</p>

                    <form method="post" class="footer-form" onsubmit="return abrirModal()">
                        <input type="number" name="cod_adm" placeholder="Seu código de administrador..."
                            class="input-field">
                        <button type="submit" class="btn" data-btn>Entrar</button>
                    </form>

                    <div id="modal" class="modal">
                        <div class="modal-content">
                            <p>Para qual página deseja ser direcionado?</p>
                            <div class="modal-buttons">
                                <button onclick="redirecionarPagina('reserva_adm.php')"
                                    class="modal-button reserva">Reserva</button>
                                <button onclick="redirecionarPagina('delivery_adm.php')"
                                    class="modal-button delivery">Delivery</button>
                            </div>
                        </div>
                    </div>
                    <!-- INICIO CSS -->
                    <style>
                        .modal {
                            display: none;
                            position: fixed;
                            z-index: 1000;
                            left: 0;
                            top: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.5);
                            backdrop-filter: blur(4px);
                        }

                        .modal-content {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            background: #111;
                            padding: 20px;
                            border-radius: 8px;
                            text-align: center;
                        }

                        .modal-buttons {
                            display: flex;
                            justify-content: center;
                            margin-top: 10px;
                        }

                        .modal-button {
                            padding: 10px 20px;
                            margin: 0 5px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                        }

                        .reserva {
                            background-color: #800000;
                            color: #fff;
                            border-radius: 30px;
                        }

                        .delivery {
                            background-color: #800000;
                            color: #fff;
                            border-radius: 30px;
                        }
                    </style>
                    <!-- FIM CSS -->
                    <script>
                        function abrirModal() {
                            const codAdmInput = document.querySelector('input[name="cod_adm"]').value;

                            if (codAdmInput === '100') {
                                document.getElementById("modal").style.display = "block";
                                return false;
                            } else {
                                alert("Código inválido. Tente novamente.");
                                return false;
                            }
                        }

                        function redirecionarPagina(pagina) {
                            window.location.href = pagina;
                        }
                    </script>



                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">

                <p class="copyright">
                    &copy; 2024 TCC GRUPO TATSU SUSHI BAR.
                </p>

            </div>
        </div>

    </footer>
    <!-- VOLTAR AO TOPO -->

    <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
        <ion-icon name="arrow-up-outline" aria-hidden="true"></ion-icon>
    </a>
    <!-- #CURSOR CUSTOMIZADO -->

    <div class="cursor" data-cursor></div>

    <!-- LINK CUSTOMIZADO DO JS -->
    <script src="./assets/js/script.js"></script>

    <!-- LINK IONICON -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>