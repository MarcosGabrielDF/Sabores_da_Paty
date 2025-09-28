<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrinho de Compras</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    th {
      background: #f4f4f4;
    }
  </style>
</head>
<body>

  <h2>🛒 Carrinho</h2>
  <table id="carrinho">
    <thead>
      <tr>
        <th>Produto</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <!-- Linhas de produtos vão aqui -->
    </tbody>
  </table>

  <a id="whatsapp-btn" class="btn" target="_blank" href="#">Finalizar no WhatsApp</a>

  <script src="carrinho.js"></script>
</body>
</html>
