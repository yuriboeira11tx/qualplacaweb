<?php
    require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

    if (isset($_COOKIE['usuario_logado'])) {
        $nomeUsuario = explode(",", $_COOKIE['usuario_logado'])[0];
        $tipoUsuario = explode(",", $_COOKIE['usuario_logado'])[1];
        if ($tipoUsuario != '1') {
            header('Location: usuarios/usuarioAdm/home.php');
            exit();
        }
    } else {
        header("Location: usuarios/deslogado.php");
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
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .placa-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            width: 600px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .placa-image {
            width: 200px;
            height: 200px;
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
        }

        .placa-info h3 {
            margin-bottom: 10px;
        }

        .placa-info p {
            margin-bottom: 5px;
        }

        .placa-info .campo {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .placa-info .campo label {
            flex: 0 0 120px;
            font-weight: bold;
        }

        .placa-info .campo span {
            flex: 1;
        }

        .placa-info .campo-utilidade {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Logo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favoritos.php">Favoritos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="placas_avaliadas.php">Placas Avaliadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="minhas_sugestoes.php">Minhas Sugestões</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
    <h2>Essas são as placas disponíveis conforme o filtro solicitado:</h2>

    <?php if (isset($_COOKIE['cookie_busca'])): ?>
        <form>
            <?php
            $busca = unserialize($_COOKIE['cookie_busca']);
            $precoMaximo = isset($busca[0]) ? $busca[0] : '';
            $marca = isset($busca[1]) ? $busca[1] : '';
            $fabricante = isset($busca[2]) ? $busca[2] : '';
            $memoria = isset($busca[3]) ? $busca[3] : '';
            $clock = isset($busca[4]) ? $busca[4] : '';
            $utilidades = isset($busca[5]) ? $busca[5] : '';
            $consumo = isset($busca[6]) ? $busca[6] : '';
            $estrelas = isset($busca[7]) ? $busca[7] : '';

            //$sql = "SELECT * FROM placa P WHERE P.preco < '$precoMaximo' AND P.marca_Id = '$marca' AND P.fabricante_Id = '$fabricante' AND P.vram = '$memoria' AND P.clock = '$clock' AND P.utilidade_Id = '$utilidades' AND P.consumo = '$consumo' AND P.qtdEstrelas = '$estrelas'";
            $sql = "SELECT * FROM placa P";
            $results = mysqli_query($conn, $sql);

            if (mysqli_num_rows($results) > 0) {
                while ($result = mysqli_fetch_assoc($results)) :
            ?>
            <div class="placa-card">
                <div class="placa-image">
                    <img src="<?= $result['path'] ?>" alt="<?= $result['nome'] ?>">
                </div>
                <div class="placa-info">
                    <h3><?= $result['nome'] ?></h3>
                    <div class="campo">
                        <label>Modelo:</label>
                        <span><?= $result['nome'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Marca:</label>
                        <span><?= $result['marca_Id'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Fabricante:</label>
                        <span><?= $result['fabricante_Id'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Memória:</label>
                        <span><?= $result['vram'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Clock:</label>
                        <span><?= $result['clock'] ?></span>
                    </div>
                    <div class="campo campo-utilidade">
                        <label>Utilidade(s):</label>
                        <span><?= $result['utilidade_Id'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Consumo:</label>
                        <span><?= $result['consumo'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Avaliação:</label>
                        <span><?= $result['qtdEstrelas'] ?></span>
                    </div>
                    <div class="campo">
                        <label>Preço:</label>
                        <span><?= $result['preco'] ?></span>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
            } else {
                echo '<p class="text-center">Nenhuma placa de vídeo corresponde aos critérios de filtragem.</p>';
            }
            ?>
        </form>
        <?php endif; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
</body>

</html>