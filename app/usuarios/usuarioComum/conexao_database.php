<?php
$host = '127.0.0.1';
$dbname = 'qualplaca';
$username = 'root';
$password = '';

// Estabelecer a conexão
$conn = mysqli_connect($host, $username, $password, $dbname);

// Verificar a conexão
if (!$conn) {
    die('Erro na conexão com o banco de dados: ' . mysqli_connect_error());
}
?>
