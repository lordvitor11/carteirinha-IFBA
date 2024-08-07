<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/comunicados-admin.css">
    <title>Gerenciamento de Comunicados</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>Gerenciamento de Comunicados</h1><br>

        <div class="comunicados">
            <table>
                <thead>
                    <tr>
                        <th>Data Publicação</th>
                        <th>Título</th>
                        <th>Link</th>
                        <th>Ações</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $jsonStringOrigem = file_get_contents('process/dados.json');
                        $arrayDados = json_decode($jsonStringOrigem, true);

                        foreach ($arrayDados as $item) {
                            echo "<tr>
                            <td>{$item['data_publicacao']}</td>
                            <td>{$item['titulo']}</td>
                            <td>{$item['link']}</td>
                            <td>
                                <button onclick='editarCardapio()'>Editar</button>
                                <button onclick='excluirCardapio()'>Excluir</button>
                            </td>
                            <td><input type='checkbox' name='selecao' value='1'></td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>

            <div class="botoes-admin">
                <a href="comunicado-criar.php" class="botao-adicionar">Adicionar Comunicados</a>
                <button onclick="limparSelecao()">Limpar Seleção</button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
