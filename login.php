<?php
require 'config.php';

if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && (password_verify($senha, $usuario['senha']) || $senha === $usuario['senha'])) {
        // Se a senha estiver em plain text, atualiza para hash
        if ($senha === $usuario['senha']) {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?")->execute([$hash, $usuario['id']]);
        }
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];
        header("Location: index.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskSync</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { display: flex; flex-direction: column; min-height: 100vh; background: linear-gradient(135deg, #020617, #0f172a, #1e1b4b); }
        .login-wrapper { display: flex; flex: 1; justify-content: center; align-items: center; padding: 2rem; }
        .login-box { width: 100%; max-width: 400px; padding: 2rem; }
    </style>
</head>
<body>
    <nav class="glass-nav">
        <div class="logo"><i class="fas fa-layer-group"></i> TaskSync</div>
        <ul>
            <li><a href="index.php">Kanban</a></li>
            <li><a href="login.php" class="active" style="color: #10b981;"><i class="fas fa-sign-in-alt"></i> Entrar</a></li>
        </ul>
    </nav>
    <div class="login-wrapper">
        <div class="login-box glass">
            <div style="text-align: center; margin-bottom: 2rem;">
                <div class="logo" style="font-size: 2rem; font-weight: bold; color: #3b82f6;"><i class="fas fa-layer-group"></i> TaskSync</div>
                <p style="color: #94a3b8; margin-top: 0.5rem;">Faça login para continuar</p>
            </div>
        
        <?php if($erro): ?>
            <div style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; padding: 1rem; border-radius: 6px; margin-bottom: 1rem; border: 1px solid rgba(239, 68, 68, 0.3);">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" required placeholder="admin@tasksync.com">
            </div>
            <div class="form-group">
                <label>Senha</label>
                <input type="password" name="senha" required placeholder="123456">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Entrar</button>
        </form>
        
        <div style="margin-top: 2rem; text-align: center; font-size: 0.85rem; color: #94a3b8;">
            <p><strong>Dica p/ testes:</strong></p>
            <p>Admin: admin@tasksync.com | 123456</p>
            <p>Comum: joao@tasksync.com | 123456</p>
        </div>
    </div>
    </div>
</body>
</html>
