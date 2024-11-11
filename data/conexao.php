<?php
$serverName = "localhost";
$dbName = "tatsu";
$username = "root";
$password = "";

$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
}

$conn->set_charset("utf8");

$sql_usuario = "
    CREATE TABLE IF NOT EXISTS USUARIO(
        ID_USUARIO INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        NOME_USUARIO VARCHAR(100) NOT NULL,
        EMAIL_USUARIO VARCHAR(100) NOT NULL,
        SENHA_USUARIO VARCHAR(255) NOT NULL,
        DATA_NASC DATE NOT NULL,
        GENERO VARCHAR(100) NOT NULL,
        ENDERECO VARCHAR(100) NOT NULL,
        ESTADO VARCHAR(100) NOT NULL
    );
";

if ($conn->query($sql_usuario) === TRUE) {
} else {
}

$sql_reserva = "
    CREATE TABLE IF NOT EXISTS RESERVA(
        ID_RESERVA INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        NOME_CLIENTE VARCHAR(100) NOT NULL,
        EMAIL_CLIENTE VARCHAR(100) NOT NULL,
        QUANTIDADE_PESSOAS INT(11) NOT NULL,
        DIA_RESERVA DATE NOT NULL,
        HORA_RESERVA TIME NOT NULL,
        AREA_RESTAURANTE VARCHAR(100) NOT NULL,
        TIPO_RESERVA VARCHAR(100) NOT NULL,
        OBSERVACOES VARCHAR(255) NOT NULL,
        ID_USUARIO INT(6) UNSIGNED,
        FOREIGN KEY (ID_USUARIO) REFERENCES USUARIO(ID_USUARIO)
    );
";

if ($conn->query($sql_reserva) === TRUE) {
} else {
}

$sql_delivery = "
    CREATE TABLE IF NOT EXISTS DELIVERY(
        ID_RESERVA INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        NOME_CLIENTE VARCHAR(100) NOT NULL,
        EMAIL_CLIENTE VARCHAR(100) NOT NULL,
        QUANTIDADE_PESSOAS INT(11) NOT NULL,
        DIA_RESERVA DATE NOT NULL,
        HORA_RESERVA TIME NOT NULL,
        AREA_RESTAURANTE VARCHAR(100) NOT NULL,
        TIPO_RESERVA VARCHAR(100) NOT NULL,
        OBSERVACOES VARCHAR(255) NOT NULL,
        ID_USUARIO INT(6) UNSIGNED,
        FOREIGN KEY (ID_USUARIO) REFERENCES USUARIO(ID_USUARIO)
    );
";

if ($conn->query($sql_delivery) === TRUE) {
} else {
}

$sql_item = "
    CREATE TABLE IF NOT EXISTS item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    imagem VARCHAR(255) NOT NULL
);
";

if ($conn->query($sql_item) === TRUE) {
} else {
    echo "Erro ao criar tabela item: " . $conn->error;
}

$sql_carrinho = "
    CREATE TABLE IF NOT EXISTS carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    item_id INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (item_id) REFERENCES item(id) ON DELETE CASCADE
);
";

if ($conn->query($sql_carrinho) === TRUE) {
} else {
    echo "Erro ao criar tabela carrinho: " . $conn->error;
}

$sql_pedidos = "
    CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Coluna de data do pedido
    endereco_id INT,
    status ENUM('Pago', 'Pago na Entrega') NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (endereco_id) REFERENCES enderecos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
";

if ($conn->query($sql_pedidos) === TRUE) {
} else {
    echo "Erro ao criar tabela pedidos: " . $conn->error;
}

$sql_itens_pedido = "
    CREATE TABLE IF NOT EXISTS itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    item_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES item(id) ON DELETE CASCADE
);
";

if ($conn->query($sql_itens_pedido) === TRUE) {
} else {
    echo "Erro ao criar tabela itens_pedido: " . $conn->error;
}

$sql_status_pedido = "
    CREATE TABLE IF NOT EXISTS status_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    status VARCHAR(20) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);
";

if ($conn->query($sql_status_pedido) === TRUE) {
} else {
    echo "Erro ao criar tabela status_pedido: " . $conn->error;
}

$sql_endereco = "
    CREATE TABLE IF NOT EXISTS enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    complemento VARCHAR(10),
    cep VARCHAR(10) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado VARCHAR(2) NOT NULL
);
";

if ($conn->query($sql_endereco) === TRUE) {
} else {
    echo "Erro ao criar tabela endereco: " . $conn->error;
}
?>