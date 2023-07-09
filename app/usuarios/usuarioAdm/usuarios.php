<?php
require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

session_start();
if (isset($_SESSION['usuario_logado'])) {
    $nomeUsuario = explode(",", $_SESSION['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_SESSION['usuario_logado'])[1];
    if ($tipoUsuario != '0') {
        header('Location: ../usuarios/usuarioComum/home.php');
        exit();
    }
} else {
    header("Location: ../deslogado.php");
    exit();
}

function mostrarMensagemConfirmacao($id)
{
    echo '
    <script>
        if (confirm("Tem certeza de que deseja excluir o usuário?")) {
            window.location.href = "usuarios.php?excluir_id=' . $id . '";
        }
    </script>
    ';
}

if (isset($_GET['excluir_id'])) {
    $idExclusao = $_GET['excluir_id'];
    $sqlExclusao = "DELETE FROM usuario WHERE id = $idExclusao";

    if ($conn->query($sqlExclusao) === TRUE) {
        echo '<script>alert("Usuário excluído com sucesso.");</script>';
    } else {
        echo '<script>alert("Erro ao excluir o usuário: ' . $conn->error . '");</script>';
    }
}

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Usuários no Sistema</title>
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
                    <a class="nav-link" href="home.php">Home</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Lista de Usuários</h1>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    $id = $row['Id'];
                    $nome = $row['nome'];
                    $email = $row['email'];
                    $tipo = $row['tipo'] == 0 ? 'Admin' : 'Comum';

                    if ($count % 3 == 0) {
                        echo '<div class="w-100"></div>'; // Quebra de linha após cada 3 usuários
                    }

                    echo '
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">' . $nome . '</h5>
                            <p class="card-text"><strong>Email:</strong> ' . $email . '</p>
                            <p class="card-text"><strong>Tipo:</strong> ' . $tipo . '</p>
                            <button class="btn btn-danger" onclick="mostrarMensagem(' . $id . ')">Excluir</button>
                        </div>
                    </div>
                </div>
                ';

                    $count++;
                }
            } else {
                echo '<div class="col-12">Nenhum usuário encontrado.</div>';
            }
            ?>
        </div>
    </div>

    <script>
        function mostrarMensagem(id) {
            if (confirm("Tem certeza de que deseja excluir o usuário?")) {
                window.location.href = "usuarios.php?excluir_id=" + id;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>