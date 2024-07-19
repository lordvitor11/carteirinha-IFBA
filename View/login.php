<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("login"); ?>

    <h1 class="title-login">FAÇA LOGIN</h1><br>

    <main class="main-login">
    <img class="img-login" src="../assets/IF.png" alt="Logo IFBA">
      <div id="notification" class="notification"></div>
        <form id="form">
            <label for="username">Nome de Usuário:</label>
            <input type="text" oninput="check()" name="username" id="username" placeholder="Usuário" required autocomplete="off"><br><br>

            <label for="password">Senha:</label>
            <input type="password" oninput="check()" name="password" id="password" placeholder="Senha" required autocomplete="off"><br><br>

            <div class="result">
                <div class="loading-spinner"></div>
                <div class="content">Logado</div>
            </div>

            <input type="submit" value="ENTRAR" name="submit" id="submit" disabled>
        </form>
    </main>

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
</body>
</html>