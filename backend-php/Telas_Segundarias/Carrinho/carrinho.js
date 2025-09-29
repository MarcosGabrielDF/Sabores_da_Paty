document.addEventListener("DOMContentLoaded", () => {
  const btn = document.querySelector(".btn-carrinho");
  if (!btn) return;

  btn.addEventListener("click", () => {
    const id = btn.getAttribute("data-id");
    const nome = btn.getAttribute("data-nome");
    let precoStr = btn.getAttribute("data-preco") || "0";
    precoStr = precoStr.replace(",", "."); // aceita "45,00" também
    const preco = parseFloat(precoStr) || 0;
    let quantidade = parseInt(document.getElementById("quantidade").value, 10) || 1;
    if (quantidade < 1) quantidade = 1;

    let carrinho = JSON.parse(localStorage.getItem("carrinho")) || [];

    const idx = carrinho.findIndex(p => String(p.id) === String(id));
    if (idx > -1) {
      carrinho[idx].quantidade = Number(carrinho[idx].quantidade) + quantidade;
    } else {
      carrinho.push({ id, nome, preco, quantidade });
    }

    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    alert("✅ Produto adicionado ao carrinho!");
  });
});
