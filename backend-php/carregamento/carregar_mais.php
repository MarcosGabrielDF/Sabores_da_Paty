<?php
require '../conexao.php';
header('Content-Type: application/json; charset=utf-8');

$offset = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;
$limit  = 12;

$sql = "SELECT id, foto, nome, preco
        FROM produtos 
        ORDER BY criado_em DESC 
        LIMIT $offset, $limit";

// Use um prepared statement para maior segurança
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($produtos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>