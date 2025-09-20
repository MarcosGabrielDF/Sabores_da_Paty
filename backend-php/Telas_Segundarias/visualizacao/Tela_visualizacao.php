<?php
include '../../conexao.php';
require 'Pegar_dados.php'
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $produto['nome'] ?></title>
</head>
<body>
    <h1><?= $produto['nome'] ?></h1>
    <img src="<?= $produto['foto'] ?>" alt="<?= $produto['nome'] ?>" width="300"><br><br>
    <strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?><br><br>
    <p><?= nl2br($produto['descricao']) ?></p>
    <small>Cadastrado em: <?= date("d/m/Y H:i", strtotime($produto['criado_em'])) ?></small><br><br>
    <a href="../../../index.php">Voltar</a>
</body>
</html>
