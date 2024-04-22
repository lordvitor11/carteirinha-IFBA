<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editar-horario.css">
    <title>Editar Horário</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>EDITAR HORÁRIO</h1>

        <form action="processar_horario.php" method="POST">
            <label for="data">Data:</label>
            <input type="date" id="data" name="data">
            <br>
            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora">
            <br>
            <div class="botao-container">
                <a href='painel-administrador.php'><button class="cancelar" type="button">
                    <img src="../assets/cancelar-100px.png" alt="Cancelar">
                </button></a>

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
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>