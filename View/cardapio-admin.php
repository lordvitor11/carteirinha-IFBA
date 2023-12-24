<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cardapio-admin.css">
    <title>Administração de Cardápios</title>
</head>
<body>
    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>Administração de Cardápios</h1><br>

        <div class="filtro-container">
            <h2>Filtrar</h2>
            <div class="filtro-campos">
                <label class="label-data" for="filtro-data-inicio">Data início:</label>
                <input type="date" id="filtro-data-inicio" placeholder="Filtrar por Data Início">

                <label class="label-data" for="filtro-data-fim">Data fim:</label>
                <input type="date" id="filtro-data-fim" placeholder="Filtrar por Data Fim">
            </div>
        </div>

        <div class="cardapios">
            <table>
                <thead>
                    <tr>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Ações</th>
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
                <a href="cardapio-criar.php" class="botao-adicionar">Adicionar Cardápio</a>
                <button onclick="limparSelecao()">Limpar Seleção</button>
            </div>
        </div>
    </div>

    <footer>
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
