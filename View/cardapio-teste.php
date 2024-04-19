<?php
// Verifica se a requisição AJAX foi enviada
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
    <form action="process/process-cardapio.php" method="POST" id="cardapioForm">
        <div class="content"></div>
        <label for="date">Adicionar dia:</label>
        <input type="date" name="date" id="data" min='2024-04-08' max='2024-04-12'>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $.ajax({
            url: "cardapio-teste.php",
            type: "POST", 
            dataType: "json", 
            success: function(response) {
                let cardapioSemDataVazia = response.filter(function(item) {
                    return item.data !== ''; // Retorna verdadeiro apenas para os itens com data não vazia
                });

                console.log(response);

                let inputDate = document.getElementById('data');
                let datasDesabilitadas = [];
                let diasDaSemana = [];

                for (const item of cardapioSemDataVazia) {
                    datasDesabilitadas.push(item['data']);
                    diasDaSemana.push(item['dia']);
                }



                inputDate.addEventListener('input', function() {
                    let dataSelecionada = new Date(inputDate.value);
                    let dataISO = dataSelecionada.toISOString().split('T')[0];
                    
                    if (datasDesabilitadas.includes(dataISO)) {
                        inputDate.value = '';
                        alert('Este dia já está selecionado. Por favor, selecione outra data.');
                    } else {
                        let data = new Date(dataSelecionada); // Exemplo: '2024-04-09' representa 9 de abril de 2024

                        // Obter o dia da semana como um número (0 para Domingo, 1 para Segunda-feira, ..., 6 para Sábado)
                        let diaSemanaNumero = data.getDay();

                        let dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
                        
                        if (diasDaSemana.includes(dias[diaSemanaNumero])) { return; }

                        diasDaSemana.push(dias[diaSemanaNumero]);
  
                        let diasIndex = {
                        "segunda": 1,
                        "terca": 2,
                        "quarta": 3,
                        "quinta": 4,
                        "sexta": 5
                        };


                        // Função de comparação para o método sort()
                        function compararDias(a, b) {
                            return diasIndex[a] - diasIndex[b];
                        }

                        // Ordenar a lista de acordo com os índices dos dias da semana
                        diasDaSemana.sort(compararDias);

                        

                        const component = document.querySelector('.content');

                        //
                        component.innerHTML = "";
                        for (const item of diasDaSemana) {
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
                            labelPrincipal.setAttribute('id', item);
                            labelPrincipal.setAttribute('name', item);
                            labelPrincipal.textContent = item.charAt(0).toUpperCase() + item.slice(1).toLowerCase() + '-feira';

                            inputPrincipal.setAttribute('id', item);
                            inputPrincipal.setAttribute('name', item);
                            inputPrincipal.setAttribute('placeholder', 'Proteína');
                            inputPrincipal.required = true;

                            // Acompanhamento
                            labelAcompanhamento.setAttribute('id', 'acompanhamento-' + item);
                            labelAcompanhamento.setAttribute('name', 'acompanhamento-' + item);
                            labelAcompanhamento.textContent = "‎ ";

                            inputAcompanhamento.setAttribute('id', 'acompanhamento-' + item);
                            inputAcompanhamento.setAttribute('name', 'acompanhamento-' + item);
                            inputAcompanhamento.setAttribute('placeholder', 'Acompanhamento');

                            // Sobremesa
                            labelSobremesa.setAttribute('id', 'sobremesa-' + item);
                            labelSobremesa.setAttribute('name', 'sobremesa-' + item);
                            labelSobremesa.textContent = "‎ ";

                            inputSobremesa.setAttribute('id', 'sobremesa-' + item);
                            inputSobremesa.setAttribute('name', 'sobremesa-' + item);
                            inputSobremesa.setAttribute('placeholder', 'Sobremesa');

                            // Adição dos componentes aos componetes pais
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
                });
            },
            error: function(xhr, status, error) {
                console.error("Erro na requisição: " + error);
            }
        }); 
    });
</script>
</body>
</html>