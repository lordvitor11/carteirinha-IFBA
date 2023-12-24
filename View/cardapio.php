<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cardapio.css">
    <title>Cardápio Semanal</title>
</head>
<body>
    <?php include_once("navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CARDÁPIO SEMANAL</h1>
        <img src="../assets/_0454db25-be52-4019-98c8-a6837e90ff09-removebg-preview.png" alt="Imagem do Boneco" class="image2">
        <table>
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Prato Principal</th>
                    <th>Acompanhamento</th>
                    <th>Sobremesa</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    require("../Controller/controller.php");

                    $controller = new LoginController();

                    $cardapio = $controller->getCardapio();

                    foreach ($cardapio as $dia) {
                        $newDia = ucfirst($dia['dia']) . "-feira";
                        echo "<tr>";
                        echo "<td>{$newDia}</td>";
                        echo "<td>{$dia['principal']}</td>";
                        echo "<td>{$dia['acompanhamento']}</td>";
                        echo "<td>{$dia['sobremesa']}</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody> 

           
        </table>

        <?php if ($_SESSION['category'] == "adm") { echo "<a href='cardapio-admin.php'><button class='editar'>Editar cardápio</button></a>"; } ?>
    </div>

    <footer>
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
      </footer>
    <script src="script.js"></script>
</body>
</html>
