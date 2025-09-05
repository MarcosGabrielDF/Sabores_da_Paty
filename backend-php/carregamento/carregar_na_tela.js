let offset = 12; // já carregamos os primeiros 12 produtos
let carregando = false; // evita múltiplas requisições ao mesmo tempo

window.addEventListener('scroll', () => {
    // verifica se o usuário chegou perto do final da página
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 200) {
        if (!carregando) {
            carregando = true;
            
            fetch(`carregar_mais.php?offset=${offset}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) return; // não tem mais produtos

                    const container = document.querySelector('.produtos-container');

                    data.forEach(produto => {
                        container.innerHTML += `
                            <div class="produto-card" data-id="${produto.id}">
                                <img src="uploads/${produto.foto}" loading="lazy" alt="${produto.nome}">
                                <h2>${produto.nome}</h2>
                                <strong>R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}</strong>
                            </div>
                        `;
                    });

                    offset += data.length; // atualiza o offset
                    carregando = false;
                })
                .catch(err => {
                    console.error('Erro ao carregar mais produtos:', err);
                    carregando = false;
                });
        }
    }
});
