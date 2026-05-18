CREATE DATABASE IF NOT EXISTS tasksync;
USE tasksync;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
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

-- Inserindo usuários de teste
INSERT INTO usuarios (nome, email) VALUES 
('João Silva', 'joao@tasksync.com'),
('Maria Santos', 'maria@tasksync.com');

-- Inserindo algumas tarefas de teste
INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, status) VALUES 
(1, 'Criar landing page da nova campanha', 'Marketing', 'alta', 'a fazer'),
(2, 'Atualizar servidores de banco de dados', 'TI', 'alta', 'fazendo');

