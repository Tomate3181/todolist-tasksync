<?php
require 'config.php';

// Atualiza o status via requisição Ajax (Drag & Drop)
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['status'])) {
    $id = $data['id'];
    $status = $data['status'];
    
    // Status validos
    if (in_array($status, ['a fazer', 'fazendo', 'concluído'])) {
        $stmt = $pdo->prepare("UPDATE tarefas SET status = ? WHERE id = ?");
        
        if ($stmt->execute([$status, $id])) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["sucesso" => false, "msg" => "Erro ao atualizar"]);
        }
    } else {
        echo json_encode(["sucesso" => false, "msg" => "Status inválido"]);
    }
} else {
    echo json_encode(["sucesso" => false, "msg" => "Dados incompletos"]);
}
?>
