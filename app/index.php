<?php
  require_once 'conexao_database.php';

  if (isset($_COOKIE['usuario_logado'])) {
    $nomeUsuario = explode(",", $_COOKIE['usuario_logado'])[0];
    $tipoUsuario = explode(",", $_COOKIE['usuario_logado'])[1];
    
    // Redirecionar com base no tipo de usuário
    if ($tipoUsuario == '0') {
      header('Location: usuarios/usuarioAdm/home.php');
      exit();
    }
    header('Location: usuarios/usuarioComum/home.php');
    exit();
  }
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
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
  <div class="card" style="width: 400px;">
    <img src="img/logo.png" class="card-img-top" alt="Imagem de login" style="width: 100px;height: 100px;">
    <div class="card-body">
      <h5 class="card-title">Login</h5>
      <form method="post">
        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu e-mail">
        </div>
        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Digite sua senha">
        </div>
        <button type="submit" name="btnLogin" class="btn btn-primary">Login</button>
        <?php
        if (isset($_POST['btnLogin']) && ($_POST['email']) && ($_POST['password'])) {
          $email = $_POST['email'];
          $password = $_POST['password'];

          // Consulta para verificar se o usuário existe
          $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$password'";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
            // Usuário encontrado, login bem-sucedido
            $usuario = mysqli_fetch_assoc($result);

            // Redirecionar com base no tipo de usuário
            if ($usuario['tipo'] == '0') {
              // Definir o cookie com o nome do usuário e tipo do usuário
              $nomeUsuario = $usuario['nome'];
              $tempoExpiracao = time() + 3600;
              setcookie('usuario_logado', "$nomeUsuario,0", $tempoExpiracao);
              header('Location: usuarios/usuarioAdm/home.php');
              exit();
            } else{
              // Definir o cookie com o nome do usuário e tipo do usuário
              $nomeUsuario = $usuario['nome'];
              $tempoExpiracao = time() + 3600;
              setcookie('usuario_logado', "$nomeUsuario,1", $tempoExpiracao);
              header('Location: usuarios/usuarioComum/home.php');
              exit();
            }
          } else {
            // Usuário não encontrado ou senha incorreta
            // Exibir uma mensagem de erro ou realizar outras ações necessárias
            echo '<br><p style="color: red;">Usuário não existe ou a credencial está inválida</p>';
          }
        }
        ?>
      </form>
    </div>
    <div class="card-footer">
      <p>Não possui uma conta? <a href="#modal-signup" class="btn btn-link" data-toggle="modal">Cadastrar</a></p>
    </div>
  </div>
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
              <input type="text" class="form-control" id="signup-name" name="nome" placeholder="Digite seu nome">
            </div>
            <div class="form-group">
              <label for="signup-email">E-mail</label>
              <input type="email" class="form-control" id="signup-email" name="email" placeholder="Digite seu e-mail">
            </div>
            <div class="form-group">
              <label for="signup-password">Senha</label>
              <input type="password" class="form-control" id="signup-password" name="senha" placeholder="Digite sua senha">
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
                    setcookie('usuario_logado', "$signupNome,1", $tempoExpiracao);
                    header('Location: usuarios/usuarioComum/home.php');    
                    exit();
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