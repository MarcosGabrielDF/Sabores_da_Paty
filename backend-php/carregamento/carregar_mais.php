<?php
require 'conexao.php';

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limit = 12;

$stmt = $pdo->prepare('SELECT id, nome, preco, foto FROM produtos ORDER BY criado_em DESC LIMIT ?, ?');
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->bindValue(2, $limit, PDO::PARAM_INT);
$stmt->execute();
$produtos = $stmt->fetchAll();

echo json_encode($produtos);
