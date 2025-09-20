let offset = 12;
let carregando = false;
let acabou = false;

// pega só o nome do arquivo atual
let PaginaAtual = window.location.pathname.split("/").pop();

window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
        if (!carregando && !acabou) {
            carregando = true;

            fetch(`../carregamento/carregar_mais.php?offset=${offset}`)
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    const container = document.querySelector('.produtos-container');
                    if (!container) return;

                    if (!Array.isArray(data) || data.length === 0) {
                        acabou = true;
                        carregando = false;
                        return;
                    }

                    if (PaginaAtual === "index.php") {
                        // tela do cliente
                        data.forEach(produto => {
                            container.insertAdjacentHTML("beforeend", `
                                <div class="produto-card" data-id="${produto.id}">
                                    <img src="../adm/${produto.foto}" loading="lazy" alt="${produto.nome}">
                                    <h2>${produto.nome}</h2>
                                    <strong>R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}</strong>
                                </div>
                            `);
                        });
                     container.querySelectorAll('.produto-card').forEach(card => {
        card.addEventListener('click', () => {
            const id = card.getAttribute('data-id');
            window.location.href = `../Telas_Segundarias/visualizacao/Tela_visualizacao.php/produto.php?id=${id}`;
        });
    });
                    } else if (PaginaAtual === "Tela_adm.php") {
                        // tela de administração
                        data.forEach(produto => {
                            container.insertAdjacentHTML("beforeend", `
                                <div class="produto-card" data-id="${produto.id}">
                                    <img src="../adm/${produto.foto}" loading="lazy" alt="${produto.nome}">
                                    <h2>${produto.nome}</h2>
                                    <strong>R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}</strong> 
                                    <div class="delete">
                                        <form method="POST" action="delete.php" onsubmit="return confirm('Deseja realmente excluir este produto?');">
                                            <input type="hidden" name="delete_id" value="${produto.id}">
                                            <button type="submit" name="delete">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            `);
                        });
                    }

                    offset += data.length;
                    carregando = false;
                })
                .catch(err => {
                    console.error('Erro ao carregar mais produtos:', err);
                    carregando = false;
                });
        }
    }
});
