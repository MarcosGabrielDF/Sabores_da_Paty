CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto VARCHAR(255) NOT NULL,     -- Caminho ou URL da foto
    nome VARCHAR(100) NOT NULL,     -- Nome do produto
    preco DECIMAL(10,2) NOT NULL,   -- Preço com 2 casas decimais
    descricao TEXT NOT NULL,        -- Texto da descrição
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data/hora do cadastro
);
