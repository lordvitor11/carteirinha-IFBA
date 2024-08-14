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

    <div class="overlay" id="overlay"></div>
    <div class="popup" id="popup">
        <h2>Reserva Confirmada!</h2>
        <p>Sua reserva foi confirmada com sucesso.</p>
        <!-- Campo de Feedback -->
        <div class="feedback-container">
            <h3>Deixe seu feedback:</h3>
            <textarea id="feedback" name="feedback" rows="4" placeholder="Digite seu feedback aqui..."></textarea>
            <button id="btn-submit-feedback">Enviar Feedback</button>
        </div>
        <button class="close" onclick="closePopup()">Fechar</button>
    </div>

    <script>
        function getParameterByName(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        function showPopup() {
            const reserva = getParameterByName('reserva');
            if (reserva === 'confirmada') {
                document.getElementById('popup').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            }
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        document.getElementById('btn-submit-feedback').addEventListener('click', function() {
            const feedback = document.getElementById('feedback').value.trim();
            
            if (feedback === '') {
                alert('Por favor, digite seu feedback.');
                return;
            }
            
            console.log('Feedback enviado:', feedback);

            // Aqui você pode adicionar código para enviar o feedback para o servidor

            // Fechar o pop-up após o envio
            closePopup();

            // Limpar o campo de feedback após o envio
            document.getElementById('feedback').value = '';
        });

        // Exibe o pop-up se o parâmetro estiver presente
        showPopup();
    </script>
    </script>
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
                // echo "<a href='agendados.php'><button class='button-agendados'>Minha Reserva</button></a>";
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
                $current_day = date("Y-m-d");

                $horario_padrao = $controller->getTime();
                $idUser = $_SESSION['user'];
                $sql = "SELECT id FROM usuario WHERE nome = '$idUser'";
                $result = $conn->query($sql);
                $row = mysqli_fetch_array($result);
                $idUser = $row[0];

                if ($controller->hasRefeicao($idUser, $current_day)) {
                    echo "<a href='agendados.php'><button class='button-agendados'>Minha Reserva</button></a>";
                } else if ($current_time >= $horario_padrao) {
                    echo "<span class='horario-limite'>Horário limite atingido!</span>";
                } else if ($current_time < $horario_padrao) {
                    echo "<a href='cardapio-reserva.php'><button class='button'>Quero almoçar!</button></a>";
                } 
            } else if ($_SESSION['category'] != "adm" && $cardapio[0] == null) {
                echo "<h3 class='null'>O cardápio ainda está vazio. Aguarde por atualizações.</h3>";
            }
        ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
