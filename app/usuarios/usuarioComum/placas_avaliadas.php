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
            INNER JOIN avaliacao a ON p.id = a.placa_id
            INNER JOIN marca m ON p.marca_id = m.id
            INNER JOIN fabricante f ON p.fabricante_id = f.id
            WHERE a.usuario_id = '$usuarioId'";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Placas Avaliadas</title>
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
            margin-bottom: 20px;
            width: 500px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-img {
            justify-content: center;
            height: 200px;
            object-fit: cover;
            width: 300px; 
            margin-left: 20%;
            margin-top: 30px;
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

        .remove-button {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .comentarios-list{
            font-size: 15px;
            list-style-type: none;
            padding-left: 0;
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
                    <a class="nav-link" href="favoritos.php">Favoritadas</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="centered-title">
        <h1>Placas Avaliadas</h1>
    </div>
    <div class="container">
        <?php
        function getRatingStars($rating) {
            $stars = '';
        
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    $stars .= '<label for="star' . $i . '">&#9733;</label>';
                } else {
                    $stars .= '<label for="star' . $i . '">&#9734;</label>';
                }
            }
        
            return $stars;
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $nome = $row['nome'];
                $marca_nome = $row['marca_nome'];
                $fabricante_nome = $row['fabricante_nome'];
                $imagem = $row['imagem'];
                $placa_id = $row['Id'];

                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" class="card-img img-fluid image-fit" alt="Imagem da Placa">';
                echo '<div class="card-body justify-content-end">'; // Adicione a classe justify-content-end aqui
                echo '<h5 class="card-title">' . $nome . '</h5>';
                echo '<p class="card-text"><strong>Marca:</strong> ' . $marca_nome . '</p>';
                echo '<p class="card-text"><strong>Fabricante:</strong> ' . $fabricante_nome . '</p>';


                // Exibir os comentários
                $sql = "SELECT a.comentario, a.valor, a.data, u.nome AS nome_usuario
                            FROM avaliacao a
                            INNER JOIN usuario u ON a.usuario_id = u.id
                            WHERE a.placa_id = $placa_id";
                $avaliacoes = $conn->query($sql);

                if ($avaliacoes->num_rows > 0) {
                    echo '<ul class="comentarios-list">';
                    while ($avaliacaoRow = $avaliacoes->fetch_assoc()) {
                        $data = $avaliacaoRow['data'];
                        $horario = date('d/m/Y H:i', strtotime($data));
                        $comentario = $avaliacaoRow['comentario'];
                        $estrelas = $avaliacaoRow['valor'];
                        echo '<li>' . $horario . "&nbsp;&nbsp;&nbsp;&nbsp;" . getRatingStars($estrelas) . "&nbsp;&nbsp;&nbsp;&nbsp;" . $comentario;
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="placa_id" value="' . $placa_id . '">';
                        echo '<button type="submit" name="btnRemover" class="remove-button btn btn-danger">Remover Avaliação</button>';
                        echo '</form>';
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '<p class="card-text">Nenhum comentário</p>';
                }
                    }
                } else {
                    echo "<br>Nenhuma placa avaliada encontrada<br>";
                }
        ?>
    </div>

    <?php
    if (isset($_POST['btnRemover'])) {
        $placaId = $_POST['placa_id'];
        $sqlRemover = "DELETE FROM favorito WHERE usuario_id = $usuarioId AND placa_id = $placaId";
        $resultRemover = $conn->query($sqlRemover);

        if ($resultRemover) {
            echo "<script>alert('Avaliação removida com sucesso!');</script>";
            echo "<script>window.location.href = 'placas_avaliadas.php';</script>";
        } else {
            echo "<script>alert('Erro ao remover avaliação: " . $conn->error . "');</script>";
        }
    }
    ?>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>