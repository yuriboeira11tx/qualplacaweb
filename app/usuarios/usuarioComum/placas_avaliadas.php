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

$usuarioId = explode(",", $_SESSION['usuario_logado'])[1];
$sql = "SELECT p.*, a.valor, a.comentario, m.nome AS marca_nome, f.nome AS fabricante_nome
        FROM placa p
        INNER JOIN avaliacao a ON p.id = a.placa_id
        INNER JOIN marca m ON p.marca_id = m.id
        INNER JOIN fabricante f ON p.fabricante_id = f.id
        WHERE a.usuario_id = $usuarioId";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Placas Avaliadas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top: 120px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
        }

        .rating>span {
            display: inline-block;
            position: relative;
            width: 1.1em;
            font-size: 1.5em;
            color: #FFD700;
        }

        .rating>span:before {
            content: "\2605";
            position: absolute;
        }

        .rating>span:not(:last-child) {
            margin-right: 0.2em;
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

    <div class="container">
        <h1>Placas Avaliadas</h1>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $placaId = $row['Id'];
                $nome = $row['nome'];
                $marcaNome = $row['marca_nome'];
                $fabricanteNome = $row['fabricante_nome'];
                $valor = $row['valor'];
                $comentario = $row['comentario'];
                $imagem = $row['imagem'];
                $vram = $row['vram'];
                $clock = $row['clock'];
                $consumo = $row['consumo'];
                $preco = $row['preco'];

                $utilidades = [];
                $utilidadesQuery = "SELECT u.nome FROM utilidade u INNER JOIN placa_utilidade pu ON u.id = pu.utilidade_id WHERE pu.placa_id = $placaId";
                $utilidadesResult = $conn->query($utilidadesQuery);
                if ($utilidadesResult->num_rows > 0) {
                    while ($utilidadeRow = $utilidadesResult->fetch_assoc()) {
                        $utilidades[] = $utilidadeRow['nome'];
                    }
                }

                echo '<div class="card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" class="card-img-top img-fluid image-fit" alt="Imagem da Placa">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $nome . '</h5>';
                echo '<p class="card-text"><strong>Marca:</strong> ' . $marcaNome . '</p>';
                echo '<p class="card-text"><strong>Utilidades:</strong> ' . implode(", ", $utilidades) . '</p>';
                echo '<p class="card-text"><strong>VRAM:</strong> ' . $vram . '</p>';
                echo '<p class="card-text"><strong>Clock:</strong> ' . $clock . '</p>';
                echo '<p class="card-text"><strong>Fabricante:</strong> ' . $fabricanteNome . '</p>';
                echo '<p class="card-text"><strong>Comentário:</strong> ' . $comentario . '</p>';
                echo '<p class="card-text text-success"><strong>Preço: R$</strong> ' . $preco . '</p>';

                echo '<div class="rating">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= round($valor)) {
                        echo '<span>&#9733;</span>'; // Estrela preenchida
                    }
                }
                echo '</div>';

                echo '<form method="POST">';
                echo '<input type="hidden" name="placa_id" value="' . $placaId . '">';
                echo '<button type="submit" name="btnRemover" class="btn btn-danger">Remover Avaliação</button>';
                echo '</form>';

                echo '</div>';
                echo '</div>';
            }
        } else {
            echo 'Nenhuma placa avaliada encontrada.';
        }
        ?>

    </div>

    <?php
    if (isset($_POST['btnRemover'])) {
        $placaId = $_POST['placa_id'];

        $stmt = $conn->prepare("DELETE FROM avaliacao WHERE usuario_id = ? AND placa_id = ?");
        $stmt->bind_param("ii", $usuarioId, $placaId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Avaliação removida com sucesso!');</script>";
            echo "<script>window.location.href = 'placas_avaliadas.php';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao remover a avaliação.');</script>";
        }

        $stmt->close();
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>