<?php
require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

session_start();
if (isset($_SESSION['usuario_logado'])) {
    $nomeUsuario = explode(",", $_SESSION['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_SESSION['usuario_logado'])[1];

    if ($tipoUsuario != '1') {
        header('Location: ..usuarioAdm/home.php');
        exit();
    }
} else {
    header("Location: ../deslogado.php");
    exit();
}

$sql = "SELECT u.Id FROM usuario u WHERE u.nome like '$nomeUsuario'";
$result_usuario = $conn->query($sql);

if ($result_usuario->num_rows > 0) {
    $row_usuario = $result_usuario->fetch_assoc();
    $usuarioId = $row_usuario['Id'];
    $sql = "SELECT p.*, m.nome AS marca_nome, f.nome AS fabricante_nome
            FROM placa p
            INNER JOIN marca m ON p.marca_id = m.id
            INNER JOIN fabricante f ON p.fabricante_id = f.id
            INNER JOIN favorito fa ON p.id = fa.placa_id
            WHERE fa.usuario_id = $usuarioId";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Favoritos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top: 50px;
        }

        .card {
            width: 18rem;
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            font-size: 24px;
        }

        .centered-title {
            display: flex;
            justify-content: center;
            padding-top: 140px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#"><img src="../../img/logo.png" class="card-img-top" alt="Imagem de login" style="width: 100px;height: 70px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Buscar Placas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="placas_avaliadas.php">Placas Avaliadas</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="centered-title">
        <h1>Placas Favoritas</h1>
    </div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nome = $row['nome'];
                $marca_nome = $row['marca_nome'];
                $fabricante_nome = $row['fabricante_nome'];
                $imagem = $row['imagem'];
                $placa_id = $row['Id'];

                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" class="card-img-top img-fluid image-fit" alt="Imagem da Placa">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $nome . '</h5>';
                echo '<p class="card-text"><strong>Marca:</strong> ' . $marca_nome . '</p>';
                echo '<p class="card-text"><strong>Fabricante:</strong> ' . $fabricante_nome . '</p>';

                echo '<form method="POST">';
                echo '<input type="hidden" name="placa_id" value="' . $placa_id . '">';
                echo '<button type="submit" name="btnRemover" class="btn btn-danger">Remover dos Favoritos</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<br>Nenhuma placa favorita encontrada<br>';
        }
        ?>
    </div>

    <?php
    if (isset($_POST['btnRemover'])) {
        $placaId = $_POST['placa_id'];
        $sqlRemover = "DELETE FROM favorito WHERE usuario_id = $usuarioId AND placa_id = $placaId";
        $resultRemover = $conn->query($sqlRemover);

        if ($resultRemover) {
            echo "<script>alert('Placa removida dos favoritos com sucesso!');</script>";
            echo "<script>window.location.href = 'favoritos.php';</script>";
        } else {
            echo "<script>alert('Erro ao remover placa dos favoritos: " . $conn->error . "');</script>";
        }
    }
    ?>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>