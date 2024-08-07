<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cardapio-admin.css">
    <title>Administração de Cardápios</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>Cardápio Atual</h1><br>

        <div class="cardapios">
            <table>
                <thead>
                    <tr>
                        <th>Inicio</th>
                        <th>Fim</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        require("../Controller/controller.php");

                        $controller = new LoginController();

                        $cardapio = $controller->getCardapio();

                        if (sizeof($cardapio) > 0 && $cardapio[0] != null) {
                            $inicio_vig = date("d/m/Y", strtotime($cardapio[0]['data'])); 
                            $fim_vig = date("d/m/Y", strtotime($cardapio[sizeof($cardapio) - 1]['data']));

                            echo "
                            <tr>
                                <td>$inicio_vig</td>
                                <td>$fim_vig</td>
                                <td>
                                    <a href='cardapio-alterar.php'><button onclick='editarCardapio()'>Editar</button>
                                    <button onclick='excluirCardapio()'>Excluir</button>
                                </td>
                            </tr>";
                        } else {
                            echo "
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Cardápio não existente no momento!</td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>

            <div class="botoes-admin">
                <a href="cardapio-criar.php" class="botao-adicionar">Adicionar Cardápio</a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
