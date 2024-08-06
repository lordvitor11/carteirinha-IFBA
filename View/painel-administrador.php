<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/painel-administrador.css">
    <title>Painel Administrador</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>PAINEL ADMINISTRADOR</h1>

        <form method="POST">
            <a href='editar-horario.php'><button class="button" type="button">EDITAR HORÁRIO</button></a>
            <a href='historico.php'><button class="button blue" type="button">HISTÓRICO DE CARDÁPIOS</button></a>
            <a href='relatorio-diario.php'><button class="button blue" type="button">RELATÓRIO DIÁRIO</button></a>
            <a href='notificacoes.php'><button class="button blue" type="button">NOTIFICAÇÕES</button></a>
            <a href='cardapio.php'><button class="button" type="button">CARDAPIO</button></a>
        </form>
    </div>

    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>