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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cadastro Placa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 120px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
        }

        button[type="submit"] {
            margin-top: 10px;
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
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <select id="marca" name="marca" class="form-control" required>
                    <option value="">Selecione uma marca</option>

                    <?php
                    $sql = "SELECT id, nome FROM marca";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $idMarca = $row['id'];
                            $nomeMarca = $row['nome'];
                            echo '<option value="' . $idMarca . '">' . $nomeMarca . '</option>';
                        }
                    } else {
                        echo 'Nenhuma marca encontrada';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" class="form-control" required>
            </div>

            <?php
            // Consulta SQL para recuperar os fabricantes existentes
            $sql = "SELECT id, nome FROM fabricante";
            $result = $conn->query($sql);

            // Verificar se há resultados e construir o dropdown ou campo de texto
            if ($result->num_rows > 0) {
                echo '<div class="form-group">';
                echo '<label for="fabricante">Fabricante:</label>';
                echo '<select id="fabricante" name="fabricante" class="form-control">';
                echo '<option value="">Selecione um fabricante</option>';

                while ($row = $result->fetch_assoc()) {
                    $idFabricante = $row['id'];
                    $nomeFabricante = $row['nome'];
                    echo '<option value="' . $idFabricante . '">' . $nomeFabricante . '</option>';
                }

                echo '</select>';
                echo '</div>';
            } else {
                echo "Nenhum fabricante registrado";
            }
            ?>

            <div class="form-group">
                <label for="utilidades">Utilidades:</label>
                <select id="utilidades" name="utilidades[]" class="form-control" multiple required>
                    <?php
                    $sql = "SELECT id, nome FROM utilidade";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $idUtilidade = $row['id'];
                            $utilidade = $row['nome'];
                            echo '<option value="' . $idUtilidade . '">' . $utilidade . '</option>';
                        }
                    } else {
                        echo 'Nenhuma utilidade encontrada';
                    }
                    ?>
                </select>
            </div>


            <div class="form-group">
                <label for="vram">VRAM:</label>
                <input type="text" id="vram" name="vram" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="clock">Clock:</label>
                <input type="text" id="clock" name="clock" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="consumo">Consumo:</label>
                <input type="text" id="consumo" name="consumo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem:</label>
                <input type="file" id="path" name="imagem" class="form-control-file" required>
            </div>

            <button type="submit" name="btnCadastrar" class="btn btn-primary">Cadastrar</button>
        </form>
        <?php
        if (isset($_POST['btnCadastrar'])) {
            $nome = $_POST['nome'];
            $marca = $_POST['marca'];
            $preco = $_POST['preco'];
            $fabricante = $_POST['fabricante'];
            $vram = $_POST['vram'];
            $clock = $_POST['clock'];
            $consumo = $_POST['consumo'];
            $utilidades = $_POST['utilidades'];

            if (isset($_FILES['imagem'])) {
                $imagem = $_FILES['imagem'];

                if ($imagem['error'] === UPLOAD_ERR_OK) {
                    $conteudoImagem = file_get_contents($imagem['tmp_name']);

                    $stmt = $conn->prepare("INSERT INTO placa (nome, marca_id, preco, fabricante_id, vram, clock, consumo, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssidssss", $nome, $marca, $preco, $fabricante, $vram, $clock, $consumo, $conteudoImagem);

                    if ($stmt->execute()) {
                        $placaId = $stmt->insert_id;

                        foreach ($utilidades as $utilidadeId) {
                            $stmt = $conn->prepare("INSERT INTO placa_utilidade (placa_id, utilidade_id) VALUES (?, ?)");
                            $stmt->bind_param("ii", $placaId, $utilidadeId);
                            $stmt->execute();
                        }

                        echo "<script>alert('Placa cadastrada com sucesso!');</script>";
                    } else {
                        echo "<script>alert('" . "Erro ao cadastrar placa: " .  $stmt->error . "');</script>";
                    }

                    $stmt->close();
                } else {
                    echo "Erro no envio da imagem: " . $imagem['error'];
                }
            } else {
                echo "Nenhuma imagem enviada!";
            }
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>