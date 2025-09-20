<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // segurança

    // Usar prepared statement para evitar SQL Injection
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        // Produto encontrado
    } else {
        echo "Produto não encontrado!";
        exit;
    }
} else {
    echo "ID do produto não informado!";
    exit;
}
?>
