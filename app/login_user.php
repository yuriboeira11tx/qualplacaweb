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
    <img src="logo.png" class="card-img-top" alt="Imagem de login" style="width: 100px;height: 100px;">
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
        <button type="submit" name= "btnLogin" class="btn btn-primary">Login</button>
        <?php
          if (isset($_POST['btnLogin'])&&($_POST['email'])&&($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($email == '1@1' && $password == '1') {
              // FAZER Autenticação no DB
              header("Location: usuarios/home.php");
              exit;
            } else {
              echo "<BR>Login e/ou senha inválidos!";
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
          <form>
            <div class="form-group">
              <label for="signup-name">Nome</label>
              <input type="text" class="form-control" id="signup-name" placeholder="Digite seu nome">
            </div>
            <div class="form-group">
              <label for="signup-email">E-mail</label>
              <input type="email" class="form-control" id="signup-email" placeholder="Digite seu e-mail">
            </div>
            <div class="form-group">
              <label for="signup-password">Senha</label>
              <input type="password" class="form-control" id="signup-password" placeholder="Digite sua senha">
            </div>
            <button type="submit" name= "btnCadastro" class="btn btn-primary">Cadastrar</button>
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
