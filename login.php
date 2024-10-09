<?php
// Iniciar a sessão
session_start();

// Incluir a conexão com o banco de dados
include('connect.php');

$error_message = '';

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verificar se os campos não estão vazios
    if (!empty($usuario) && !empty($senha)) {
        // Query para verificar o login na tabela `acessos`
        $sql = "SELECT * FROM acessos WHERE usuario = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se o login foi bem-sucedido
        if ($result->num_rows > 0) {
            // Login bem-sucedido, salvar na sessão
            $_SESSION['usuario_logado'] = $usuario;
            
            // Redirecionar para a página principal (index.php)
            header('Location: dashboard.php');
            exit();
        } else {
            // Definir a mensagem de erro
            $error_message = "Usuário ou senha incorretos!";
        }
    } else {
        $error_message = "Por favor, preencha ambos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBERAV - login</title>
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>

<div class="login-container">
    <img src="./img/logo.png" alt="Logo JB Transporte e Logística" class="logo_login">
    
    <!-- Alerta de erro -->
    <?php if (!empty($error_message)): ?>
        <div class="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <input type="text" name="usuario" placeholder="USUÁRIO" class="input-field" required>
        <input type="password" name="senha" placeholder="SENHA" class="input-field" required>
        <button type="submit" class="login-btn">ENTRAR</button>
        <a href="#" class="forgot-password">Esqueceu sua senha?</a>
    </form>
</div>

</body>
</html>
