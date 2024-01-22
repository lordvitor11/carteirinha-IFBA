<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/comunicado-criar.css">
    <title>Comunicados ADMIN</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="container">
        <h1>CRIAR COMUNICADOS</h1>
        <form>
            <label for="data-publicacao">Data publicação:</label>
            <input type="date" id="data-publicacao" name="data-publicacao" required>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="link">Link:</label>
            <input type="text" id="link" name="link" required>

            <label for="imagem" class="label-file-upload">Escolher imagem</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>

            <div class="botao-container">
                <button class="cancelar" type="button">Cancelar Comunicado</button>
                <input type="submit" value="Validar Comunicado">
            </div>
        </form>
    </div>

    <footer class="rodape">
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>