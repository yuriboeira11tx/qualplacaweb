<!DOCTYPE html>
<html>

<head>
    <title>Favoritos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
        }
        
        .card {
            width: 18rem;
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            font-size: 24px;
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
                    <a class="nav-link" href="home.php">Pagina Principal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="placas_avaliadas.php">Placas Avaliadas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="minhas_sugestoes.php">Minhas Sugestões</a>
                </li>
            </ul>
        </div>
    </nav>  

    <div class="container">
        <h2>Favoritos</h2>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <img src="placa1.jpg" class="card-img-top" alt="Placa 1">
                    <div class="card-body">
                        <h5 class="card-title">Placa 1</h5>
                        <p class="card-text">Descrição da Placa 1</p>
                        <i class="favorite-icon fas fa-heart"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <img src="placa2.jpg" class="card-img-top" alt="Placa 2">
                    <div class="card-body">
                        <h5 class="card-title">Placa 2</h5>
                        <p class="card-text">Descrição da Placa 2</p>
                        <i class="favorite-icon fas fa-heart"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <img src="placa3.jpg" class="card-img-top" alt="Placa 3">
                    <div class="card-body">
                        <h5 class="card-title">Placa 3</h5>
                        <p class="card-text">Descrição da Placa 3</p>
                        <i class="favorite-icon fas fa-heart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>