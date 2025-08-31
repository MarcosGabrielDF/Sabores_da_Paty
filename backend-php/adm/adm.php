<?php
header("Content-Type: application/json; charset=utf-8");
require_once "../conexao.php"; // conexão com PDO

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Método inválido."
        ]);
        exit;
    }

    // Verifica se o arquivo foi enviado
    if (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Erro no upload da imagem."
        ]);
        exit;
    }

    $arquivo = $_FILES["foto"];
    $tamanhoMax = 5 * 1024 * 1024; // 5MB
    $extensoesPermitidas = ['jpg','jpeg','png','gif'];

    // Verifica tamanho do arquivo
    if ($arquivo['size'] > $tamanhoMax) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "A imagem deve ter no máximo 5MB."
        ]);
        exit;
    }

    // Obtém extensão
    $ext = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $extensoesPermitidas)) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Somente arquivos JPG, JPEG, PNG e GIF são permitidos."
        ]);
        exit;
    }

    // Verifica MIME type
    $mime = mime_content_type($arquivo['tmp_name']);
    $tiposMimePermitidos = ['image/jpeg','image/png','image/gif'];
    if (!in_array($mime, $tiposMimePermitidos)) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Tipo de arquivo inválido."
        ]);
        exit;
    }

    // Pasta de uploads
    $diretorio = "uploads/";
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    // Gera nome único e seguro
    $nomeSeguro = preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($arquivo['name'], PATHINFO_FILENAME));
    $nomeArquivo = uniqid() . "-" . $nomeSeguro . "." . $ext;
    $caminhoArquivo = $diretorio . $nomeArquivo;

    if (!move_uploaded_file($arquivo['tmp_name'], $caminhoArquivo)) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Falha ao mover a imagem."
        ]);
        exit;
    }

    // Recebe os outros campos
    $nome = trim($_POST["nome"] ?? "");
    $preco = floatval($_POST["preco"] ?? 0);
    $descricao = trim($_POST["descricao"] ?? "");

    if (empty($nome) || empty($preco) || empty($descricao)) {
        echo json_encode([
            "status" => "alerta",
            "mensagem" => "Todos os campos devem ser preenchidos."
        ]);
        exit;
    }

    // Salva no banco
    $sql = "INSERT INTO produtos (foto, nome, preco, descricao) VALUES (:foto, :nome, :preco, :descricao)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":foto" => $caminhoArquivo,
        ":nome" => $nome,
        ":preco" => $preco,
        ":descricao" => $descricao
    ]);

    echo json_encode([
        "status" => "sucesso",
        "mensagem" => "✅ Produto cadastrado com sucesso!"
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Erro no servidor: " . $e->getMessage()
    ]);
}