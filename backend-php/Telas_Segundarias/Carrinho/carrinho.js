// Produtos de exemplo
const produtos = [
    { nome: "Bolo de Chocolate", preco: 30.00, quantidade: 2 },
    { nome: "Brigadeiro", preco: 2.50, quantidade: 10 },
    { nome: "Torta de Morango", preco: 45.00, quantidade: 1 }
];

const tbody = document.querySelector("#carrinho tbody");

// Mostra os produtos na tabela
produtos.forEach(p => {
    let subtotal = p.preco * p.quantidade;

    let row = `
    <tr>
        <td>${p.nome}</td>
        <td>R$ ${p.preco.toFixed(2)}</td>
        <td>${p.quantidade}</td>
        <td>R$ ${subtotal.toFixed(2)}</td>
    </tr>
    `;
    tbody.innerHTML += row;
});
