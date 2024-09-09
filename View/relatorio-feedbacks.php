<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/relatorio-feedbacks.css">
    <title>RELATÓRIO DE RESERVAS DIÁRIO</title>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<header class="session-1">
    <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
        <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
    </a>
</header>

<?php include_once("process/navbar.php"); showNav("default"); ?>

<div class="center">
    <div class="container">
        <h1 class="titulo">RELATÓRIO DE FEEDBACKS</h1>

        <div class="input-container">
            <label for="data-inicio">Data Início:</label>
            <input type="date" id="data-inicio" name="data-inicio" required>

            <label for="data-fim">Data Fim:</label>
            <input type="date" id="data-fim" name="data-fim" required><br>

            <button id="buscar" class="button">Buscar</button>
        </div>

        <table id="resultado">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Mensagem</th>
                </tr>
            </thead>
            <tbody>
                <!-- Resultados serão inseridos aqui -->
            </tbody>
        </table>

        <div class="separador">
            <a href="painel-administrador.php"><button class='button-voltar'>Voltar</button></a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#btn-buscar').click(function() {
            const busca = $('#busca').val();
            $.post('relatorio-reservas.php', { busca: busca }, function(data) {
                const resultados = JSON.parse(data);
                const tbody = $('#resultado tbody');
                tbody.empty();

                resultados.forEach(item => {
                    const tr = `
                        <tr>
                            <td><input type="checkbox" name="select" value="${item.id}"></td>
                            <td>${item.nome}</td>
                            <td>${item.matricula}</td>
                            <td>${item.data}</td>
                            <td>${item.hora}</td>
                        </tr>
                    `;
                    tbody.append(tr);
                });
            });
        });

        $('#select-all').click(function() {
            const isChecked = $(this).prop('checked');
            $('input[name="select"]').prop('checked', isChecked);
        });
    });
</script>
</body>
</html>
