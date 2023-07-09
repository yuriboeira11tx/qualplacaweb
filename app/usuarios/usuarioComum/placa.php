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

// Verificar se o código da placa foi passado como parâmetro
if (isset($_GET['codigo_placa'])) {
    $codigo_placa = $_GET['codigo_placa'];

    // Obter informações da placa
    $sql = "SELECT * FROM placas WHERE Id = $codigo_placa";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row['nome'];
        $marca_nome = $row['marca_nome'];
        $fabricante_nome = $row['fabricante_nome'];
        $utilidades_nome = $row['utilidades_nome'];
        $vram = $row['vram'];
        $clock = $row['clock'];
        $consumo = $row['consumo'];
        $imagem = $row['imagem'];

        // Obter comentários da placa
        $sql_comentarios = "SELECT * FROM comentarios WHERE codigo_placa = $codigo_placa";
        $result_comentarios = $conn->query($sql_comentarios);
        $comentarios = [];

        if ($result_comentarios->num_rows > 0) {
            while ($row_comentario = $result_comentarios->fetch_assoc()) {
                $comentarios[] = $row_comentario['comentario'];
            }
        }
    } else {
        echo 'Placa não encontrada';
        exit();
    }
} else {
    echo 'Código da placa não especificado';
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Detalhes da Placa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 120px;
        }

        .placa-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            width: 300px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .placa-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .placa-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .placa-info {
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

        .rating {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            color: #ddd;
            font-size: 28px;
            cursor: pointer;
        }

        .rating label:hover,
        .rating label:hover~label,
        .rating input[type="radio"]:checked~label {
            color: #ffdd00;
        }

        .comentarios {
            margin-top: 20px;
        }

        .comentarios h4 {
            margin-bottom: 10px;
        }

        .comentarios ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .comentarios li {
            margin-bottom: 10px;
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
        <div class="placa-card">
            <div class="placa-image">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($imagem); ?>" class="card-img-top" alt="Imagem da Placa">
            </div>
            <div class="placa-info">
                <h3 class="card-title"><?php echo $nome; ?></h3>
                <div class="campo">
                    <label>Marca:</label>
                    <span><?php echo $marca_nome; ?></span>
                </div>
                <div class="campo">
                    <label>Fabricante:</label>
                    <span><?php echo $fabricante_nome; ?></span>
                </div>
                <div class="campo">
                    <label>Utilidades:</label>
                    <span><?php echo $utilidades_nome; ?></span>
                </div>
                <div class="campo">
                    <label>VRAM:</label>
                    <span><?php echo $vram; ?></span>
                </div>
                <div class="campo">
                    <label>Clock:</label>
                    <span><?php echo $clock; ?></span>
                </div>
                <div class="campo">
                    <label>Consumo:</label>
                    <span><?php echo $consumo; ?></span>
                </div>

                <div class="rating">
                    <input type="radio" id="rating5" name="rating" value="5">
                    <label for="rating5">&#9733;</label>
                    <input type="radio" id="rating4" name="rating" value="4">
                    <label for="rating4">&#9733;</label>
                    <input type="radio" id="rating3" name="rating" value="3">
                    <label for="rating3">&#9733;</label>
                    <input type="radio" id="rating2" name="rating" value="2">
                    <label for="rating2">&#9733;</label>
                    <input type="radio" id="rating1" name="rating" value="1">
                    <label for="rating1">&#9733;</label>
                </div>

                <div class="campo">
                    <label for="comentario">Comentário:</label>
                    <textarea id="comentario" name="comentario" rows="4" cols="30"></textarea>
                </div>

                <button type="submit" name="btnAvaliar" class="btn btn-primary">Avaliar</button>

                <div class="comentarios">
                    <h4>Comentários anteriores:</h4>
                    <ul>
                        <?php
                        foreach ($comentarios as $comentario) {
                            echo '<li>' . $comentario . '</li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>