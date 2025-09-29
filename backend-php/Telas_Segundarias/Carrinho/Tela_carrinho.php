<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Carrinho</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    table{width:100%;border-collapse:collapse;margin:20px 0}
    th,td{border:1px solid #ddd;padding:8px;text-align:center}
    th{background:#f4f4f4}
    .total{margin-top:12px;font-weight:700}
    .btn{display:inline-block;padding:8px 12px;border-radius:6px;text-decoration:none;background:green;color:#fff}
    .remover{background:transparent;border:none;cursor:pointer}
  </style>
</head>
<body>
  <h2>🛒 Seu Carrinho</h2>

  <table id="carrinho">
    <thead>
      <tr>
        <th>Produto</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Subtotal</th>
        <th></th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <div class="total" id="total">Total: R$ 0,00</div>
  <button id="whatsapp-btn" class="btn">Finalizar no WhatsApp</button>

  <script>
    const tbody = document.querySelector("#carrinho tbody");
    const totalDiv = document.getElementById("total");
    const whatsappBtn = document.getElementById("whatsapp-btn");

    function formatCurrency(value) {
      return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    function renderCart() {
      const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
      tbody.innerHTML = '';
      let total = 0;

      carrinho.forEach(item => {
        const preco = Number(item.preco) || 0;
        const quantidade = Number(item.quantidade) || 0;
        const subtotal = preco * quantidade;
        total += subtotal;

        tbody.insertAdjacentHTML('beforeend', `
          <tr data-id="${item.id}">
            <td>${item.nome}</td>
            <td>${formatCurrency(preco)}</td>
            <td><input class="qtd" type="number" min="1" value="${quantidade}" style="width:70px"></td>
            <td class="subtotal">${formatCurrency(subtotal)}</td>
            <td><button class="remover" title="Remover item">❌</button></td>
          </tr>
        `);
      });

      totalDiv.textContent = 'Total: ' + formatCurrency(total);
      localStorage.setItem("carrinho", JSON.stringify(carrinho));
    }

    // Atualiza quantidade quando usuário digita/alterar
    tbody.addEventListener('input', (e) => {
      if (!e.target.classList.contains('qtd')) return;
      const tr = e.target.closest('tr');
      const id = tr.getAttribute('data-id');
      let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
      const item = carrinho.find(i => String(i.id) === String(id));
      if (!item) return;
      let qtd = parseInt(e.target.value, 10) || 1;
      if (qtd < 1) { qtd = 1; e.target.value = 1; }
      item.quantidade = qtd;

      // atualiza subtotal da linha
      const subtotal = Number(item.preco) * Number(item.quantidade);
      tr.querySelector('.subtotal').textContent = formatCurrency(subtotal);

      localStorage.setItem("carrinho", JSON.stringify(carrinho));
      updateTotal();
    });

   // Remover item
    tbody.addEventListener('click', (e) => {
        if (!e.target.classList.contains('remover')) return;
        
        const tr = e.target.closest('tr');
        const nomeItem = tr.querySelector('td').textContent; // pega o nome do produto
        const id = tr.getAttribute('data-id');

        // Confirmação antes de remover
        const confirmar = confirm(`Tem certeza que deseja remover "${nomeItem}" do carrinho?`);
        if (!confirmar) return;

        let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
        carrinho = carrinho.filter(i => String(i.id) !== String(id));
        localStorage.setItem("carrinho", JSON.stringify(carrinho));
        renderCart();
    });
    
    function updateTotal() {
      const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
      const total = carrinho.reduce((s, it) => s + (Number(it.preco) || 0) * (Number(it.quantidade) || 0), 0);
      totalDiv.textContent = 'Total: ' + formatCurrency(total);
    }

    // Finalizar no WhatsApp
    whatsappBtn.addEventListener('click', () => {
      const carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];
      if (carrinho.length === 0) { alert("Carrinho vazio"); return; }

      const linhas = carrinho.map(i =>
        `- ${i.nome}, ${formatCurrency(Number(i.preco))}, ${i.quantidade}x`
      ).join('\n');

      const total = carrinho.reduce((s, it) => s + (Number(it.preco)||0) * (Number(it.quantidade)||0), 0);
      const texto = `Olá, eu gostaria de pedir:\n${linhas}\nTotal: ${formatCurrency(total)}`;

      const numero = "55DDDNUMERO"; // troque pelo seu número: ex 5511999999999
      const url = `https://wa.me/${numero}?text=${encodeURIComponent(texto)}`;
      window.open(url, "_blank");
    });

    // renderiza ao carregar
    renderCart();
  </script>
</body>
</html>
