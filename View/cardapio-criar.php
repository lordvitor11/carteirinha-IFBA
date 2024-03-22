<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-criar.css">
    <title>Cardápio ADMIN</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CRIAR CARDÁPIO</h1>
        <form action="process/process-cardapio.php" method="POST" id="cardapioForm">
            <label for="data-inicio">Data inicío:</label>
            <input type="date" id="data-inicio" name="data-inicio" required>

            <label for="data-fim">Data fim:</label>
            <input type="date" id="data-fim" name="data-fim" required>

            <div class="dia-semana">
                <div>
                    <label for="segunda">Segunda-feira:</label>
                    <input type="text" id="segunda" name="segunda" required placeholder="Proteína">
                </div>
                <div>
                    <label for="acompanhamento-segunda">‎ </label>
                    <input type="text" id="acompanhamento-segunda" name="acompanhamento-segunda" placeholder="Acompanhamento">
                </div>
                <div>
                    <label for="sobremesa-segunda">‎ </label>
                    <input type="text" id="sobremesa-segunda" name="sobremesa-segunda" placeholder="Sobremesa">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="terca">Terça-feira:</label>
                    <input type="text" id="terca" name="terca" required required placeholder="Proteína">
                </div>
                <div>
                    <label for="acompanhamento-terca">‎ </label>
                    <input type="text" id="acompanhamento-terca" name="acompanhamento-terca" placeholder="Acompanhamento">
                </div>
                <div>
                    <label for="sobremesa-terca">‎ </label>
                    <input type="text" id="sobremesa-terca" name="sobremesa-terca" placeholder="Sobremesa">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="quarta">Quarta-feira:</label>
                    <input type="text" id="quarta" name="quarta" required required placeholder="Proteína">
                </div>
                <div>
                    <label for="acompanhamento-quarta">‎ </label>
                    <input type="text" id="acompanhamento-quarta" name="acompanhamento-quarta" placeholder="Acompanhamento">
                </div>
                <div>
                    <label for="sobremesa-quarta">‎ </label>
                    <input type="text" id="sobremesa-quarta" name="sobremesa-quarta" placeholder="Sobremesa">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="quinta">Quinta-feira:</label>
                    <input type="text" id="quinta" name="quinta" required required placeholder="Proteína">
                </div>
                <div>
                    <label for="acompanhamento-quinta">‎ </label>
                    <input type="text" id="acompanhamento-quinta" name="acompanhamento-quinta" placeholder="Acompanhamento">
                </div>
                <div>
                    <label for="sobremesa-quinta">‎ </label>
                    <input type="text" id="sobremesa-quinta" name="sobremesa-quinta" placeholder="Sobremesa">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="sexta">Sexta-feira:</label>
                    <input type="text" id="sexta" name="sexta" required required placeholder="Proteína">
                </div>
                <div>
                    <label for="acompanhamento-sexta">‎ </label>
                    <input type="text" id="acompanhamento-sexta" name="acompanhamento-sexta" placeholder="Acompanhamento">
                </div>
                <div>
                    <label for="sobremesa-sexta">‎ </label>
                    <input type="text" id="sobremesa-sexta" name="sobremesa-sexta" placeholder="Sobremesa">
                </div>
            </div>

            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()">
                    <img src="../assets/cancelar-100px.png" alt="Cancelar">
                </button>

                <button class="validar" type="submit">
                    <img src="../assets/validar-100px.png" alt="Alterar">
                </button>
            </div>
        </form>
    </div>

    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>