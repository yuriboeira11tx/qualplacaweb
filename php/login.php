<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
    }
   

    
    .card {
      width: 400px;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-content">
      <span class="card-title">Login</span>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <input id="email" type="email" class="validate">
              <label for="email">E-mail</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="password" type="password" class="validate">
              <label for="password">Senha</label>
            </div>
          </div>
          <div class="row">
            <button class="btn waves-effect waves-light" type="submit" name="action">Login</button>
          </div>
        </form>
      </div>
    </div>
    <div class="card-action">
      <p>Não possui uma conta? <a href="#modal-signup" class="modal-trigger">Cadastrar</a></p>
    </div>
  </div>

  <div id="modal-signup" class="modal">
    <div class="modal-content">
      <h4>Cadastro</h4>
      <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="input-field col s12">
              <input id="signup-email" type="email" class="validate">
              <label for="signup-email">E-mail</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="signup-password" type="password" class="validate">
              <label for="signup-password">Senha</label>
            </div>
          </div>
          <div class="row">
            <button class="btn waves-effect waves-light" type="submit" name="action">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var modals = document.querySelectorAll('.modal');
      M.Modal.init(modals);
    });
  </script>
</body>
</html>
