<?php
require_once '../conexao.php';

header('Content-Type: application/json');

$response = ['status' => '', 'mensagem' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $arquivo = $_FILES['foto'];
        $nomeArquivo = basename($arquivo['name']);
        $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
        $permitidas = ['jpg','jpeg','png','gif'];

        if(!in_array($extensao, $permitidas)) {
            $response['status'] = 'erro';
            $response['mensagem'] = 'Extensão de arquivo não permitida!';
            echo json_encode($response);
            exit;
        }

        $pastaUploads = 'uploads/';
        if(!is_dir($pastaUploads)) mkdir($pastaUploads, 0777, true);
        $caminhoFinal = $pastaUploads . time() . '_' . $nomeArquivo;

        if(move_uploaded_file($arquivo['tmp_name'], $caminhoFinal)) {
            $sql = "INSERT INTO produtos (foto, nome, preco, descricao) VALUES (:foto, :nome, :preco, :descricao)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':foto' => $caminhoFinal,
                ':nome' => $nome,
                ':preco' => $preco,
                ':descricao' => $descricao
            ]);

            $response['status'] = 'sucesso';
            $response['mensagem'] = 'Produto adicionado com sucesso!';
        } else {
            $response['status'] = 'erro';
            $response['mensagem'] = 'Erro ao fazer upload da foto.';
        }

    } else {
        $response['status'] = 'alerta';
        $response['mensagem'] = 'Nenhuma foto foi enviada.';
    }

} else {
    $response['status'] = 'erro';
    $response['mensagem'] = 'Método inválido.';
}

echo json_encode($response);
?>
