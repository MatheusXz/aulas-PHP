-- Criação da tabela `usuarios`
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_nome VARCHAR(100) NOT NULL,
  user_cpf VARCHAR(14) UNIQUE NOT NULL,
  user_logradouro VARCHAR(200) NOT NULL,
  user_numero VARCHAR(5) NOT NULL DEFAULT 'SN',
  user_bairro VARCHAR(200) NOT NULL,
  user_cidade VARCHAR(200) NOT NULL,
  user_estado VARCHAR(30) NOT NULL,
  user_cep VARCHAR(30) NOT NULL,
  user_telefone VARCHAR(20) NOT NULL,
  user_data_nascimento DATE NOT NULL,
  user_email VARCHAR(100) UNIQUE NOT NULL,
  user_senha VARCHAR(100) NOT NULL,
  user_data_cadastro DATETIME NOT NULL,
  user_tipo ENUM('usuario', 'funcionario', 'off') NOT NULL
  user_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Criação da tabela `autores`
CREATE TABLE autores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aut_nome_completo VARCHAR(100) NOT NULL, -- feito
  aut_data_nascimento DATE NOT NULL,       -- feito
  aut_nacionalidade VARCHAR(100) NOT NULL, -- feito
  aut_biografia TEXT,
  aut_foto VARCHAR(200) -- feito
  aut_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Criação da tabela `livros`
CREATE TABLE livros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lib_codigo_isbn VARCHAR(20) NOT NULL,
  lib_nome_obra VARCHAR(150) NOT NULL,
  autor_id INT NOT NULL,
  lib_edicao VARCHAR(20) NOT NULL,
  lib_editora VARCHAR(100) NOT NULL,
  lib_ano_publicacao INT NOT NULL,
  lib_numero_paginas INT NOT NULL,
  lib_quantidade INT NOT NULL,
  lib_data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
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