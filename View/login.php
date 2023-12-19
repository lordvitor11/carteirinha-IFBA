<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra">
    </header>

    <?php include_once("navbar.php"); showNav("login"); ?>

    <main class="main-login">
      <div id="notification" class="notification"></div>
        <h2>FAÇA LOGIN</h2><br>
        <form id="form">
            <label for="usuario">Nome de Usuário:</label>
            <input type="text" oninput="check()" name="username" id="username" placeholder="Usuário" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" oninput="check()" name="password" id="password" placeholder="Senha" required><br><br>

            <div class="result">
                <div class="loading-spinner"></div>
                <div class="content">Logado</div>
            </div>

            <input type="submit" value="ENTRAR" name="submit" id="submit" disabled>
        </form>
    </main>

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