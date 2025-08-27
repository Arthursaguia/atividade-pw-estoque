<?php
$arquivoProdutos = 'produtos.json';

if (!file_exists($arquivoProdutos)) {
    die("Nenhum produto cadastrado.");
}

$produtos = json_decode(file_get_contents($arquivoProdutos), true);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Consulta de Estoque</title>
<link rel="stylesheet" href="../css/style.css" />
<style>
  body {
    background: #1b2443;
    color: #c1c9ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 40px;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: #223153;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(20,30,60,0.7);
  }
  th, td {
    padding: 14px 18px;
    text-align: left;
    border-bottom: 1px solid #2e3a6f;
  }
  th {
    background: #2e3a6f;
  }
  tr:hover {
    background: #2e59ff55;
  }
</style>
</head>
<body>
<h2>Consulta de Estoque</h2>
<table>
<thead>
  <tr>
    <th>Nome</th>
    <th>Categoria</th>
    <th>Descrição</th>
    <th>Quantidade</th>
  </tr>
</thead>
<tbody>
  <?php foreach ($produtos as $p): ?>
  <tr>
    <td><?= htmlspecialchars($p['nome']) ?></td>
    <td><?= htmlspecialchars($p['categoria']) ?></td>
    <td><?= htmlspecialchars($p['descricao']) ?></td>
    <td><?= (int)$p['quantidade'] ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<p><a href="../pages/home.html" style="color:#739aff;">Voltar</a></p>
</body>
</html>
