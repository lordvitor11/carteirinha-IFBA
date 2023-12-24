<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cardapio-criar.css">
    <title>Cardápio ADMIN</title>
</head>
<body>
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
                    <input type="text" id="segunda" name="segunda" required>
                </div>
                <div>
                    <label for="acompanhamento-segunda">Acompanhamento:</label>
                    <input type="text" id="acompanhamento-segunda" name="acompanhamento-segunda">
                </div>
                <div>
                    <label for="sobremesa-segunda">Sobremesa:</label>
                    <input type="text" id="sobremesa-segunda" name="sobremesa-segunda">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="terca">Terça-feira:</label>
                    <input type="text" id="terca" name="terca" required>
                </div>
                <div>
                    <label for="acompanhamento-terca">Acompanhamento:</label>
                    <input type="text" id="acompanhamento-terca" name="acompanhamento-terca">
                </div>
                <div>
                    <label for="sobremesa-terca">Sobremesa:</label>
                    <input type="text" id="sobremesa-terca" name="sobremesa-terca">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="quarta">Quarta-feira:</label>
                    <input type="text" id="quarta" name="quarta" required>
                </div>
                <div>
                    <label for="acompanhamento-quarta">Acompanhamento:</label>
                    <input type="text" id="acompanhamento-quarta" name="acompanhamento-quarta">
                </div>
                <div>
                    <label for="sobremesa-quarta">Sobremesa:</label>
                    <input type="text" id="sobremesa-quarta" name="sobremesa-quarta">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="quinta">Quinta-feira:</label>
                    <input type="text" id="quinta" name="quinta" required>
                </div>
                <div>
                    <label for="acompanhamento-quinta">Acompanhamento:</label>
                    <input type="text" id="acompanhamento-quinta" name="acompanhamento-quinta">
                </div>
                <div>
                    <label for="sobremesa-quinta">Sobremesa:</label>
                    <input type="text" id="sobremesa-quinta" name="sobremesa-quinta">
                </div>
            </div>

            <div class="dia-semana">
                <div>
                    <label for="sexta">Sexta-feira:</label>
                    <input type="text" id="sexta" name="sexta" required>
                </div>
                <div>
                    <label for="acompanhamento-sexta">Acompanhamento:</label>
                    <input type="text" id="acompanhamento-sexta" name="acompanhamento-sexta">
                </div>
                <div>
                    <label for="sobremesa-sexta">Sobremesa:</label>
                    <input type="text" id="sobremesa-sexta" name="sobremesa-sexta">
                </div>
            </div>

            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()">Cancelar Cardápio</button>
                <input type="submit" value="Validar Cardápio">
            </div>
        </form>
    </div>

    <footer>
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>