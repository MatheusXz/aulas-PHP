-- Criação da tabela `usuarios`
use s222_matheus35;
CREATE TABLE usuarios (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_nome VARCHAR(100) NOT NULL, -- feito
  user_cpf VARCHAR(11) UNIQUE NOT NULL, -- feito
  user_logradouro VARCHAR(200) NOT NULL, -- feito
  user_numero VARCHAR(10) NOT NULL DEFAULT 'SN', -- feito
  user_bairro VARCHAR(100) NOT NULL, -- feito
  user_cidade VARCHAR(100) NOT NULL, -- feito
  user_estado CHAR(2) NOT NULL, -- feito
  user_cep VARCHAR(10) NOT NULL, -- feito
  user_telefone VARCHAR(20) NOT NULL, -- feito
  user_data_nascimento DATE NOT NULL, -- feito
  user_email VARCHAR(100) UNIQUE NOT NULL, -- feito
  user_senha VARCHAR(100) NOT NULL, -- feito
  user_caminho_imagem VARCHAR(255) NOT NULL, -- feito
  user_tipo ENUM('usuario', 'funcionario', 'off', 'adm') NOT NULL, -- feito
  user_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP -- feito
);



-- criada a usuarios

-- Criação da tabela `autores`
CREATE TABLE autores (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  aut_nome_completo VARCHAR(100) NOT NULL, -- feito
  aut_data_nascimento DATE NOT NULL,       -- feito
  aut_nacionalidade VARCHAR(100) NOT NULL, -- feito
  aut_biografia varchar(500),
  aut_caminho_imagem VARCHAR(255), -- feito
  aut_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- criada a autores

-- Criação da tabela `livros`
CREATE TABLE livros (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  lib_codigo_isbn VARCHAR(20) NOT NULL,
  lib_nome_obra VARCHAR(150) NOT NULL,
  autor_id INT NOT NULL,
  lib_edicao VARCHAR(20) NOT NULL,
  lib_editora VARCHAR(100) NOT NULL,
  lib_ano_publicacao char(4) NOT NULL,
  lib_numero_paginas varchar(10) NOT NULL,
  lib_quantidade VARCHAR(10) NOT NULL,
  lib_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  lib_caminho_imagem VARCHAR(255), -- Coluna para armazenar o caminho da imagem
  FOREIGN KEY (autor_id) REFERENCES autores(id)
);


-- Criação da tabela `emprestimos`
CREATE TABLE emprestimos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_livro INT NOT NULL,
  emp_data_emprestimo DATETIME NOT NULL,
  emp_data_devolucao DATETIME NOT NULL,
  emp_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
  FOREIGN KEY (id_livro) REFERENCES livros(id)
);

DROP TABLE emprestimos;
DROP TABLE livros;
DROP TABLE usuarios;

MUDAR CPF E EMAIL PARA UNIQUE