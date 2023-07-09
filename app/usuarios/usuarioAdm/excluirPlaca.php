<?php
require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

session_start();
if (isset($_SESSION['usuario_logado'])) {
    $nomeUsuario = explode(",", $_SESSION['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_SESSION['usuario_logado'])[1];
    if ($tipoUsuario != '0') {
        header('Location: ../usuarios/usuarioComum/home.php');
        exit();
    }
} else {
    header("Location: ../deslogado.php");
    exit();
}

if (isset($_GET['id'])) {
    $placaId = $_GET['id'];
    $sql = "DELETE FROM placa WHERE id = $placaId";
    $result = $conn->query($sql);

    if ($result) {
        echo '<script>alert("Placa excluída com sucesso!");</script>';
        echo '<script>window.location.href = "home.php";</script>';
        exit();
    } else {
        echo '<script>alert("Erro ao excluir a placa!");</script>';
        echo '<script>window.location.href = "home.php";</script>';
        exit();
    }
} else {
    echo '<script>alert("ID da placa não fornecido!");</script>';
    echo '<script>window.location.href = "home.php";</script>';
    exit();
}

?>