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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
</head>
<body>
    <!-- Header fixo -->
    <header>
        <a href="../../../index.php" class="voltar">⟵</a>
        <div class="logo"><img src="../../../img/BoloPng1.png" alt="Logo, é um bolo e está escrito Sabores da Paty"></div> 
        <a href="/Telas_Segundarias/Carrinho/Tela_carrinho.php">
            <span class="material-symbols-outlined">shopping_cart</span>
        </a>
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
                    <button class="btn-carrinho" data-id="<?= $produto['id'] ?>" data-nome="<?= $produto['nome'] ?>" data-preco="<?= $produto['preco'] ?>">Adicionar ao Carrinho</button>
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
<script src="/Telas_Segundarias/Carrinho/carrinho.js"></script>
</body>
</html>
