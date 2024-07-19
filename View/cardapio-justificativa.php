<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-justificativa.css">
    <title>Justificar Almoço</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>JUSTIFICATIVA RESERVA</h1>

        <form action="processar_justificativa.php" method="POST">
            <label for="justificativa">Justificativa:</label>
            <select id="justificativa" name="justificativa" onchange="toggleOutroMotivo()">
                <option value="" selected disabled hidden>Selecione uma opção...</option>
                <option value="opcao1">Aula no Contra Turno</option>
                <option value="opcao2">Transporte</option>
                <option value="opcao3">Projeto, TCC</option>
                <option value="outro">Outro</option>
            </select>
            <br>
            <label for="outro">Outro Motivo:</label>
            <input type="text" id="outro" name="outro" placeholder="Digite outro motivo..." disabled>
            <br>
            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()"></button>
                <button class="validar" type="submit"></button>
            </div>
        </form>
    </div>


    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
    <script>
        function toggleOutroMotivo() {
            let select = document.getElementById("justificativa");
            let outroMotivo = document.getElementById("outro");

            outroMotivo.disabled = select.value !== "outro";
        }
    </script>
</body>
</html>