<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/perfil.css">
    <title>HISTÓRICO DE CARDÁPIOS</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>
    <?php
    // Defina o URL de logout
    $logout = "../logout.php";

    // Agora você pode usar a variável $logout
    echo '<div class="container">';
    echo '<form action="' . $logout . '" method="post">';
    echo '<button type="submit">Sair</button>';
    echo '</form>';
    echo '</div>';
    ?>


    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>