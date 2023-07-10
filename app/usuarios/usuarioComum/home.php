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

if (isset($_POST['btnBusca'])) {
    $precoMaximo = $_POST['precoMaximo'];
    $marca = $_POST['marca'];
    $fabricante = $_POST['fabricante'];
    $memoria = $_POST['memoria'];
    $clock = $_POST['clock'];
    $consumo = $_POST['consumo'];
    $utilidades = array();

    if (isset($_POST['streaming'])) {
        $utilidades[] = $_POST['streaming'];
    }
    if (isset($_POST['computacao'])) {
        $utilidades[] = $_POST['computacao'];
    }
    if (isset($_POST['mineracao'])) {
        $utilidades[] = $_POST['mineracao'];
    }
    if (isset($_POST['edicao'])) {
        $utilidades[] = $_POST['edicao'];
    }
    if (isset($_POST['jogos'])) {
        $utilidades[] = $_POST['jogos'];
    }
    $consumo = $_POST['consumo'];
    $estrelas = $_POST['rating'];

    $sql = "SELECT p.*, m.nome AS marca_nome, f.nome AS fabricante_nome, GROUP_CONCAT(u.nome SEPARATOR ', ') AS utilidades_nome";

    if (!empty($estrelas)) {
        $sql .= ", AVG(a.valor) AS estrelas 
                FROM placa p 
                INNER JOIN avaliacao a ON a.placa_Id = p.Id";
    } else {
        $sql .= " FROM placa p";
    }

    $sql .= " INNER JOIN marca m ON p.marca_Id = m.Id
                INNER JOIN fabricante f ON p.fabricante_Id = f.Id
                INNER JOIN placa_utilidade pu ON p.Id = pu.placa_Id
                INNER JOIN utilidade u ON pu.utilidade_Id = u.Id
                WHERE 1=1"; // Cláusula WHERE inicial para permitir a adição de condições dinamicamente

    if (!empty($marca)) {
        $sql .= " AND m.nome = '$marca'";
    }

    if (!empty($fabricante)) {
        $sql .= " AND f.Id = '$fabricante'";
    }

    if (!empty($memoria)) {
        $sql .= " AND p.vram <= '$memoria'";
    }

    if (!empty($clock)) {
        $sql .= " AND p.clock <= '$clock'";
    }

    if (!empty($utilidades)) {
        $utilidades = implode("', '", $utilidades);
        $sql .= " AND u.Id IN ('$utilidades')";
    }

    if (!empty($consumo)) {
        $sql .= " AND p.consumo <= '$consumo'";
    }

    if (!empty($estrelas)) {
        $sql .= " GROUP BY p.Id
                HAVING AVG(a.valor) >= '$estrelas'";
    } else {
        $sql .= " GROUP BY p.Id";
    }

    $sql = serialize($sql);

    header('Location: placasBuscadas.php?sql=' . urlencode($sql));
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .rating {
            display: inline-block;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            float: right;
            cursor: pointer;
            color: #aaa;
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

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            padding-top: 120px;
        }

        #welcome-heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-check-label {
            font-size: 14px;
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
                    <a class="nav-link" href="favoritos.php">Favoritos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="placas_avaliadas.php">Placas Avaliadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color: red;">Sair</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2 id="welcome-heading">Seja bem-vindo(a) ao Qual Placa, um sistema web de recomendação de placas de vídeo que vai te ajudar a decidir a melhor opção de acordo com as suas necessidades!</h2>
        <form method="post">
            <div class="form-group row">
                <label for="precoMaximo" class="col-sm-2 col-form-label col-form-label-sm">Preço máximo:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" name="precoMaximo" id="precoMaximo" placeholder="R$" maxlength="15">
                </div>
            </div>

            <div class="form-group row">
                <label for="marca" class="col-sm-2 col-form-label col-form-label-sm">Marca:</label>
                <div class="col-sm-10">
                    <select class="form-control form-control-sm" name="marca" id="marca">
                        <option value="">Selecione a marca</option>
                        <option value="1">ASUS</option>
                        <option value="2">Gigabyte</option>
                        <option value="3">MSI</option>
                        <option value="4">EVGA</option>
                        <option value="5">Zotac</option>
                        <option value="6">Palit</option>
                        <option value="7">Sapphire</option>
                        <option value="8">Galax</option>
                        <option value="9">Colorful</option>
                        <option value="10">Outra</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="fabricante-chip" class="col-sm-2 col-form-label col-form-label-sm">Fabricante do Chip:</label>
                <div class="col-sm-10">
                    <select class="form-control form-control-sm" name="fabricante" id="fabricante-chip">
                        <option value="">Selecione o fabricante</option>
                        <option value="1">Nvidia</option>
                        <option value="2">AMD</option>
                        <option value="3">Intel</option>
                        <option value="4">Outra</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for="memoria-vram" class="col-sm-2 col-form-label col-form-label-sm">Memória VRAM:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="memoria" id="memoria-vram" placeholder="Ex: 4gbs" maxlength="15">
                </div>
            </div>

            <div class="form-group row">
                <label for="clock" class="col-sm-2 col-form-label col-form-label-sm">Clock:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="clock" id="clock" placeholder="Ex: 30mhz" maxlength="15">
                </div>
            </div>

            <div class="form-group row">
                <label for="utilidade-funcional" class="col-sm-2 col-form-label col-form-label-sm">Utilidade Funcional:</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="streaming" id="utilidade-streaming" value="1">
                        <label class="form-check-label" for="utilidade-streaming">
                            Streaming
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="computacao" id="utilidade-computacao" value="2">
                        <label class="form-check-label" for="utilidade-computacao">
                            Computação de Alto Desempenho
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="mineracao" id="utilidade-mineracao" value="3">
                        <label class="form-check-label" for="utilidade-mineracao">
                            Mineração de Criptomoptomoedas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="edicao" id="utilidade-edicao-video" value="4">
                        <label class="form-check-label" for="utilidade-edicao-video">
                            Edição de Vídeos
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jogos" id="utilidade-jogos" value="5">
                        <label class="form-check-label" for="utilidade-jogos">
                            Jogos
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="consumo" class="col-sm-2 col-form-label col-form-label-sm">Consumo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="consumo" id="consumo" placeholder="Informe o consumo em Watts" maxlength="15">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label col-form-label-sm">Avaliação dos usuários:</label>
                <div class="col-sm-10">
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
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" name="btnBusca" class="btn btn-primary">QUAL PLACA?</button>
                </div>
            </div>
        </form>
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