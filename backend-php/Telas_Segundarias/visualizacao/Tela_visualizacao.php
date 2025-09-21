<?php
include '../../conexao.php';
require 'Pegar_dados.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descrição do Produto</title>
    <link rel="stylesheet" href="/Telas_Segundarias/visualizacao/css/Estilo_visualizacao.css">
    <!-- Fonte -->
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header fixo -->
    <header>
        <a href="../../../index.php" class="voltar">⟵</a>
        <div class="logo"><img src="../../../img/bolo.png" alt="Logo, é um bolo e está escrito Sabores da Paty"></div>
        <a href="../Carrinho/carrinho.php" class="carrinho">🛒</a>
    </header>

    <!-- Corpo -->
    <main class="container">
        <div class="card">
            <!-- Coluna esquerda -->
            <div class="col-esquerda">
                <img src="../../../adm/<?= $produto['foto'] ?>" alt="<?= $produto['nome'] ?>" class="produto-img">

                <!-- Área de compra -->
                <div class="compra">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" value="1" min="1">
                    <button class="btn-carrinho">Adicionar ao Carrinho</button>
                </div>
            </div>

            <!-- Coluna direita -->
            <div class="col-direita">
                <h1><?= $produto['nome'] ?></h1>
                <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <p class="descricao"><?= nl2br($produto['descricao']) ?></p>
                <p class="data">Cadastrado em: <?= date("d/m/Y H:i", strtotime($produto['criado_em'])) ?></p>
            </div>
        </div>
    </main>
</body>
</html>
