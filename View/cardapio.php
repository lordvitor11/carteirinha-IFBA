<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio.css">
    <title>Cardápio Semanal</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CARDÁPIO SEMANAL</h1>
        <img src="../assets/_a865d40c-77b6-4702-b2aa-50249d59935d-removebg-preview.png" alt="Imagem do Boneco" class="image2" draggable="false">
        <table>
            
            <?php 
                require("../Controller/controller.php");

                error_reporting(E_ALL);

                ini_set('display_errors', 1);

                $controller = new LoginController();

                $cardapio = $controller->getCardapio();

                

                if ($cardapio[0] != null) {
                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Prato Principal</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                            </tr>
                        </thead>
                        <tbody>";

                    foreach ($cardapio as $dia) {
                        $data = date("d/m", strtotime($dia['data'])); 
                        $newDia = ucfirst($dia['dia']) . "-feira";
                        echo "<tr>";
                        echo "<td>{$newDia} ({$data})</td>";
                        echo "<td>{$dia['principal']}</td>";
                        echo "<td>{$dia['acompanhamento']}</td>";
                        echo "<td>{$dia['sobremesa']}</td>";
                        echo "</tr>";
                        
                    }

                    echo "</tbody>";
                    echo "</table>";
                }

                
            ?>
            </tbody> 
        </table>

        <?php 
            if ($_SESSION['category'] == "adm" && $cardapio[0] != null) {
                echo "<a href='cardapio-admin.php'><button class='editar'>Editar cardápio</button></a>"; 
            } else if ($_SESSION['category'] == "adm" && $cardapio[0] == null) {
                echo "<h3 class='null'>O cardápio ainda está vazio. Adicione um agora</h3>";
                echo "<a href='cardapio-admin.php'><button class='editar'>Adicionar cardápio</button></a>"; 
            } else if ($_SESSION['category'] != "adm" && $cardapio[0] != null) {
                date_default_timezone_set('America/Sao_Paulo');
                $current_time = date("H");

                if (intval($current_time) >= 9) {
                    echo "<span class='horario-limite'>Horário limite atingido!</span>";
                } else {
                    echo "<a href=''><button class='editar'>Quero almoçar!</button></a>";
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
    <script src="script.js"></script>
</body>
</html>
