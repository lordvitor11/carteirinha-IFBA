<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-alterar.css">
    <title>ALTERAR CARDÁPIO</title>
</head>
<body>
<header class="session-1"> 
    <a href='https://portal.ifba.edu.br/seabra' target='_blank'> 
        <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> 
    </a> 
</header>

<?php include_once("process/navbar.php"); showNav("default"); ?>

<div class="container2">
    <h1>ALTERAR CARDÁPIO</h1>
    <form action="process/process-cardapio.php" method="POST" id="cardapioForm">
        <label for="data-inicio">Data Início:</label>
        <input type="date" id="data-inicio" name="data-inicio" required>

        <label for="data-fim">Data Fim:</label>
        <input type="date" id="data-fim" name="data-fim" required>

        <?php
        // Definir os dias da semana
        $dias_semana = array('Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira');

        // Loop para criar os campos para cada dia da semana
        foreach ($dias_semana as $dia) {
            echo "<div class='dia-semana'>";
            echo "<div>";
            echo "<label for='" . strtolower($dia) . "'>$dia:</label>";
            echo "<input type='text' id='" . strtolower($dia) . "' name='" . strtolower($dia) . "' placeholder='Proteína' required>";
            echo "</div>";
            echo "<div>";
            echo "<label for='acompanhamento-" . strtolower($dia) . "'>‎ </label>";
            echo "<input type='text' id='acompanhamento-" . strtolower($dia) . "' name='acompanhamento-" . strtolower($dia) . "' placeholder='Acompanhamento'>";
            echo "</div>";
            echo "<div>";
            echo "<label for='sobremesa-" . strtolower($dia) . "'>‎ </label>";
            echo "<input type='text' id='sobremesa-" . strtolower($dia) . "' name='sobremesa-" . strtolower($dia) . "' placeholder='Sobremesa'>";
            echo "</div>";
            echo "</div>";
        }
        ?>

        <div class="botao-container">
            <button class="cancelar" type="button" onclick="cancelarCardapio()">
                <img src="../assets/cancelar-100px.png" alt="Cancelar">
            </button>

            <button class="alterar" type="button" onclick="alterarCardapio()">
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
</body>
</html>