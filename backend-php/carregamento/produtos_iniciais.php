<?php
require 'conexao.php';

// Busca os primeiros 12 produtos
$stmt = $pdo->query('SELECT id, nome, preco, foto FROM produtos ORDER BY criado_em DESC LIMIT 12');
$produtos = $stmt->fetchAll();
