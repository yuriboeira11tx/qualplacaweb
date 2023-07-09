<?php
    require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

    if (isset($_COOKIE['usuario_logado'])) {
        $nomeUsuario = explode(",", $_COOKIE['usuario_logado'])[0];
        $tipoUsuario = explode(",", $_COOKIE['usuario_logado'])[1];
        if ($tipoUsuario != '0') {
            header('Location: usuarios/usuarioComum/home.php');
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
    <title>HomeAdm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top: 70px;
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

        .placa-card:first-child {
            margin-top: 20px;
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
                    <a class="nav-link" href="cadastroPlaca.php">Cadastrar Placa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ajustes.php">Ajustes Sugeridos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modal-signup" data-toggle="modal">Cadastrar Administrador</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form>
            <?php
            //$sql =  "SELECT P.preco, (select M.nome FROM marca M WHERE M.Id = P.marca_Id), (select F.nome FROM fabricante F WHERE F.Id = P.fabricante_Id), P.vram, P.clock, (select U.nome FROM utilidade U WHERE U.Id = P.utilidade_Id), P.consumo, P.qtdEstrelas FROM placa P WHERE P.preco < '$precoMaximo' AND P.marca_Id = '$marca' AND P.fabricante_Id = '$fabricante' AND P.vram = '$memoria' AND P.clock = '$clock' AND P.utilidade_Id = '$utilidades' AND P.consumo = '$consumo' AND P.qtdEstrelas = '$estrelas';
            // $sql = "SELECT * FROM placa P WHERE P.qtdEstrelas > 5";
            $sql = "SELECT * FROM placa P;";
            $results = mysqli_query($conn, $sql);

            if (mysqli_num_rows($results) > 0) {
                while ($result = mysqli_fetch_assoc($results)) :
            ?>
            <div class="placa-card">
                <div class="placa-image">
                    <img src="<?= $result['path'] ?>">
                </div>
                <div class="placa-info">
                    <h3><?= $result['nome'] ?></h3>
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

    <div id="modal-signup" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="signup-name">Nome</label>
                            <input type="text" class="form-control" id="signup-name" name='nome' placeholder="Digite o nome">
                        </div>
                        <div class="form-group">
                            <label for="signup-email">E-mail</label>
                            <input type="email" class="form-control" id="signup-email" name='email' placeholder="Digite o e-mail">
                        </div>
                        <div class="form-group">
                            <label for="signup-password">Senha</label>
                            <input type="password" class="form-control" id="signup-password" name='senha' placeholder="Digite a senha">
                        </div>
                        <button type="submit" name="btnCadastro" class="btn btn-primary">Cadastrar</button>
                    </form>
                    <?php
                        if (isset($_POST['btnCadastro']) && ($_POST['nome']) && ($_POST['email']) && ($_POST['senha'])) {
                            $nome = $_POST['nome'];
                            $email = $_POST['email'];
                            $senha = $_POST['senha'];

                            // Executa a query de inserção
                            $query = "INSERT INTO usuario (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '0')";
                            $resultado = mysqli_query($conn, $query);

                            // Verifica se o cadastro foi realizado com sucesso
                            if ($resultado) {
                                echo '<script>alert("Usuário cadastrado com sucesso!");</script>';
                            } else {
                                echo '<script>alert("Erro ao cadastrar '. mysqli_error($conn) . ' ")' . ';</script>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>