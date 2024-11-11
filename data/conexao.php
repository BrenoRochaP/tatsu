<?php
$serverName = "localhost";
$dbName = "tatsu";
$username = "root";
$password = "";

// Cria a conexão usando mysqli
$conn = new mysqli($serverName, $username, $password, $dbName);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
}

// Defina o charset para evitar problemas com acentos e caracteres especiais
$conn->set_charset("utf8");

// SQL para criar a tabela USUARIO
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

// Executa o comando para criar a tabela USUARIO
if ($conn->query($sql_usuario) === TRUE) {
} else {
}

// SQL para criar a tabela RESERVA
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

// Executa o comando para criar a tabela RESERVA
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

// Executa o comando para criar a tabela DELIVERY
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

$sql_endereco = "
    CREATE TABLE ENDERECO(
    ID_ENDERECO INT PRIMARY KEY NOT NULL,
    RUA VARCHAR(30) NOT NULL,
    BAIRRO VARCHAR(30) NOT NULL,
    CIDADE VARCHAR(30) NOT NULL,
    COMPLEMENTO VARCHAR(20) NOT NULL,
    NUMERO INT NOT NULL);";

$sql_telefone = "
    CREATE TABLE TELEFONE(
    ID_TELEFONE INT PRIMARY KEY NOT NULL,
    NUMERO_TELEFONE VARCHAR(30) NOT NULL
    );";

$sql_finalizacao_reserva = "
    CREATE TABLE FINALIZACAO_RESERVA (
    ID_FINALIZACAO_RESERVA INT PRIMARY KEY NOT NULL,
    ID_USUARIO INT NOT NULL,
    ID_PRODUTO INT NOT NULL,
    ID_RESERVA INT NOT NULL,
    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIO,
    FOREIGN KEY (ID_PRODUTO) REFERENCES PRODUTO,
    FOREIGN KEY (ID_RESERVA) REFERENCES RESERVA);
    ";

$sql_pagamento_reserva = "
    CREATE TABLE PAGAMENTO_RESERVA(
    ID_PAGAMENTO INT PRIMARY KEY NOT NULL,
    ID_FORMA_PAGAMENTO INT NOT NULL,
    VALOR_TOTAL REAL NOT NULL,
    ID_FINALIZACAO_RESERVA INT NOT NULL,
    TAXA_RESERVA REAL NOT NULL,
    FOREIGN KEY (ID_FORMA_PAGAMENTO) REFERENCES FORMA_PAGAMENTO_RESERVA,
    FOREIGN KEY (ID_FINALIZACAO_RESERVA) REFERENCES FINALIZACAO_RESERVA);";

$sql_forma_pagamento_reserva = "
    CREATE TABLE FORMA_PAGAMENTO_RESERVA (
    ID_FORMA_PAGAMENTO INT PRIMARY KEY NOT NULL,
    DESCRICAO_FORMA_PAGAMENTO VARCHAR(100) NOT NULL);
    ";

$sql_pagamentoxgerencia_reserva = "
    CREATE TABLE PAGAMENTOXGERENCIA_RESERVA(
    ID_PAGAMENTO INT NOT NULL,
    ID_GERENTE INT NOT NULL,
    FOREIGN KEY (ID_PAGAMENTO) REFERENCES PAGAMENTO_RESERVA,
    FOREIGN KEY (ID_GERENTE) REFERENCES GERENCIA_RESERVA);
    ";

$sql_gerencia_reserva = "
    CREATE TABLE GERENCIA_RESERVA(
    ID_GERENTE INT PRIMARY KEY NOT NULL,
    DATA_NASCIMENTO_GERENTE DATE NOT NULL,
    NOME_GERENTE VARCHAR(100) NOT NULL);";

$sql_pedido = "
    CREATE TABLE PEDIDO(
    ID_PEDIDO INT PRIMARY KEY NOT NULL,
    ID_USUARIO INT NOT NULL,
    ID_PRODUTO INT NOT NULL,
    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIO,
    FOREIGN KEY (ID_PRODUTO) REFERENCES PRODUTO);
    ";

$sql_pagamento_delivery = "
    CREATE TABLE PAGAMENTO_DELIVERY(
    ID_PAGAMENTO INT PRIMARY KEY NOT NULL,
    ID_FORMA_PAGAMENTO INT NOT NULL,
    ID_FINALIZACAO_RESERVA INT NOT NULL,
    VALOR_TOTAL REAL NOT NULL,
    ID_PEDIDO INT NOT NULL,
    ID_USUARIO INT NOT NULL,
    TAXA_ENVIO REAL NOT NULL,
    FOREIGN KEY (ID_FORMA_PAGAMENTO) REFERENCES FORMA_PAGAMENTO_RESERVA,
    FOREIGN KEY (ID_FINALIZACAO_RESERVA) REFERENCES FINALIZACAO_RESERVA,
    FOREIGN KEY (ID_PEDIDO) REFERENCES PEDIDO,
    FOREIGN KEY (ID_USUARIO) REFERENCES USUARIO);
    ";

$sql_pagamentoxgerencia = "
    CREATE TABLE PAGAMENTOxGERENCIA (
    ID_GERENTE INT  NOT NULL,
    ID_PAGAMENTO INT NOT NULL,
    FOREIGN KEY (ID_GERENTE) REFERENCES GERENCIA_DELIVERY,
    FOREIGN KEY (ID_PAGAMENTO) REFERENCES PAGAMENTO_DELIVERY);
    ";

$sql_forma_pagamento_delivery = "
    CREATE TABLE FORMA_PAGAMENTO_DELIVERY (
    ID_FORMA_PAGAMENTO INT PRIMARY KEY NOT NULL,
    DESCRICAO_FORMA_PAGAMENTO VARCHAR(100) NOT NULL);
    ";

$sql_envio = "
    CREATE TABLE ENVIO(
    ID_ENVIO INT PRIMARY KEY NOT NULL,
    ID_PEDIDO INT NOT NULL,
    NOME_ENTREGADOR VARCHAR(100) NOT NULL,
    TEMPO_ENVIO TIME NOT NULL,
    FOREIGN KEY (ID_PEDIDO) REFERENCES PEDIDO);
    ";

$sql_produto = "
    CREATE TABLE PRODUTO (
    ID_PRODUTO INT PRIMARY KEY NOT NULL,
    PRECO_PRODUTO INT NOT NULL,
    NOME_PRODUTO VARCHAR(100) NOT NULL,
    DESCRICAO_PRODUTO VARCHAR(100) NOT NULL);";

$sql_estoque = "
    CREATE TABLE ESTOQUE(
    ID_PRODUTO INT NOT NULL,
    QUANTIDADE_PRODUTO INT NOT NULL,
        FOREIGN KEY (ID_PRODUTO) REFERENCES PRODUTO);";


$sql_gerencia_delivery = "    
    CREATE TABLE GERENCIA_DELIVERY(
    ID_GERENTE INT PRIMARY KEY NOT NULL,
    DATA_NASCIMENTO_GERENTE DATE NOT NULL,
    NOME_GERENTE VARCHAR(100)NOT NULL);";





// Executa o comando para criar a tabela RESERVA
if ($conn->query($sql_reserva) === TRUE) {
} else {
}

// Fecha a conexão
?>