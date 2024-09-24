<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/qr-code.css">
    <title>HISTÓRICO DE CARDÁPIOS</title>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="addListener();">
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="center">
        <h1>QR Code do Almoço</h1>
        <img src="../assets/qrcode-frame.png" alt="qr-code-almoço"> <br>
        <div class="buttons">
            <button>Imprimir</button>
            <button>Voltar</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
