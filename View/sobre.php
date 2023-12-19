<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre</title>
    <link rel="stylesheet" href="sobre.css">
</head>
<body>
    <header>
        <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra">
    </header>

    <?php include_once("navbar.php"); showNav("default"); ?>

    <div class="container-sphere">
        <div class="person">
            <div class="semi-sphere">
                <h2>Victor Hugo de Souza Santiago</h2><br>
                <p>Discente do IFBA Campus Seabra ingressado no ano de 2020.</p><br>
                <img src="../assets/victor.jpg" alt="Foto da Pessoa 1" class="img-sobre" onerror="this.src='../assets/person.png'">
            </div>
        </div>

        <div class="person">
            <div class="semi-sphere">
                <h2>Rui Santos Carigé Júnior</h2><br>
                <p>Vigente Docente do Curso de Informática no IFBA - Campus Seabra e Orientador deste projeto.</p><br>
                <img src="../assets/rui.jpg" alt="Foto da Pessoa 2" class="img-sobre" onerror="this.src='../assets/person.png'">
            </div>
        </div>

        <div class="person">
            <div class="semi-sphere">
                <h2>Vitor César Batista de Souza</h2><br>
                <p>Discente do IFBA Campus Seabra ingressado no ano de 2020.</p><br>
                <img src="../assets/vitor.jpg" alt="Foto da Pessoa 3" class="img-sobre" onerror="this.src='../assets/person.png'">
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
          <div class="logo">
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra">
          </div>
          <div class="copyright">
            <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
              Campus Seabra</p>
          </div>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>