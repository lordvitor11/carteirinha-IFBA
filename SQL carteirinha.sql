CREATE TABLE IF NOT EXISTS usuario (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(45) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha INT NOT NULL,
    telefone VARCHAR(11) NOT NULL,
    endereco VARCHAR(45) NOT NULL
);

CREATE TABLE IF NOT EXISTS cardapio (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descricao TEXT NOT NULL,
    data_refeicao DATE NOT NULL,
    foto INT NOT NULL,
    principal VARCHAR(45) NOT NULL,
    sobremesa VARCHAR(45)
);

CREATE TABLE IF NOT EXISTS refeicao (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_usuario INT NOT NULL,
    id_cardapio INT NOT NULL,
    estado_ref VARCHAR(45) NOT NULL,
    data_refeicao DATE NOT NULL,
    horario TIME NOT NULL,
    
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    FOREIGN KEY (id_cardapio) REFERENCES cardapio(id),
    FOREIGN KEY (estado_ref) REFERENCES estado_ref(descricao)
);

CREATE TABLE IF NOT EXISTS estado_ref (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(45) NOT NULL
);