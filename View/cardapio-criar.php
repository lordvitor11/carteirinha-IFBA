<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        $data_usuario = $_POST['dataSelecionada'];
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
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CRIAR CARDÁPIO</h1>
        <form action="process/process-cardapio.php" method="POST" id="cardapioForm">
            <div>
                <label for="data-inicio">Data inicío:</label>
                <input type="date" id="data-inicio" name="data-inicio" oninput="addFields()" required>
            </div>
            <div>
                <label for="data-fim">Data fim:</label>
                <input type="date" id="data-fim" name="data-fim" required>
            </div>
            <div class="content"></div>
            <div class="botao-container">
                <button class="cancelar" type="button" onclick="cancelarCardapio()">
                    <img src="../assets/cancelar-100px.png" alt="Cancelar">
                </button>

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
          <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputDate = document.getElementById('data-inicio');
            inputDate.addEventListener('input', function() {
                $.ajax({
                    url: "cardapio-criar.php",
                    type: "POST", 
                    dataType: "json", 
                    data: { dataSelecionada: inputDate.value},
                    success: function(response) {
                        let inputDateF = document.getElementById('data-fim');
                        inputDateF.addEventListener('input', function() { 
                            let dataSelecionada = new Date(inputDateF.value);
                            let dataISO = dataSelecionada.toISOString().split('T')[0];
                            
                            if (response.includes(dataISO)) { addFields(); }
                            else {
                                inputDateF.value = '';
                                alert('Data inválida. Por favor, selecione outra data.');
                                document.querySelector('.content').innerHTML = "";
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro na requisição: " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>