<?php
  require 'carregamento/produtos_iniciais.php'; // isso já define $produtos
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sabores da Paty</title>
  <link rel="stylesheet" href="css/EstiloIndex.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart" />
</head>
<body>

  <header>
    <section id="Carrinho_Compra"> 
      <a href="#">
        <span class="material-symbols-outlined">shopping_cart</span>
      </a>
    </section>
    <div id="Logo">
      <img src="img/bolo.png" alt="Logo: é um bolo cortado, embaixo está escrito Sabores da Paty.">
    </div>
  </header>

  <hr>

  <a href="adm/Tela_adm.html">Menu</a>

  <main>
    <h2>Menu</h2>
      <div class="produtos-container">
          <?php foreach($produtos as $produto): ?>
              <div class="produto-card" data-id="<?= $produto['id'] ?>">
                  <img src="adm/<?= htmlspecialchars($produto['foto']) ?>" loading="lazy" alt="<?= htmlspecialchars($produto['nome']) ?>">
                  <h2><?= htmlspecialchars($produto['nome']) ?></h2>
                  <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>
              </div>
          <?php endforeach; ?>
      </div>

  </main>

<script src="carregamento/carregar_na_tela.js"></script>
</body>
</html>