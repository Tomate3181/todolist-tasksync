<?php
require 'config.php';

$tarefa_edit = null;
$erro = '';

// Salvar/Atualizar tarefa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['salvar'])) {
    $usuario_id = $_POST['usuario_id'] ?? '';
    $descricao = trim($_POST['descricao']);
    $setor = trim($_POST['setor']);
    $prioridade = trim($_POST['prioridade']);
    
    // Validação
    if (empty($usuario_id) || empty($descricao) || empty($setor) || empty($prioridade)) {
        $erro = "Todos os campos são obrigatórios, não podem estar vazios!";
    } else {
        if (!empty($_POST['id'])) {
            // Atualização
            $id = $_POST['id'];
            $stmt = $pdo->prepare("UPDATE tarefas SET usuario_id=?, descricao=?, setor=?, prioridade=? WHERE id=?");
            $stmt->execute([$usuario_id, $descricao, $setor, $prioridade, $id]);
            header("Location: index.php");
            exit;
        } else {
            // Inserção nova tarefa
            $stmt = $pdo->prepare("INSERT INTO tarefas (usuario_id, descricao, setor, prioridade) VALUES (?, ?, ?, ?)");
            $stmt->execute([$usuario_id, $descricao, $setor, $prioridade]);
            header("Location: index.php");
            exit;
        }
    }
}

// Exclusão via URL
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Busca para edição
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
    $tarefa_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca usuários para o Select
$usuarios = $pdo->query("SELECT id, nome FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas - TaskSync</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="glass-nav">
        <div class="logo"><i class="fas fa-layer-group"></i> TaskSync</div>
        <ul>
            <li><a href="index.php">Kanban</a></li>
            <li><a href="usuarios.php">Usuários</a></li>
            <li><a href="tarefas.php" class="active">Tarefas</a></li>
        </ul>
    </nav>

    <main class="container">
        <div class="form-container glass">
            <h2><i class="fas fa-tasks"></i> <?= $tarefa_edit ? 'Editar Tarefa' : 'Cadastrar Tarefa' ?></h2>
            
            <?php if($erro): ?>
                <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; border: 1px solid rgba(239, 68, 68, 0.3);">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $tarefa_edit ? $tarefa_edit['id'] : '' ?>">
                
                <div class="form-group">
                    <label>Usuário Responsável</label>
                    <select name="usuario_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id'] ?>" <?= ($tarefa_edit && $tarefa_edit['usuario_id'] == $u['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($u['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Descrição</label>
                    <textarea name="descricao" required rows="3"><?= $tarefa_edit ? htmlspecialchars($tarefa_edit['descricao']) : '' ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Setor</label>
                        <input type="text" name="setor" required value="<?= $tarefa_edit ? htmlspecialchars($tarefa_edit['setor']) : '' ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Prioridade</label>
                        <select name="prioridade" required>
                            <option value="">Selecione...</option>
                            <option value="baixa" <?= ($tarefa_edit && $tarefa_edit['prioridade'] == 'baixa') ? 'selected' : '' ?>>Baixa</option>
                            <option value="média" <?= ($tarefa_edit && $tarefa_edit['prioridade'] == 'média') ? 'selected' : '' ?>>Média</option>
                            <option value="alta" <?= ($tarefa_edit && $tarefa_edit['prioridade'] == 'alta') ? 'selected' : '' ?>>Alta</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="salvar" class="btn btn-primary"><?= $tarefa_edit ? 'Salvar Alterações' : 'Cadastrar' ?></button>
            </form>
        </div>
    </main>
</body>
</html>
