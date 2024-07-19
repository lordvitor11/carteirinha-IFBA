<?php
    require("../Controller/controller.php");
    $controller = new LoginController();

    $cardapio = $controller->getCardapio();

    $dataAtual = date('Y-m-d'); // Pode ser qualquer data no formato Y-M-D (por exemplo, '2021-12-08')
    $diaDaSemana = date('l', strtotime($dataAtual));
    $diaNumero = 0;

    switch ($diaDaSemana) {
        case "Monday": $diaDaSemana = "segunda"; break;
        case "Tuesday": $diaDaSemana = "terca"; $diaNumero = 1; break;
        case "Wednesday": $diaDaSemana = "quarta"; $diaNumero = 2; break;
        case "Thursday": $diaDaSemana = "quinta"; $diaNumero = 3; break;
        case "Friday": $diaDaSemana = "sexta"; $diaNumero = 4; break;
        default: break;
    }

    $cardapio = $cardapio[$diaNumero];

    $_SESSION['diaSemana'] = $diaDaSemana;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-reserva.css">
    <title>Justificar Almoço</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
    <h1>RESERVAR ALMOÇO</h1>

    <form action="process/process-justificativa.php" method="POST">
        <table>
            <tr><th colspan="2"><?php echo ucfirst($diaDaSemana) . '-feira' ?></th></tr>
            <tr><td>Proteina</td><td><?php echo $cardapio['principal']; ?></td></tr>
            <tr><td>Acompanhamento</td><td><?php echo $cardapio['acompanhamento']; ?></td></tr>
            <tr><td>Sobremesa</td><td><?php echo $cardapio['sobremesa']; ?></td></tr>
        </table>

        <label for="justificativa">Justificativa:</label>
        <select id="justificativa" name="justificativa" onchange="toggleOutroMotivo()" required>
            <option value="" selected disabled hidden>Selecione uma opção...</option>
            <option value="contra-turno">Aula no Contra Turno</option>
            <option value="transporte">Transporte</option>
            <option value="projeto">Projeto, TCC</option>
            <option value="outro">Outro</option>
        </select>
        <br>
        <label for="outro">Outro Motivo:</label>
        <input type="text" id="outro" name="outro" placeholder="Digite outro motivo..." disabled required>
        <br>
        <div class="botao-container">
            <button class="cancelar" type="button" onclick="cancelarCardapio()"></button>
            <button class="validar" type="submit"></button>
        </div>
    </form>
</div>


    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
    <script>
        function toggleOutroMotivo() {
            let select = document.getElementById("justificativa");
            let outroMotivo = document.getElementById("outro");

            outroMotivo.disabled = select.value !== "outro";
        }
    </script>
</body>
</html>