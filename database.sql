CREATE DATABASE IF NOT EXISTS tasksync;
USE tasksync;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'comum') DEFAULT 'comum',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    descricao TEXT NOT NULL,
    setor VARCHAR(50) NOT NULL,
    prioridade ENUM('baixa', 'média', 'alta') NOT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('a fazer', 'fazendo', 'concluído') DEFAULT 'a fazer',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Inserindo usuários de teste (A senha para todos é: 123456)
INSERT INTO usuarios (nome, email, senha, perfil) VALUES 
('Admin Geral', 'admin@tasksync.com', '123456', 'admin'),
('João Silva', 'joao@tasksync.com', '123456', 'comum'),
('Maria Santos', 'maria@tasksync.com', '123456', 'comum');

-- Inserindo algumas tarefas de teste
INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, status) VALUES 
(2, 'Criar landing page da nova campanha', 'Marketing', 'alta', 'a fazer'),
(3, 'Atualizar servidores de banco de dados', 'TI', 'alta', 'fazendo');

