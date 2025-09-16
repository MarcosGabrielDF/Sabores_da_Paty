<?php
require '../conexao.php'; 

if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];

    // 1️⃣ Busca o caminho da foto
    $stmt = $pdo->prepare("SELECT foto FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch();

    if ($produto) {
        $foto = $produto['foto'];

        // 2️⃣ Apaga a foto do servidor (se existir)
        if (!empty($foto) && file_exists($foto)) {
            unlink($foto);
        }

        // 3️⃣ Agora deleta do banco
        $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
        if ($stmt->execute([$id])) {
            header("Location: Tela_adm.php");
            exit;
        } else {
            echo "<p>Erro ao excluir o produto.</p>";
        }
    } else {
        echo "<p>Produto não encontrado.</p>";
    }
}
?>
