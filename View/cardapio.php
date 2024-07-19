<?php
    require("../Controller/controller.php");
    $controller = new LoginController();

    if (isset($_POST['sinal'])) {
        $sinal = $_POST['sinal'];
        $controller->deleteCardapio();             
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio.css">
    <title>Cardápio Semanal</title>
</head>
<body>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            echo "<div class='popup-index'>";
            echo "<script>showIndexPopup();</script>";
            
            if ($id == 0) {
                echo "<h2 class='popup-index-title'>Cardápio alterado!</h2>";
            } else {
                echo "<h2 class='popup-index-title'>Erro ao alterar cardápio!</h2>";
            }

            echo "</div>";
        }
    ?>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <?php
            if ($_SESSION['logged_in'] && $_SESSION['category'] != 'adm') {
                echo "<a href='agendados.php'><button class='button-agendados'>Minhas Reservas</button></a>";
            }
        ?>
        
        <h1>CARDÁPIO SEMANAL</h1>
        <img src="../assets/_a865d40c-77b6-4702-b2aa-50249d59935d-removebg-preview.png" alt="Imagem do Boneco" class="image2" draggable="false">
        <table>
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $cardapio = $controller->getCardapio();             

                if ($cardapio[0] != null) {
                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                            </tr>
                        </thead>
                        <tbody>";

                    foreach ($cardapio as $dia) {
                        if ($dia['principal'] != 'Sem refeição') {
                            $data = date("d/m", strtotime($dia['data'])); 
                            $newDia = ucfirst($dia['dia']) . "-feira";
                            echo "<tr>";
                            echo "<td>$newDia ($data)</td>";
                        } else {
                            echo "<tr>";
                            echo "<td>{$dia['dia']}</td>";
                        }
                        echo "<td>{$dia['principal']}</td>";
                        echo "<td>{$dia['acompanhamento']}</td>";
                        echo "<td>{$dia['sobremesa']}</td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }
            ?>
        </table>

        <?php 
            if ($_SESSION['category'] == "adm" && $cardapio[0] != null) {
                echo "<div class='separador'>";
                echo "<div class='button-group'>";
                echo "<button class='button excluir' onclick='cardapio_popup()'>Excluir</button>";
                echo "<a href='cardapio-alterar.php'><button class='button editar'>Editar</button></a>";
                echo "</div>";
                echo "</div>";
            } else if ($_SESSION['category'] == "adm" && $cardapio[0] == null) {
                echo "<h3 class='null'>O cardápio ainda está vazio. Adicione um agora</h3>";
                echo "<a href='cardapio-criar.php'><button class='button'>Adicionar cardápio</button></a>"; 
            } else if ($_SESSION['category'] != "adm" && $cardapio[0] != null) {
                date_default_timezone_set('America/Sao_Paulo');
                $current_time = date("H:m:s");

                $horario_padrao = $controller->getTime();

                if ($current_time > $horario_padrao) {
                    echo "<span class='horario-limite'>Horário limite atingido!</span>";
                } else {
                    echo "<a href='cardapio-reserva.php'><button class='button'>Quero almoçar!</button></a>";
                }
            } else if ($_SESSION['category'] != "adm" && $cardapio[0] == null) {
                echo "<h3 class='null'>O cardápio ainda está vazio. Aguarde por atualizações.</h3>";
            }
        ?>
    </div>

    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
</body>
</html>
