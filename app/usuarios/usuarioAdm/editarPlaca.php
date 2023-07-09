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

if (isset($_GET['id'])) {
    $idPlaca = $_GET['id'];

    // Consulta SQL para recuperar os dados da placa pelo ID
    $stmt = $conn->prepare("SELECT * FROM placa WHERE id = ?");
    $stmt->bind_param("i", $idPlaca);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $placa = $result->fetch_assoc();
        $nome = $placa['nome'];
        $marca = $placa['marca_Id'];
        $preco = $placa['preco'];
        $fabricante = $placa['fabricante_Id'];
        $vram = $placa['vram'];
        $clock = $placa['clock'];
        $consumo = $placa['consumo'];
        $imagemAtual = $placa['imagem'];
    } else {
        echo "Placa não encontrada.";
        exit();
    }

    $stmt->close();
} else {
    echo "ID da placa não especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Placa</title>
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
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo $nome; ?>" required>
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
                            $selected = ($idMarca == $marca) ? "selected" : "";
                            echo '<option value="' . $idMarca . '" ' . $selected . '>' . $nomeMarca . '</option>';
                        }
                    } else {
                        echo 'Nenhuma marca encontrada';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" class="form-control" value="<?php echo $preco; ?>" required>
            </div>

            <?php
            $sql = "SELECT id, nome FROM fabricante";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="form-group">';
                echo '<label for="fabricante">Fabricante:</label>';
                echo '<select id="fabricante" name="fabricante" class="form-control">';
                echo '<option value="">Selecione um fabricante</option>';

                while ($row = $result->fetch_assoc()) {
                    $idFabricante = $row['id'];
                    $nomeFabricante = $row['nome'];
                    $selected = ($idFabricante == $fabricante) ? "selected" : "";
                    echo '<option value="' . $idFabricante . '" ' . $selected . '>' . $nomeFabricante . '</option>';
                }

                echo '</select>';
                echo '</div>';
            } else {
                echo "Nenhum fabricante registrado";
            }
            ?>

            <div class="form-group">
                <label for="vram">VRAM:</label>
                <input type="text" id="vram" name="vram" class="form-control" value="<?php echo $vram; ?>" required>
            </div>

            <div class="form-group">
                <label for="clock">Clock:</label>
                <input type="text" id="clock" name="clock" class="form-control" value="<?php echo $clock; ?>" required>
            </div>

            <div class="form-group">
                <label for="consumo">Consumo:</label>
                <input type="text" id="consumo" name="consumo" class="form-control" value="<?php echo $consumo; ?>" required>
            </div>

            <div class="form-group">
                <label for="utilidades">Utilidades:</label>
                <select id="utilidades" name="utilidades[]" class="form-control" multiple required>
                    <?php
                    $sqlUtilidades = "SELECT Id, nome FROM utilidade";
                    $resultUtilidades = $conn->query($sqlUtilidades);

                    if ($resultUtilidades->num_rows > 0) {
                        while ($rowUtilidades = $resultUtilidades->fetch_assoc()) {
                            $idUtilidade = $rowUtilidades['Id'];
                            $utilidade = $rowUtilidades['nome'];
                            $placaId = $_GET['id'];
                            $sqlPlacaUtilidade = "SELECT * FROM placa_utilidade WHERE placa_id = $placaId AND utilidade_id = $idUtilidade";
                            $resultPlacaUtilidade = $conn->query($sqlPlacaUtilidade);

                            $isSelected = $resultPlacaUtilidade->num_rows > 0 ? 'selected' : '';

                            echo '<option value="' . $idUtilidade . '" ' . $isSelected . '>' . $utilidade . '</option>';
                        }
                    } else {
                        echo 'Nenhuma utilidade encontrada';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="imagem_atual">Imagem Atual:</label>
                <div class="placa-image">
                    <img src="data:image/jpeg;base64, <?php echo base64_encode($imagemAtual); ?>" class="img-fluid" alt="Imagem Atual">
                </div>
            </div>

            <div class="form-group">
                <label for="imagem">Nova Imagem:</label>
                <input type="file" id="imagem" name="nova_imagem" class="form-control-file">
            </div>

            <input type="hidden" name="placa_id" value="<?php echo $placaId; ?>">
            <button type="submit" name="btnEditar" class="btn btn-primary">Editar</button>
        </form>
        <?php
        if (isset($_POST['btnEditar'])) {
            $placaId = $_POST['placa_id'];
            $nome = $_POST['nome'];
            $marca = $_POST['marca'];
            $preco = $_POST['preco'];
            $fabricante = $_POST['fabricante'];
            $vram = $_POST['vram'];
            $clock = $_POST['clock'];
            $consumo = $_POST['consumo'];
            $utilidades = $_POST['utilidades'];

            if ($_FILES['nova_imagem']['error'] === UPLOAD_ERR_OK) {
                $novaImagem = $_FILES['nova_imagem'];
                $conteudoNovaImagem = file_get_contents($novaImagem['tmp_name']);
                $stmt = $conn->prepare("UPDATE placa SET nome = ?, marca_id = ?, preco = ?, fabricante_id = ?, vram = ?, clock = ?, consumo = ?, imagem = ? WHERE id = ?");
                $stmt->bind_param("ssidssssi", $nome, $marca, $preco, $fabricante, $vram, $clock, $consumo, $conteudoNovaImagem, $placaId);

                if ($stmt->execute()) {
                    $stmt = $conn->prepare("DELETE FROM placa_utilidade WHERE placa_id = ?");
                    $stmt->bind_param("i", $placaId);
                    $stmt->execute();

                    foreach ($utilidades as $utilidadeId) {
                        $stmt = $conn->prepare("INSERT INTO placa_utilidade (placa_id, utilidade_id) VALUES (?, ?)");
                        $stmt->bind_param("ii", $placaId, $utilidadeId);
                        $stmt->execute();
                    }

                    echo "<script>alert('Placa atualizada com sucesso!');</script>";
                    echo "<script>window.location.href = 'home.php';</script>";
                } else {
                    echo "<script>alert('Erro ao atualizar placa: " . $stmt->error . "');</script>";
                    echo "<script>window.location.href = 'home.php';</script>";
                }
            } else {
                $stmt = $conn->prepare("UPDATE placa SET nome = ?, marca_id = ?, preco = ?, fabricante_id = ?, vram = ?, clock = ?, consumo = ? WHERE id = ?");
                $stmt->bind_param("ssidsssi", $nome, $marca, $preco, $fabricante, $vram, $clock, $consumo, $placaId);

                if ($stmt->execute()) {
                    $stmt = $conn->prepare("DELETE FROM placa_utilidade WHERE placa_id = ?");
                    $stmt->bind_param("i", $placaId);
                    $stmt->execute();

                    foreach ($utilidades as $utilidadeId) {
                        $stmt = $conn->prepare("INSERT INTO placa_utilidade (placa_id, utilidade_id) VALUES (?, ?)");
                        $stmt->bind_param("ii", $placaId, $utilidadeId);
                        $stmt->execute();
                    }

                    echo "<script>alert('Placa atualizada com sucesso!');</script>";
                    echo "<script>window.location.href = 'home.php';</script>";
                } else {
                    echo "<script>alert('Erro ao atualizar placa: " . $stmt->error . "');</script>";
                    echo "<script>window.location.href = 'home.php';</script>";
                }
            }

            $stmt->close();
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>