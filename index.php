<?php
require 'config.php';

// Lógica de mover tarefa via botões sem precisar arrastar
if (isset($_GET['mover']) && isset($_GET['novo_status'])) {
    $id_mover = $_GET['mover'];
    $novo_status = $_GET['novo_status'];
    
    if (in_array($novo_status, ['a fazer', 'fazendo', 'concluído'])) {
        $stmt = $pdo->prepare("UPDATE tarefas SET status = ? WHERE id = ?");
        $stmt->execute([$novo_status, $id_mover]);
        header("Location: index.php?msg=tarefa_movida&para=" . urlencode($novo_status));
        exit;
    }
}

// Busca todas as tarefas associadas aos usuários
$stmt = $pdo->query("
    SELECT t.*, u.nome as usuario_nome 
    FROM tarefas t 
    JOIN usuarios u ON t.usuario_id = u.id 
    ORDER BY t.prioridade DESC, t.data_cadastro DESC
");
$tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$colunas = ['a fazer' => [], 'fazendo' => [], 'concluído' => []];
foreach ($tarefas as $t) {
    if(isset($colunas[$t['status']])) {
        $colunas[$t['status']][] = $t;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Kanban</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="glass-nav">
        <div class="logo"><i class="fas fa-layer-group"></i> TaskSync</div>
        <ul>
            <li><a href="index.php" class="active">Kanban</a></li>
            <li><a href="usuarios.php">Usuários</a></li>
            <li><a href="tarefas.php">Tarefas</a></li>
        </ul>
    </nav>

    <main class="board-container">
        <?php foreach (['a fazer', 'fazendo', 'concluído'] as $status): ?>
            <div class="column glass" ondragover="allowDrop(event)" ondrop="drop(event, '<?= $status ?>')">
                <div class="column-header">
                    <h2><?= ucfirst($status) ?></h2>
                    <span class="badge"><?= count($colunas[$status]) ?></span>
                </div>
                
                <div class="cards-list" id="lista-<?= str_replace(' ', '', $status) ?>">
                    <?php foreach ($colunas[$status] as $tarefa): ?>
                        <div class="card glass-card" draggable="true" ondragstart="drag(event, <?= $tarefa['id'] ?>)" id="task-<?= $tarefa['id'] ?>">
                            <div class="card-badges">
                                <span class="badge prioridade-<?= $tarefa['prioridade'] ?>"><?= ucfirst($tarefa['prioridade']) ?></span>
                                <span class="badge setor"><?= htmlspecialchars($tarefa['setor']) ?></span>
                            </div>
                            <p class="descricao"><?= htmlspecialchars($tarefa['descricao']) ?></p>
                            
                            <div class="card-footer">
                                <div class="user-info">
                                    <i class="fas fa-user-circle"></i> <?= htmlspecialchars($tarefa['usuario_nome']) ?>
                                </div>
                                <div class="actions">
                                    <div class="move-actions" style="display: inline-block; margin-right: 0.5rem;">
                                        <?php if ($status !== 'a fazer'): ?>
                                            <a href="?mover=<?= $tarefa['id'] ?>&novo_status=<?= $status === 'fazendo' ? 'a fazer' : 'fazendo' ?>" title="Mover para esquerda"><i class="fas fa-chevron-left"></i></a>
                                        <?php endif; ?>
                                        <?php if ($status !== 'concluído'): ?>
                                            <a href="?mover=<?= $tarefa['id'] ?>&novo_status=<?= $status === 'a fazer' ? 'fazendo' : 'concluído' ?>" title="Mover para direita"><i class="fas fa-chevron-right"></i></a>
                                        <?php endif; ?>
                                    </div>
                                    <a href="tarefas.php?editar=<?= $tarefa['id'] ?>" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="tarefas.php?excluir=<?= $tarefa['id'] ?>" title="Excluir" data-confirm="Tem certeza que deseja excluir esta tarefa?"><i class="fas fa-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
