<?php session_start();
    if (isset($_SESSION['category'])) {
        if ($_SESSION['category'] == "adm") {
            header("Location: View/painel-administrador.php");
            
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/css/style.css">
    <title>Início</title>
</head>
<body>
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src="View/script.js"></script>
    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            echo "<div class='popup-index'>";
            echo "<script>showIndexPopup();</script>";
            
            if ($id == 0) { echo "<h2 class='popup-index-title'>Horário limite alterado!</h2>"; }
            else { echo "<h2 class='popup-index-title'>Erro ao alterar horário!</h2>"; }
            echo "</div>";
        }
    ?>

    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("View/process/navbar.php"); showNav("landpage"); ?>

    

    <?php include 'View/footer.php'; ?>
</body>
</html>
