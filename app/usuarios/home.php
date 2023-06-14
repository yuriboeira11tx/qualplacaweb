<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
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
        <form>
            <div class="form-group">
                <label for="precoMaximo">Preço máximo:</label>
                <input type="number" class="form-control" id="precoMaximo" placeholder="R$">
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <select class="form-control" id="marca">
                    <option value="">Selecione a marca</option>
                    <option value="ASUS">ASUS</option>
                    <option value="Gigabyte">Gigabyte</option>
                    <option value="MSI">MSI</option>
                    <option value="EVGA">EVGA</option>
                    <option value="Zotac">Zotac</option>
                    <option value="Palit">Palit</option>
                    <option value="Sapphire">Sapphire</option>
                    <option value="Galax">Galax</option>
                    <option value="Palit">Palit</option>
                    <option value="Outra">Outra</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fabricante-chip">Fabricante do Chip:</label>
                <select class="form-control" id="fabricante-chip">
                    <option value="">Selecione o fabricante</option>
                    <option value="Nvidia">Nvidia</option>
                    <option value="AMD">AMD</option>
                    <option value="Intel">Intel</option>
                    <option value="Outro">Outra</option>   
                </select>
            </div>


            <div class="form-group">
                <label for="memoria-vram">Memória VRAM:</label>
                <input type="text" class="form-control" id="memoria-vram" placeholder="Ex: 4gbs">
            </div>

            <div class="form-group">
                <label for="clock">Clock:</label>
                <input type="text" class="form-control" id="clock" placeholder="Ex: 30mhz">
            </div>

            <div class="form-group">
                <label for="utilidade-funcional">Utilidade Funcional:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="utilidade-streaming" value="streaming">
                    <label class="form-check-label" for="utilidade-streaming">
                        Streaming
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="utilidade-computacao" value="computacao">
                    <label class="form-check-label" for="utilidade-computacao">
                        Computação de Alto Desempenho
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="utilidade-mineracao" value="mineracao">
                    <label class="form-check-label" for="utilidade-mineracao">
                        Mineração de Criptomoedas
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="utilidade-edicao-video" value="edicao-video">
                    <label class="form-check-label" for="utilidade-edicao-video">
                        Edição de Vídeo e Design Gráfico
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="utilidade-jogos" value="jogos">
                    <label class="form-check-label" for="utilidade-jogos">
                        Jogos
                    </label>
                </div>
            </div>


            <div class="form-group">
                <label for="consumo">Consumo:</label>
                <input type="text" class="form-control" id="consumo" placeholder="Informe o consumo em Watts">
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


            <button type="submit" class="btn btn-primary">QUAL PLACA?</button>
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