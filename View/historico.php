<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/historico.css">
    <title>HISTÓRICO DE CARDÁPIOS</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1 class="titulo">HISTÓRICO DE CARDÁPIO</h1>

        <div class="input-container">
            <label for="data-inicio">Data Início:</label>
            <input type="date" id="data-inicio" name="data-inicio" required>

            <label for="data-fim">Data Fim:</label>
            <input type="date" id="data-fim" name="data-fim" required>
        </div>
        <table>
            
            <?php 
                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                            </tr>
                        </thead>
                        <tbody>";

                    echo "</tbody>";
                    echo "</table>";
            ?>
            </tbody> 
        </table>
        <div class="separador">
            <a href="painel-administrador.php"><button class='button-voltar'>Voltar</button></a>
            <button class='button'>Buscar</button>
        </div>
        
    </div>

    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>
</html>
