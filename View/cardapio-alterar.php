<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        require("../Controller/controller.php");
        $controller = new LoginController();

        $cardapio = $controller->getCardapio();  

        echo json_encode($cardapio);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-alterar.css">
    <title>Cardápio ADMIN</title>
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
    <form action="process/process-edit.php" method="POST" id="cardapioForm">
        <div class="content"></div>
        <div class="botao-container">
            <button class="cancelar" type="button" onclick="cancelarCardapio()"></button>

            <input class="validar" type="submit" value="">
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
    function showFields(cardapio) {
        const component = document.querySelector('.content');

        for (let c = 0; c < cardapio.length; c++) {
            let divItem = document.createElement('div');
            let divPrincipal = document.createElement('div');
            let divAcompanhamento = document.createElement('div');
            let divSobremesa = document.createElement('div');

            // Content
            let labelPrincipal = document.createElement('label');
            let inputPrincipal = document.createElement('input');

            let labelAcompanhamento = document.createElement('label');
            let inputAcompanhamento = document.createElement('input');

            let labelSobremesa = document.createElement('label');
            let inputSobremesa = document.createElement('input');

            // Configuração dos componentes
            divItem.classList.add('dia-semana');

            // Proteína
            let data = `${cardapio[c]['data'][8]}${cardapio[c]['data'][9]}/${cardapio[c]['data'][5]}${cardapio[c]['data'][6]}`;
            labelPrincipal.setAttribute('id', cardapio[c]['dia']);
            labelPrincipal.setAttribute('name', cardapio[c]['dia']);
            labelPrincipal.textContent = cardapio[c]['dia'].charAt(0).toUpperCase() + cardapio[c]['dia'].slice(1).toLowerCase() + `-feira(${data})` ;

            inputPrincipal.setAttribute('type', 'text');
            inputPrincipal.setAttribute('id', cardapio[c]['dia']);
            inputPrincipal.setAttribute('name', cardapio[c]['dia']);
            inputPrincipal.setAttribute('placeholder', 'Proteína');
            inputPrincipal.required = true;
            inputPrincipal.value = cardapio[c]['principal'];

            // Acompanhamento
            labelAcompanhamento.setAttribute('id', 'acompanhamento-' + cardapio[c]['dia']);
            labelAcompanhamento.setAttribute('name', 'acompanhamento-' + cardapio[c]['dia']);
            labelAcompanhamento.textContent = "‎ ";

            inputAcompanhamento.setAttribute('id', 'acompanhamento-' + cardapio[c]['dia']);
            inputAcompanhamento.setAttribute('name', 'acompanhamento-' + cardapio[c]['dia']);
            inputAcompanhamento.setAttribute('placeholder', 'Acompanhamento');
            inputAcompanhamento.value = cardapio[c]['acompanhamento'];



            // Sobremesa
            labelSobremesa.setAttribute('id', 'sobremesa-' + cardapio[c]['dia']);
            labelSobremesa.setAttribute('name', 'sobremesa-' + cardapio[c]['dia']);
            labelSobremesa.textContent = "‎ ";

            inputSobremesa.setAttribute('id', 'sobremesa-' + cardapio[c]['dia']);
            inputSobremesa.setAttribute('name', 'sobremesa-' + cardapio[c]['dia']);
            inputSobremesa.setAttribute('placeholder', 'Sobremesa');
            inputSobremesa.value = cardapio[c]['sobremesa'];

            // Adicionando os componentes
            divPrincipal.appendChild(labelPrincipal);
            divPrincipal.appendChild(inputPrincipal);

            divAcompanhamento.appendChild(labelAcompanhamento);
            divAcompanhamento.appendChild(inputAcompanhamento);

            divSobremesa.appendChild(labelSobremesa);
            divSobremesa.appendChild(inputSobremesa);

            divItem.appendChild(divPrincipal);
            divItem.appendChild(divAcompanhamento);
            divItem.appendChild(divSobremesa);

            component.appendChild(divItem);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        $.ajax({
            url: "cardapio-alterar.php",
            type: "POST",
            dataType: "json",
            success: function (response) {
                console.log(response);
                showFields(response);
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição: " + error);
            }
        });
    });
</script>
</body>
</html>