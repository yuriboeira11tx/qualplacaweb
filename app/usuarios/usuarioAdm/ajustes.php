<?php
if (isset($_COOKIE['usuario_logado'])) {
    $nomeUsuario = explode(",", $_COOKIE['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_COOKIE['usuario_logado'])[1];

    // Redirecionar com base no tipo de usuário
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
    <title>Ajustes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
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
                    <a class="nav-link" href="home.php">Pagina Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cadastroPlaca.php">Cadastrar Placa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#modal-signup" data-toggle="modal">Cadastrar Administrador</a>
                </li>
            </ul>
        </div>
    </nav>
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