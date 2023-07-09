<?php
require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

session_start();
if (isset($_SESSION['usuario_logado'])) {
    $nomeUsuario = explode(",", $_SESSION['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_SESSION['usuario_logado'])[1];
    
    if ($tipoUsuario != '0') {
        header('Location: ../usuarioComum/home.php');
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
    <title>Administração</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top: 120px;
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

        .image-fit {
            height: 200px;
            width: auto;
            object-fit: cover;
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
                    <a class="nav-link" href="cadastroPlaca.php">Cadastrar Placa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modal-signup" data-toggle="modal">Cadastrar Administrador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios.php">Usuários</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color: red;">Sair</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php
        $sql = "SELECT p.*, m.nome AS marca_nome, f.nome AS fabricante_nome, GROUP_CONCAT(u.nome SEPARATOR ', ') AS utilidades_nome
        FROM placa p
        INNER JOIN marca m ON p.marca_id = m.id
        INNER JOIN fabricante f ON p.fabricante_id = f.id
        INNER JOIN placa_utilidade pu ON p.id = pu.placa_id
        INNER JOIN utilidade u ON pu.utilidade_id = u.id
        GROUP BY p.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="row row-cols-1 row-cols-md-3">';
            while ($row = $result->fetch_assoc()) {
                $placaId = $row['Id'];
                $nome = $row['nome'];
                $marca_nome = $row['marca_nome'];
                $fabricante_nome = $row['fabricante_nome'];
                $utilidades_nome = $row['utilidades_nome'];
                $vram = $row['vram'];
                $clock = $row['clock'];
                $consumo = $row['consumo'];
                $imagem = $row['imagem'];
                $preco = $row["preco"];

                echo '<div class="col mb-4">';
                echo '<div class="card d-flex h-100">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($imagem) . '" class="card-img-top img-fluid image-fit" alt="Imagem da Placa">';
                echo '<div class="card-body flex-fill">';
                echo '<h3 class="card-title">' . $nome . '</h3>';
                echo '<p class="card-text"><strong>Marca:</strong> ' . $marca_nome . '</p>';
                echo '<p class="card-text"><strong>Fabricante:</strong> ' . $fabricante_nome . '</p>';
                echo '<p class="card-text"><strong>Utilidades:</strong> ' . $utilidades_nome . '</p>';
                echo '<p class="card-text"><strong>VRAM:</strong> ' . $vram . '</p>';
                echo '<p class="card-text"><strong>Clock:</strong> ' . $clock . '</p>';
                echo '<p class="card-text"><strong>Consumo:</strong> ' . $consumo . '</p>';
                echo '<h5 class="card-text text-success"><strong>Preço: R$</strong> ' . $preco . '</h5>';
                echo '<a href="editarPlaca.php?id=' . $placaId . '" class="btn btn-primary">Editar</a>';
                echo ' <a href="excluirPlaca.php?id=' . $placaId . '" class="btn btn-danger">Excluir</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo 'Nenhuma placa encontrada';
        }
        ?>
    </div>
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

                        $query = "INSERT INTO usuario (nome, email, senha, tipo) VALUES ('$nome', '$email', '$senha', '0')";
                        $resultado = mysqli_query($conn, $query);

                        if ($resultado) {
                            echo '<script>alert("Usuário cadastrado com sucesso!");</script>';
                        } else {
                            echo '<script>alert("Erro ao cadastrar ' . mysqli_error($conn) . ' ")' . ';</script>';
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