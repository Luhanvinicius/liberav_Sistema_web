<?php
// Iniciar a sessão
session_start();

// Incluir o arquivo de conexão com o banco de dados
include('connect.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    // Se não estiver logado, redirecionar para a página de login
    header('Location: dashboard.php');
    exit();
}

// Caso esteja logado, exibir a página principal
echo "Bem-vindo, " . $_SESSION['usuario_logado'] . "!";

// Aqui você pode colocar o conteúdo da página que só pode ser acessado por usuários logados
?>
