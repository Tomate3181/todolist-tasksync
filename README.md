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
2. Você será redirecionado automaticamente para a tela de **Login**.

---

## 🔐 Usuários para Teste

O sistema foi implementado com um controle de acessos (login restrito) contendo dois níveis de permissões. Utilize as credenciais abaixo para testar as funcionalidades:

### 👑 Perfil Administrador
Tem acesso total ao sistema. Pode visualizar, editar, mover ou excluir **todas as tarefas** (mesmo as criadas por outros), além de ter a permissão exclusiva de acessar a aba de **Cadastrar Usuários**.
- **E-mail:** `admin@tasksync.com`
- **Senha:** `123456`

### 👤 Perfil Comum
Possui acesso ao quadro de tarefas. Pode visualizar todas as atividades, no entanto só tem permissão para **editar, excluir ou movimentar as tarefas que ele mesmo cadastrou**. Usuários comuns não podem acessar as configurações de outros usuários.
- **E-mail:** `joao@tasksync.com`
- **Senha:** `123456`

*(Temos também a usuária `maria@tasksync.com` que utiliza a mesma senha `123456`, útil para testar os conflitos de permissão entre contas comuns na manipulação das tarefas).*

---

## ✨ Funcionalidades Principais Inclusas
- [x] Login e autenticação segura com senhas protegidas por Hash (BCRYPT).
- [x] Restrição de Views e de Ações no PHP baseadas no Perfil de Acesso do usuário logado.
- [x] Quadro interativo no estilo Trello/Kanban usando as colunas ("A Fazer", "Fazendo", "Concluído").
- [x] Alternância da coluna de status usando botões laterais no card e também via *Drag and Drop* integrado com o sistema PHP.
- [x] Interface 100% responsiva (Desktop, Tablets e Smartphones) criada focada no tema Elegant Dark.
