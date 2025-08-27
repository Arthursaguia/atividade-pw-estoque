<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $dataNascimento = trim($_POST['dataNascimento'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $setor = trim($_POST['setor'] ?? '');

    if (!$nome || !$dataNascimento || !$login || !$senha || !$setor) {
        die("Todos os campos são obrigatórios.");
    }

    // Salvar os usuários num arquivo JSON simples (em produção usar banco de dados)
    $arquivoUsuarios = 'usuarios.json';

    // Ler usuários atuais
    $usuarios = [];
    if (file_exists($arquivoUsuarios)) {
        $json = file_get_contents($arquivoUsuarios);
        $usuarios = json_decode($json, true) ?: [];
    }

    // Verificar se login já existe
    foreach ($usuarios as $u) {
        if ($u['login'] === $login) {
            die("Login já cadastrado. Por favor, escolha outro.");
        }
    }

    // Criar novo usuário (senha criptografada)
    $novoUsuario = [
        'nome' => $nome,
        'dataNascimento' => $dataNascimento,
        'login' => $login,
        'senha' => password_hash($senha, PASSWORD_DEFAULT),
        'setor' => $setor
    ];

    $usuarios[] = $novoUsuario;

    // Salvar arquivo JSON atualizado
    file_put_contents($arquivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT));

    // Redirecionar para login com sucesso
    header("Location: index.html?msg=Cadastro realizado com sucesso. Faça login.");
    exit;
} else {
    echo "Acesso inválido.";
}
