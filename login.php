<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (!$login || !$senha) {
        die("Login e senha são obrigatórios.");
    }

    $arquivoUsuarios = 'usuarios.json';

    if (!file_exists($arquivoUsuarios)) {
        die("Nenhum usuário cadastrado.");
    }

    $usuarios = json_decode(file_get_contents($arquivoUsuarios), true);

    $usuarioEncontrado = null;
    foreach ($usuarios as $u) {
        if ($u['login'] === $login) {
            $usuarioEncontrado = $u;
            break;
        }
    }

    if (!$usuarioEncontrado) {
        die("Usuário não encontrado.");
    }

    if (!password_verify($senha, $usuarioEncontrado['senha'])) {
        die("Senha incorreta.");
    }

    // Login OK, armazenar sessão
    $_SESSION['usuario'] = [
        'nome' => $usuarioEncontrado['nome'],
        'login' => $usuarioEncontrado['login'],
        'setor' => $usuarioEncontrado['setor']
    ];

    // Redirecionar para home.php (ou home.html)
    header("Location: home.html");
    exit;
} else {
    echo "Acesso inválido.";
}
