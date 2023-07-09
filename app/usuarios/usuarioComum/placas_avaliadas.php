<!DOCTYPE html>
<html>

<head>
    <title>Placas Avaliadas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
        }
        
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top: 120px;
        }

        .card-img-top {
            height: 200px;
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
                    <a class="nav-link" href="home.php">Buscar Placas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favoritos.php">Favoritadas</a>
                </li>
            </ul>
        </div>
    </nav> 

    <div class="container">
        <h2>Placas Avaliadas</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="path_to_image" class="card-img-top" alt="Placa de vídeo 1">
                    <div class="card-body">
                        <h5 class="card-title">Placa de Vídeo 1</h5>
                        <p class="card-text">Descrição da Placa de Vídeo 1</p>
                        <a href="#" class="btn btn-primary">Ver mais</a>
                        <span class="favorite-icon"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path_to_image" class="card-img-top" alt="Placa de vídeo 2">
                    <div class="card-body">
                        <h5 class="card-title">Placa de Vídeo 2</h5>
                        <p class="card-text">Descrição da Placa de Vídeo 2</p>
                        <a href="#" class="btn btn-primary">Ver mais</a>
                        <span class="favorite-icon"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="path_to_image" class="card-img-top" alt="Placa de vídeo 3">
                    <div class="card-body">
                        <h5 class="card-title">Placa de Vídeo 3</h5>
                        <p class="card-text">Descrição da Placa de Vídeo 3</p>
                        <a href="#" class="btn btn-primary">Ver mais</a>
                        <span class="favorite-icon"><i class="fas fa-heart"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>