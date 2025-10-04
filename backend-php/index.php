<?php
  require 'conexao.php';
  require 'carregamento/produtos_iniciais.php'; // isso já define $produtos
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sabores da Paty</title>

  <!-- CSS principal -->
  <link rel="stylesheet" href="css/EstiloIndex.css">

  <!-- Ícone do carrinho -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>

  <!-- Banner com efeito Parallax -->
  <header id="Banner">
    <h1>Sabores da Paty</h1>
  </header>

  <!-- Seção do carrinho -->
  <section id="Carrinho_Compra"> 
    <a href="Telas_Segundarias/Carrinho/Tela_carrinho.php">
      <span class="material-symbols-outlined">shopping_cart</span>
    </a>
  </section>

  <!-- Link para o painel ADM -->
  <a href="adm/Tela_adm.php" style="display:block; text-align:center; margin:15px 0; color: var(--cor2); font-weight:bold;">
    ADM
  </a>

  <!-- Conteúdo principal -->
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

  <!-- Script para redirecionar ao clicar no produto -->
  <script src="carregamento/carregar_na_tela.js"></script>
  <script>
    document.querySelectorAll('.produto-card').forEach(card => {
      card.addEventListener('click', () => {
        const id = card.getAttribute('data-id');
        window.location.href = "Telas_Segundarias/visualizacao/Tela_visualizacao.php?id=" + id;
      });
    });
  </script>

</body>
</html>
