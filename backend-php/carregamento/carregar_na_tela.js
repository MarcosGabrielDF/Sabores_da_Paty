let offset = 12; // já carregamos os primeiros 12 produtos
let carregando = false; // evita múltiplas requisições ao mesmo tempo
let acabou = false;     // indica que não há mais produtos

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

                    data.forEach(produto => {
                        container.insertAdjacentHTML("beforeend", `
                            <div class="produto-card" data-id="${produto.id}">
                                <img src="../adm/${produto.foto}" loading="lazy" alt="${produto.nome}">
                                <h2>${produto.nome}</h2>
                                <strong>R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}</strong>
                            </div>
                        `);
                    });

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
