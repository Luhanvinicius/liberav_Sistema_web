<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado'])) {
    // Se o usuário não estiver logado, redirecionar para a página de login
    header('Location: login.php');
    exit();
}

// Configurações de conexão ao banco de dados
$host = "localhost";   
$username = "root";    
$password = "";        
$database = "liberav"; 

// Criar conexão
$conn = new mysqli($host, $username, $password, $database);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // O ID do registro que deseja atualizar
    $status = $_POST['status']; // O valor do status selecionado pelo usuário
    
    // Atualiza o status no banco de dados
    $sql = "UPDATE api_placas SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo "Status atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o status: " . $conn->error;
    }
    
    $stmt->close();
}

// Seleciona os registros para exibição
$sql = "SELECT id, arquivo, camera, confianca, `data-hora`, placa, regiao, status FROM api_placas";
$result = $conn->query($sql);

// Verifica se há registros
if ($result->num_rows > 0) {
    echo "<form method='POST' action=''>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Arquivo</th><th>Câmera</th><th>Placa</th><th>Status Atual</th><th>Atualizar Status</th><th>Ação</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["arquivo"] . "</td>";
        echo "<td>" . $row["camera"] . "</td>";
        echo "<td>" . $row["placa"] . "</td>";
        echo "<td>" . $row["status"] . "</td>";
        
        // Campo de seleção para alterar o status
        echo "<td>
            <select name='status'>
                <option value='Liberar'" . ($row["status"] == 'Liberar' ? ' selected' : '') . ">Liberar</option>
                <option value='Bloquear'" . ($row["status"] == 'Bloquear' ? ' selected' : '') . ">Bloquear</option>
            </select>
        </td>";
        
        // Botão de ação para atualizar o status
        echo "<td>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <input type='submit' value='Atualizar'>
        </td>";
        echo "</tr>";
    }
    
    echo "</table>";
    echo "</form>";
} else {
    echo "Nenhum dado encontrado.";
}

// Fechar a conexão
$conn->close();
?>
