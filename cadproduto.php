<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');

    if (!$nome || !$categoria) {
        die("Nome e categoria são obrigatórios.");
    }

    $arquivoProdutos = 'produtos.json';

    $produtos = [];
    if (file_exists($arquivoProdutos)) {
        $produtos = json_decode(file_get_contents($arquivoProdutos), true) ?: [];
    }

    // Verifica se produto já existe (pelo nome)
    foreach ($produtos as $p) {
        if (strcasecmp($p['nome'], $nome) === 0) {
            die("Produto já cadastrado.");
        }
    }

    $novoProduto = [
        'id' => uniqid(),
        'nome' => $nome,
        'categoria' => $categoria,
        'descricao' => $descricao,
        'quantidade' => 0
    ];

    $produtos[] = $novoProduto;

    file_put_contents($arquivoProdutos, json_encode($produtos, JSON_PRETTY_PRINT));

    header("Location: pages/cadastro-produto.html?msg=Produto cadastrado com sucesso.");
    exit;
} else {
    echo "Acesso inválido.";
}
