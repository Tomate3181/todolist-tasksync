<?php
require 'config.php';

// Inserir novo usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->execute([$nome, $email]);
    header("Location: usuarios.php?msg=usuario_cadastrado");
    exit;
}

// Excluir usuário
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: usuarios.php?msg=usuario_excluido");
    exit;
}

// Buscar usuários
$usuarios = $pdo->query("SELECT * FROM usuarios ORDER BY data_cadastro DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - TaskSync</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="glass-nav">
        <div class="logo"><i class="fas fa-layer-group"></i> TaskSync</div>
        <ul>
            <li><a href="index.php">Kanban</a></li>
            <li><a href="usuarios.php" class="active">Usuários</a></li>
            <li><a href="tarefas.php">Tarefas</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="form-container glass">
            <h2><i class="fas fa-user-plus"></i> Cadastrar Usuário</h2>
            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nome Completo</label>
                        <input type="text" name="nome" required placeholder="Ex: Ana Souza">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" required placeholder="Ex: ana@empresa.com">
                    </div>
                </div>
                <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
            </form>
        </div>

        <div class="list-container glass">
            <h2>Usuários Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <a href="?excluir=<?= $u['id'] ?>" class="text-danger" data-confirm="Deseja excluir este usuário? As tarefas dele também serão apagadas."><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
