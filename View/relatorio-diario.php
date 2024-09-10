<?php 
    require("../Controller/controller.php");
    $controller = new LoginController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);

        $tipo = isset($data['tipo']) ? $data['tipo'] : '';
        $string = isset($data['string']) ? $data['string'] : '';
        // echo json_encode(['tipo' => $tipo]);
        // $nome = $controller->findName($tipo, $string);
        echo json_encode($nome);
        exit;

        // echo json_encode(['status' => 'success', 'nome' => $nome]);
    }
            
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/relatorio-diario.css">
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
        <h1 class="titulo">RELATÓRIO DE RESERVAS DIÁRIO</h1>

        <div class="center">
            <div class="input-container">
                <input type="text" id="buscador" placeholder="Digite o nome ou matrícula...">
                <button onclick="search()">Buscar</button>
            </div>
        </div>

        <table id="resultado">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"> Selecionar Todos</th>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Data</th>
                    <th>Hora</th>
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
