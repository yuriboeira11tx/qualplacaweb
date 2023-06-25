<!DOCTYPE html>
<html>
<head>
    <title>HomeAdm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 80px;
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
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Pagina Inicial</a>
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
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="utilidade">Utilidade:</label>
            <input type="text" id="utilidade" name="utilidade" class="form-control" required>
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
            <label for="path">Imagem:</label>
            <input type="file" id="path" name="path" class="form-control-file" required>
        </div>

        <button type="submit" name="btnCadastrar" class="btn btn-primary">Cadastrar</button>
    </form>
    <?php
        require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

        if (isset($_POST['btnCadastrar'])){
            // Recupera os valores do formulário
            $nome = $_POST['nome'];
            $marca = $_POST['marca'];
            $preco = $_POST['preco'];
            $fabricante = $_POST['fabricante'];
            $utilidade = $_POST['utilidade'];
            $vram = $_POST['vram'];
            $clock = $_POST['clock'];
            $consumo = $_POST['consumo'];
            
            // Trata o upload do arquivo de imagem
            $imagem = $_FILES['path'];
            $imagemNome = $imagem['name'];
            $imagemTmp = $imagem['tmp_name'];
            $imagemDestino = 'C:xampp/htdocs/qualplacaweb/app/img/' . $imagemNome;
            
            // Move o arquivo de imagem para o destino final
            move_uploaded_file($imagemTmp, $imagemDestino);
            $query = "INSERT INTO placa (nome, marca_Id, preco, fabricante_Id, utilidade_Id, vram, clock, consumo, path) VALUES ('$nome', '$marca', '$preco', '$fabricante', '$utilidade', '$vram', '$clock', '$consumo', '$imagemNome')";
            $resultado = mysqli_query($conn, $query);                
        }
    ?>
</div>
<div id="modal-signup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="signup-name">Nome</label>
                        <input type="text" class="form-control" id="signup-name" placeholder="Digite o nome">
                    </div>
                    <div class="form-group">
                        <label for="signup-email">E-mail</label>
                        <input type="email" class="form-control" id="signup-email" placeholder="Digite o e-mail">
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Senha</label>
                        <input type="password" class="form-control" id="signup-password" placeholder="Digite a senha">
                    </div>
                    <button type="submit" name="btnCadastro" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
