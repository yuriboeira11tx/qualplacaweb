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
    $sql = "SELECT p.*, m.nome AS marca_nome, f.nome AS fabricante_nome, GROUP_CONCAT(u.nome SEPARATOR ', ') AS utilidades_nome
        FROM placa p
        INNER JOIN marca m ON p.marca_id = m.id
        INNER JOIN fabricante f ON p.fabricante_id = f.id
        INNER JOIN placa_utilidade pu ON p.id = pu.placa_id
        INNER JOIN utilidade u ON pu.utilidade_id = u.id
        WHERE p.Id = '$codigo_placa'
        GROUP BY p.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codigo_placa = $row['Id'];
        $nome = $row['nome'];
        $marca_nome = $row['marca_nome'];
        $fabricante_nome = $row['fabricante_nome'];
        $utilidades_nome = $row['utilidades_nome'];
        $vram = $row['vram'];
        $clock = $row['clock'];
        $consumo = $row['consumo'];
        $imagem = $row['imagem'];

        // Obter comentários da placa
        $sql_2 = "SELECT a.*, u.nome AS nome_usuario
                    FROM avaliacao a
                    INNER JOIN usuario u ON a.usuario_Id = u.Id
                    WHERE a.placa_Id = '$codigo_placa'";

        $result_2 = $conn->query($sql_2);
        $avaliacoes = [];

        if ($result_2->num_rows > 0) {
            while ($row_avaliacao = $result_2->fetch_assoc()) {
                $avaliacoes[] = $row_avaliacao;
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

if (isset($_POST['btnAvaliar'])&& $_POST['rating'] != '') {
    $estrelas = $_POST['rating'];
    $comentario = $_POST['comentario'];

    // Busca código do usuário
    $sql = "SELECT u.Id FROM usuario u WHERE u.nome like '$nomeUsuario'";
    $result_usuario = $conn->query($sql);

    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $id_usuario = $row_usuario['Id'];

        // Executa a query de inserção
        $query = "INSERT INTO avaliacao (usuario_Id, placa_Id, valor, comentario, data) VALUES ('$id_usuario', '$codigo_placa', '$estrelas', '$comentario', NOW())";

        $resultado = $conn->query($query);

        if ($resultado) {
            header('Location: placa.php?codigo_placa=' . $codigo_placa);
            exit();
        }
    }else {
        echo 'Usuário não encontrado';
        exit();
    }
}
if (isset($_POST['btnFavoritar'])) {
    // Busca código do usuário
    $sql = "SELECT u.Id FROM usuario u WHERE u.nome like '$nomeUsuario'";
    $result_usuario = $conn->query($sql);

    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $id_usuario = $row_usuario['Id'];

        // Executa a query de inserção
        $query = "INSERT INTO favorito (usuario_Id, placa_Id) VALUES ('$id_usuario', '$codigo_placa')";

        $resultado = $conn->query($query);

        if ($resultado) {
            header('Location: placa.php?codigo_placa=' . $codigo_placa);
            exit();
        }
    }else {
        echo 'Usuário não encontrado';
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Detalhes da Placa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 80px;
            width: 800px;
            margin: 0 auto;
        }

        .placa-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .placa-image {
            width: 300px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .placa-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .placa-info {
            padding: 20px;
        }

        .card-title {
            margin-bottom: 20px;
            text-align: center;
        }

        .placa-info .campo {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .placa-info .campo label {
            font-weight: bold;
            width: 120px;
            margin-right: 10px;
        }

        .rating {
            display: inline-block;
            justify-content: center;
            margin-bottom: 20px;
            padding-left: 41%;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            float: right;
            cursor: pointer;
            color: #aaa;
            font-size: 30px;
        }

        .rating label:before {
            content: "\2606";
            /* Estrela vazia */
        }

        .rating input[type="radio"]:checked~label:before {
            content: "\2605";
            /* Estrela preenchida */
            color: #ff9800;
        }

        .campo textarea {
            width: 100%;
            resize: vertical;
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

        .favoritar-btn {
            float: right;
            margin-bottom: 10px;
            margin-right: 30px;
            margin-top: -70px;
        }

        .btn-centralizar {
            display: flex;
            justify-content: center;
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
                    <div class="text-center">
                        <h3 class="card-title"><?php echo $nome; ?></h3>
                    </div>
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
                </div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                <button type="button" name="btnFavoritar" class="btn btn-primary favoritar-btn btn-centralizar">Favoritar</button>
            </form>
        </div>

        <div class="placa-card">
            <div class="placa-info">
                <h3 class="card-title">Avaliação</h3>
                <form method="post">
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5"></label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4"></label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3"></label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2"></label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1"></label>
                    </div>
        
                    <div class="campo">
                        <label for="comentario">Comentário:</label>
                        <textarea id="comentario" name="comentario" rows="4" cols="30"></textarea>
                    </div>

                    <div class="campo text-center btn-centralizar">
                        <button type="submit" name="btnAvaliar" class="btn btn-primary">Avaliar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="placa-card">
            <div class="placa-info">
                <h3 class="card-title">Comentários</h3>
                <div class="comentarios">
                    <ul>
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
                            foreach ($avaliacoes as $avaliacao) {
                                $comentario = $avaliacao['comentario'];
                                $data = $avaliacao['data'];
                                $horario = date('d/m/Y H:i', strtotime($data));
                                $nomeUsuario = $avaliacao['nome_usuario'];
                                $estrelas = $avaliacao['valor'];
                            
                                echo '<li>' . $horario . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $nomeUsuario . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . getRatingStars($estrelas) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $comentario . '</li>';
                            }                          
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Adicionar manipulador de eventos para atualizar as estrelas selecionadas
        const ratingInputs = document.querySelectorAll('.rating input[type="radio"]');
        ratingInputs.forEach((input) => {
            input.addEventListener('change', updateRating);
        });

        // Função para atualizar as estrelas selecionadas
        function updateRating() {
            const selectedRating = this.value;
            console.log(`Avaliação: ${selectedRating}`);
        }
    </script>                   
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
