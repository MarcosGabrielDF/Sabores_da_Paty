<?php
  require '../conexao.php';
  require '../carregamento/produtos_iniciais.php'; // isso já define $produtos
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração Sabores da Paty</title>
    <link rel="stylesheet" href="css/EstiloAdm.css">
    <style>
        /* ===== MENSAGENS ===== */
        .message {
            padding: 12px 16px;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            transition: opacity 0.3s ease;
        }

        .mensagem-sucesso {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            box-shadow: 0px 2px 6px rgba(0, 128, 0, 0.1);
        }

        .mensagem-erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            box-shadow: 0px 2px 6px rgba(255, 0, 0, 0.1);
        }

        .mensagem-alerta {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            box-shadow: 0px 2px 6px rgba(255, 193, 7, 0.1);
        }
    </style>
</head>
<body>
    <a href="../index.php">Voltar</a>
    <header>
        <h1>Sabores da Paty</h1>
    </header>
    <main>
        <h2>Meus Produtos</h2>
        <div class="produtos-container">
            <?php foreach($produtos as $produto): ?>
                <div class="produto-card" data-id="<?= $produto['id'] ?>">
                    <img src="../adm/<?= htmlspecialchars($produto['foto']) ?>" loading="lazy" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <h2><?= htmlspecialchars($produto['nome']) ?></h2>
                    <strong>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></strong>

                    <div class="delete">
                        <form method="POST" action="delete.php">
                            <input type="hidden" name="delete_id" value="<?= $produto['id'] ?>">
                            <button type="submit" name="delete" onclick="return confirm('Deseja realmente excluir este produto?');">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>
    
    <!-- Botão "+" -->
    <button class="btn-add">+</button>

    <!-- Modal -->
    <div class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Adicionar Produto</h2>
            <form id="formProduto" action="adm.php" method="POST" enctype="multipart/form-data">
                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>

                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>

                <button type="submit" class="btn-salvar">Salvar</button>
            </form>
            <div id="mensagem" style="margin-top:10px;"></div> <!-- Mensagens AJAX -->
        </div>
    </div>



<script src="../carregamento/carregar_na_tela.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const btnAdd = document.querySelector(".btn-add");
    const modal = document.querySelector(".modal");
    const closeBtn = modal.querySelector(".close");
    const form = document.getElementById("formProduto");
    const mensagem = document.getElementById("mensagem");

    // Abrir modal
    btnAdd.addEventListener("click", () => {
        modal.style.display = "block";
        mensagem.style.display = "none";
        form.reset();
    });

    // Fechar modal
    closeBtn.addEventListener("click", () => modal.style.display = "none");

    window.addEventListener("click", (event) => {
        if (event.target === modal) modal.style.display = "none";
    });

    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") modal.style.display = "none";
    });

    // Função para mostrar mensagem com efeito de desaparecimento
    function exibirMensagem(tipo, texto) {
        mensagem.style.display = "block";
        mensagem.className = "message"; // reset
        mensagem.classList.add(tipo);    // adiciona o tipo (sucesso, erro, alerta)
        mensagem.textContent = texto;

        // Desaparecer após 5 segundos
        setTimeout(() => {
            mensagem.style.opacity = "0";
            setTimeout(() => { mensagem.style.display = "none"; mensagem.style.opacity = "1"; }, 300);
        }, 5000);
    }

    // AJAX
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === "sucesso") {
                exibirMensagem("mensagem-sucesso", data.mensagem);
                form.reset();
            } else if(data.status === "erro") {
                exibirMensagem("mensagem-erro", data.mensagem);
            } else if(data.status === "alerta") {
                exibirMensagem("mensagem-alerta", data.mensagem);
            }
        })
        .catch(error => {
            exibirMensagem("mensagem-erro", "❌ Erro ao enviar formulário.");
            console.error("Erro AJAX:", error);
        });
    });
});
</script>
</body>
</html>
