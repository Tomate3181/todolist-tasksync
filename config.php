<?php
// config.php - Configuração de conexão com o banco de dados
$host = 'localhost';
$dbname = 'tasksync';
$user = 'root';
$pass = ''; // Por padrão no XAMPP, a senha é vazia

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
