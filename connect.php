<?php
$host = 'localhost';
$db = 'liberav';
$user = 'root';
$password = ''; // Sem senha

// Criar conexão com o banco de dados MySQL
$conn = new mysqli($host, $user, $password, $db);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
