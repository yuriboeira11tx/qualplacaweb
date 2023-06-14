<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</body>
</html>