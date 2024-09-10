<?php
    if (isset($_POST['sinal'])) {
        require("../Controller/controller.php");
        $controller = new LoginController(); 
        $ids = json_decode($_POST['sinal']);
        $response = $controller->getRegistry($ids);

        echo json_encode($response);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/historico.css">
    <title>HISTÓRICO DE CARDÁPIOS</title>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="addListener();">
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>
    <?php
        require("../Controller/controller.php");
        $controller = new LoginController(); 
        $init = $controller->getHistorico();
        $historico = array();
        $qtdReg = ($controller->getCount() / 5) - 2;

        $historico[] = $init;

        for ($c = 0; $c <= $qtdReg; $c++) {
            $qtd = count($historico) - 1;
            $tempMenorId = ($historico[$qtd]['menorId']) - 1;
            $temp = $controller->getHistorico($tempMenorId);

            $historico[] = $temp;
        }
    ?>
    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="center">
        <div class="container">
            <h1 class="titulo">HISTÓRICO DE CARDÁPIO</h1>

            <div class="input-container">
                <label for="data-inicio">Data Início:</label>
                <input type="date" id="data-inicio" name="data-inicio" required>

                <label for="data-fim">Data Fim:</label>
                <input type="date" id="data-fim" name="data-fim" required><br>

                <button id="buscar" class="button">Buscar</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        for ($c = 0; $c < count($historico); $c++) {
                            $dataInicio = date("d/m/Y", strtotime($historico[$c]['datas'][4]));
                            $dataFim = date("d/m/Y", strtotime($historico[$c]['datas'][0]));
                            $ids = $historico[$c]['ids'];

                            echo "
                                <tr>
                                    <td>$dataInicio</td>
                                    <td>$dataFim</td>
                                    <td><button class='button historico $ids[0]$ids[1]$ids[2]$ids[3]$ids[4]'>Exibir detalhes</button></td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>

            <div class="separador">
                <a href="painel-administrador.php"><button class='button-voltar'>Voltar</button></a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <div class="popup-historico">
        <div class="popup-content">
            <table>
                <thead>
                    <h2 id="data">CARDÁPIO (22/04 - 26/04)</h2>
                    <tr>
                        <th>Data</th>
                        <th>Proteína</th>
                        <th>Acompanhamento</th>
                        <th>Sobremesa</th>
                    </tr>
                </thead>
                <tbody class="semana"></tbody>
            </table>
            <button class="btn-close">Fechar</button>
        </div>
    </div>
    <script>
        document.getElementById('buscar').addEventListener('click', function() {
            const dataInicio = document.getElementById('data-inicio').value;
            const dataFim = document.getElementById('data-fim').value;

            if (dataInicio && dataFim) {
                $.ajax({
                    url: window.location.href,
                    type: "POST",
                    data: {
                        sinal: JSON.stringify({ dataInicio: dataInicio, dataFim: dataFim })
                    },
                    success: function(response) {
                        const historicoFiltrado = JSON.parse(response);
                        const tbody = document.querySelector('tbody');
                        tbody.innerHTML = '';  // Limpar a tabela existente

                        historicoFiltrado.forEach(item => {
                            let dataInicio = new Date(item.datas[4]).toLocaleDateString('pt-BR');
                            let dataFim = new Date(item.datas[0]).toLocaleDateString('pt-BR');
                            let ids = item.ids.join('');

                            tbody.innerHTML += `
                                <tr>
                                    <td>${dataInicio}</td>
                                    <td>${dataFim}</td>
                                    <td><button class='button historico ${ids}'>Exibir detalhes</button></td>
                                </tr>
                            `;
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao buscar dados: " + error);
                    }
                });
            } else {
                alert("Por favor, selecione as datas de início e fim.");
            }
        });

        document.getElementById('filtro-busca').addEventListener('input', function() {
            const filtro = this.value.toLowerCase();
            const linhas = document.querySelectorAll('tbody tr');

            linhas.forEach(linha => {
                const textoLinha = linha.textContent.toLowerCase();
                linha.style.display = textoLinha.includes(filtro) ? '' : 'none';
            });
        });

        document.getElementsByClassName('btn-close')[0].addEventListener('click', function() {
            const div = document.querySelector('.popup-historico');
            div.classList.remove('show');
            div.classList.add('hide');

            setTimeout(() => {
                div.classList.remove('hide');
                div.style.opacity = "0";
            }, 350);
        });
    </script>
</body>
</html>
