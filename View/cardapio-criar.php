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
            <div>
                <label for="data-inicio">Data inicío:</label>
                <input type="date" id="data-inicio" name="data-inicio" oninput="addFields()" required>
            </div>
            <div>
                <label for="data-fim">Data fim:</label>
                <input type="date" id="data-fim" name="data-fim" oninput="addFields()" required>
            </div>
            <div class="content"></div>
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