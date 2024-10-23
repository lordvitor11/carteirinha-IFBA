<?php
    if (isset($_GET['data'])) {
        $data_usuario = $_GET['data'];
        try {
            $data = new DateTime($data_usuario);
            $primeiro_dia_semana = 0;
            $ultimo_dia_semana = 6;
            $dia_semana = $data->format("w");
            $primeiro_dia_timestamp = strtotime("-" . ($dia_semana - $primeiro_dia_semana) . " days", $data->getTimestamp());
            $ultimo_dia_timestamp = strtotime("+" . ($ultimo_dia_semana - $dia_semana) . " days", $data->getTimestamp());
            $dias_semana = array();

            for ($i = $primeiro_dia_timestamp; $i <= $ultimo_dia_timestamp; $i = strtotime('+1 day', $i)) {
                $dias_semana[] = date("Y-m-d", $i);
            }

            array_shift($dias_semana);
            array_pop($dias_semana);

            echo json_encode($dias_semana);
            exit;
        } catch (Exception $e) {
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-criar.css">
    <title>Cardápio ADMIN</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CRIAR CARDÁPIO</h1>
        <form action="process/process-cardapio.php" method="POST" id="cardapioForm">
            <div>
                <label for="data-inicio">Data inicío:</label>
                <input type="date" id="data-inicio" name="data-inicio" required>
            </div>
            <div>
                <label for="data-fim">Data fim:</label>
                <input type="date" id="data-fim" name="data-fim" required>
            </div>
            <div class="content"></div>
            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()"></button>

                <button class="validar" type="submit"></button>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function obterDiasSemana(data_usuario) {
            let data = new Date(data_usuario);
            let primeiro_dia_semana = 0; // Domingo
            let ultimo_dia_semana = 6; // Sábado
            let dia_semana = data.getDay();
            let primeiro_dia_timestamp;
            let ultimo_dia_timestamp;
            let inputDate = document.querySelector('#data-fim');

            if (dia_semana === 6) {
                dia_semana = 0;
                primeiro_dia_timestamp = new Date(data.getTime() - (dia_semana - primeiro_dia_semana) * 24 * 60 * 60 * 1000);
                ultimo_dia_timestamp = new Date(data.getTime() + (ultimo_dia_semana - dia_semana) * 24 * 60 * 60 * 1000);
            } else {
                primeiro_dia_timestamp = new Date(data.getTime() - (dia_semana - primeiro_dia_semana) * 24 * 60 * 60 * 1000 - 1);
                ultimo_dia_timestamp = new Date(data.getTime() + (ultimo_dia_semana - dia_semana) * 24 * 60 * 60 * 1000);
            }

            let dias_semana = [];

            for (let i = primeiro_dia_timestamp; i <= ultimo_dia_timestamp; i.setDate(i.getDate() + 1)) {
                dias_semana.push(i.toISOString().slice(0, 10));
            }

            dias_semana.shift();
            dias_semana.pop();

            let min = dias_semana[0];
            let max = dias_semana[dias_semana.length - 1];

            inputDate.setAttribute("min", min);
            inputDate.setAttribute("max", max);
        }

        let input = document.querySelector('#data-inicio');
        let inputF = document.querySelector('#data-fim');
        input.addEventListener('input', function() {
            document.querySelector('.content').innerHTML = "";
            inputF.value = "";
            obterDiasSemana(input.value);
        });

        inputF.addEventListener('input', function() {
            addFields();
        });
    </script>
</body>
</html>