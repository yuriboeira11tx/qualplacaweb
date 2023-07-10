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
?>

<!DOCTYPE html>
<html>

<head>
    <title>PlacasBuscadas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 120px;
        }

        .placas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            justify-items: center;
        }

        .placa-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            width: 250px;
            height: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .placa-image {
            width: 100%;
            height: 150px;
            overflow: hidden;
        }

        .placa-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placa-info {
            flex: 1;
            padding: 20px;
            text-align: center;
        }

        .placa-info h3 {
            margin-bottom: 10px;
        }

        .placa-info .campo {
            margin-bottom: 5px;
        }

        .placa-info .campo label {
            font-weight: bold;
        }

        .placa-info .campo-utilidade {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-ver-detalhes {
            font-size: 14px;
            padding: 5px 10px;
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
                    <a class="nav-link" href="placas_avaliadas.php">Avaliadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favoritos.php">Favoritadas</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Essas são as placas disponíveis conforme o filtro solicitado:</h2>
        <div class="placas-grid">
            <?php
            $sql = unserialize($_GET['sql']);
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $codigo_placa = $row['Id'];
                    $nome = $row['nome'];
                    $imagem = $row['imagem'];

                    echo '<div class="placa-card">';
                    echo '<div class="placa-image">';
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" class="card-img-top img-fluid image-fit" alt="Imagem da Placa">';
                    echo '</div>';
                    echo '<div class="placa-info">';
                    echo '<h3 class="card-title">' . $nome . '</h3>';
                    echo '<div class="campo">';
                    echo '<a href="placa.php?codigo_placa=' . $codigo_placa . '" class="btn btn-primary btn-ver-detalhes">Ver Detalhes</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'Nenhuma placa encontrada';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        const ratingInputs = document.querySelectorAll('.rating input[type="radio"]');
        ratingInputs.forEach((input) => {
            input.addEventListener('change', updateRating);
        });

        function updateRating() {
            const selectedRating = this.value;
            console.log(`Avaliação: ${selectedRating}`);
        }
    </script>
</body>

</html>