# 📌 TaskSync - Gerenciamento de Projetos (Kanban)

O **TaskSync** é uma aplicação web focada no gerenciamento de tarefas no estilo Kanban, desenvolvida puramente em PHP e MySQL. Este projeto foi criado como parte da avaliação de Programação Backend 2.

---

## 🚀 Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3 (Glassmorphism e Elegant Dark UI) e JavaScript Vanilla.
- **Backend:** PHP Puro (com PDO para comunicação segura com o banco).
- **Banco de Dados:** MySQL.

---

## 🛠️ Como rodar o projeto localmente

Siga o passo a passo abaixo para rodar o projeto na sua máquina utilizando o **XAMPP** (ou pacote similar com Apache e MySQL).

### 1. Preparando o ambiente
1. Exporte a pasta PHP clicando na engrenagem no canto superior direito e selecionando **"Export to ZIP"**.
2. Extraia o conteúdo e copie a pasta inteira `tasksync-php` para dentro do diretório `htdocs` do seu XAMPP (Geralmente localizado em `C:\xampp\htdocs\tasksync-php`).
3. Abra o painel de controle do XAMPP e **inicie os módulos Apache e MySQL**.

### 2. Configurando o Banco de Dados
1. Acesse o **phpMyAdmin** pelo seu navegador através da URL: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Importe o arquivo `database.sql` que está na raiz da pasta `tasksync-php`.
   > *Dica: Esse arquivo criará automaticamente o banco de dados `tasksync`, bem como todas as tabelas e dados de teste (contas de acesso e tarefas).*

### 3. Acessando o Sistema
1. Abra uma nova aba no seu navegador e acesse a URL da aplicação: [http://localhost/tasksync-php](http://localhost/tasksync-php)

---

## ✨ Funcionalidades Principais Inclusas
- [x] CRUD completo de Usuários e Tarefas em PHP.
- [x] Ausência de autenticação obrigatória (Acesso livre), facilitando avaliação e testes diretos de CRUD.
- [x] Quadro interativo no estilo Trello/Kanban usando as colunas ("A Fazer", "Fazendo", "Concluído").
- [x] Alternância da coluna de status usando botões laterais no card e também via *Drag and Drop* integrado com o sistema PHP usando fetch.
- [x] Interface 100% responsiva (Desktop, Tablets e Smartphones) focada no tema Elegant Dark.

