<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? '';  // "Entrada" ou "Saída"
    $produtoId = $_POST['produto'] ?? '';
    $quantidade = (int)($_POST['quantidade'] ?? 0);
    $data = $_POST['data'] ?? '';
    $motivo = trim($_POST['motivo'] ?? '');

    if (!$tipo || !$produtoId || $quantidade <= 0 || !$data) {
        die("Todos os campos são obrigatórios e quantidade deve ser maior que zero.");
    }

    $arquivoProdutos = 'produtos.json';
    $arquivoMovimentacoes = 'movimentacoes.json';

    if (!file_exists($arquivoProdutos)) {
        die("Nenhum produto cadastrado.");
    }

    $produtos = json_decode(file_get_contents($arquivoProdutos), true);
    $produtoIndex = null;

    foreach ($produtos as $index => $p) {
        if ($p['id'] === $produtoId) {
            $produtoIndex = $index;
            break;
        }
    }

    if ($produtoIndex === null) {
        die("Produto não encontrado.");
    }

    if ($tipo === 'Saída' && $produtos[$produtoIndex]['quantidade'] < $quantidade) {
        die("Estoque insuficiente para saída.");
    }

    // Atualiza estoque
    if ($tipo === 'Entrada') {
        $produtos[$produtoIndex]['quantidade'] += $quantidade;
    } else {
        $produtos[$produtoIndex]['quantidade'] -= $quantidade;
    }

    // Salva produtos atualizados
    file_put_contents($arquivoProdutos, json_encode($produtos, JSON_PRETTY_PRINT));

    // Registra movimentação
    $movimentacoes = [];
    if (file_exists($arquivoMovimentacoes)) {
        $movimentacoes = json_decode(file_get_contents($arquivoMovimentacoes), true) ?: [];
    }

    $novaMovimentacao = [
        'id' => uniqid(),
        'tipo' => $tipo,
        'produtoId' => $produtoId,
        'quantidade' => $quantidade,
        'data' => $data,
        'motivo' => $motivo
    ];

    $movimentacoes[] = $novaMovimentacao;

    file_put_contents($arquivoMovimentacoes, json_encode($movimentacoes, JSON_PRETTY_PRINT));

    header("Location: pages/movimentacao.html?msg=Movimentação registrada com sucesso.");
    exit;
} else {
    echo "Acesso inválido.";
}
