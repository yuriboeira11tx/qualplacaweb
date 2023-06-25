<?php
    require_once 'C:\xampp\htdocs\qualplacaweb\app\conexao_database.php';

    if (isset($_COOKIE['usuario_logado'])) {
        $nomeUsuario = explode(",", $_COOKIE['usuario_logado'])[0];
        $tipoUsuario = explode(",", $_COOKIE['usuario_logado'])[1];
        if ($tipoUsuario != '1') {
            header('Location: usuarios/usuarioAdm/home.php');
            exit();
        }
    } else {
        header("Location: usuarios/deslogado.php");
        exit();
    }
    if (isset($_POST['btnBusca'])) {
        //Atribui valores para adicionar no cookie
        $precoMaximo = $_POST['precoMaximo'];
        $marca = $_POST['marca'];
        $fabricante = $_POST['fabricante'];
        $memoria = $_POST['memoria'];
        $clock = $_POST['clock'];
        if(isset($_POST['streaming'])){
            $streaming = $_POST['streaming'];
        }else{
            $streaming = 0;
        }
        if(isset($_POST['computacao'])){
            $computacao = $_POST['computacao'];
        }else{
            $computacao = 0;
        }
        if(isset($_POST['mineracao'])){
            $mineracao = $_POST['mineracao'];
        }else{
            $mineracao = 0;
        }
        if(isset($_POST['edicao'])){
            $edicao = $_POST['edicao'];
        }else{
            $edicao = 0;
        }
        if(isset($_POST['jogos'])){
            $jogos = $_POST['jogos'];
        }else{
            $jogos = 0;
        }
        $utilidades = $streaming + $computacao + $mineracao + $edicao + $jogos;                    
        $consumo = $_POST['consumo'];
        $estrelas;
        if($_POST['rating'] = 1){
            $estrelas = 1;
        }elseif($_POST['rating'] = 2){
            $estrelas = 2;
        }elseif($_POST['rating'] = 2){
            $estrelas = 3;
        }elseif($_POST['rating'] = 3){
            $estrelas = 4;
        }elseif($_POST['rating'] = 4){
            $estrelas = 5;
        }
        $busca = array(
            'precoMaximo' => $precoMaximo,
            'marca' => $marca,
            'fabricante' => $fabricante,
            'memoria' => $memoria,
            'clock' => $clock,
            'utilidades' => $utilidades,
            'consumo' => $consumo,
            'estrelas' => $estrelas
        ); 
        $buscaSerealizada = serialize($busca);
        setcookie('cookie_busca', $buscaSerealizada, $tempoExpiracao);
        header('Location: placasBuscadas.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>HomeUser</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 60px;
        }

        .rating {
            display: inline-block;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            float: right;
            cursor: pointer;
            color: #aaa;
        }

        .rating label:before {
            content: "\2606";
            /* Estrela vazia */
        }

        .rating input[type="radio"]:checked~label:before {
            content: "\2605";
            /* Estrela preenchida */
            color: #ff9800;
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
                    <a class="nav-link" href="favoritos.php">Favoritos</a>
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
        <h2>Seja bem-vindo(a) ao Qual Placa, um sistema web de recomendação de placas de vídeo que vai te ajudar a decidir a melhor opção de acordo com as suas necessidades!</h2>
        <form method="post">
            <div class="form-group">
                <label for="precoMaximo">Preço máximo:</label>
                <input type="number" class="form-control" name="precoMaximo" id="precoMaximo" placeholder="R$">
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <select class="form-control" name="marca" id="marca">
                    <option value="">Selecione a marca</option>
                    <option value="1">ASUS</option>
                    <option value="2">Gigabyte</option>
                    <option value="3">MSI</option>
                    <option value="4">EVGA</option>
                    <option value="5">Zotac</option>
                    <option value="6">Palit</option>
                    <option value="7">Sapphire</option>
                    <option value="8">Galax</option>
                    <option value="9">Colorful</option>
                    <option value="10">Outra</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fabricante-chip">Fabricante do Chip:</label>
                <select class="form-control" name="fabricante" id="fabricante-chip">
                    <option value="">Selecione o fabricante</option>
                    <option value="1">Nvidia</option>
                    <option value="2">AMD</option>
                    <option value="3">Intel</option>
                    <option value="4">Outra</option>   
                </select>
            </div>

            <div class="form-group">
                <label for="memoria-vram">Memória VRAM:</label>
                <input type="text" class="form-control" name="memoria" id="memoria-vram" placeholder="Ex: 4gbs">
            </div>

            <div class="form-group">
                <label for="clock">Clock:</label>
                <input type="text" class="form-control" name="clock" id="clock" placeholder="Ex: 30mhz">
            </div>

            <div class="form-group">
                <label for="utilidade-funcional">Utilidade Funcional:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="streaming" id="utilidade-streaming" value="1">
                    <label class="form-check-label" for="utilidade-streaming">
                        Streaming
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="computacao" id="utilidade-computacao" value="2">
                    <label class="form-check-label" for="utilidade-computacao">
                        Computação de Alto Desempenho
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="mineracao" id="utilidade-mineracao" value="4">
                    <label class="form-check-label" for="utilidade-mineracao">
                        Mineração de Criptomoedas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="edicao" id="utilidade-edicao-video" value="8">
                    <label class="form-check-label" for="utilidade-edicao-video">
                        Edição de Vídeos
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="jogos" id="utilidade-jogos" value="16">
                    <label class="form-check-label" for="utilidade-jogos">
                        Jogos
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="consumo">Consumo:</label>
                <input type="text" class="form-control" name="consumo" id="consumo" placeholder="Informe o consumo em Watts">
            </div>

            <div class="form-group">
                <p>Avaliação dos usuários:</p>
                <div class="rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5"></label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4"></label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3"></label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2"></label>
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1"></label>
                </div>
            </div>
            <button type="submit" name="btnBusca" class="btn btn-primary">QUAL PLACA?</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Adicionar manipulador de eventos para atualizar as estrelas selecionadas
        const ratingInputs = document.querySelectorAll('.rating input[type="radio"]');
        ratingInputs.forEach((input) => {
            input.addEventListener('change', updateRating);
        });

        // Função para atualizar as estrelas selecionadas
        function updateRating() {
            const selectedRating = this.value;
            console.log(`Avaliação: ${selectedRating}`);
        }
    </script>
</body>

</html>