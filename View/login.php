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

    <nav>
        <div>
            <a href="../index.html">Início</a>
            <a href="cardapio.html">Cardápio</a>
        </div>
    </nav>

    <main>
        <h2>FAÇA LOGIN</h2><br>
        <form action="" method="post">
            <label for="usuario">Nome de Usuário:</label>
            <input type="text" oninput="check();" name="username" id="username" placeholder="Usuário" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" oninput="check();" name="password" id="password" placeholder="Senha" required><br><br>

            <input type="submit" value="ENTRAR" name="submit" id="submit">
        </form>
    </main>

    <?php 
        require("../Controller/controller.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

            $controller = new LoginController();

            $usuario = $_POST['username'];
            $senha = $_POST['password'];

            /*if ($controller->teste($usuario, $senha)) {
                echo "<h1>Usuário encontrado!</h1>";
            } else {
                echo "<h1>Usuário não econtrado!</h1>";
            }*/

            if ($controller->processarLogin($usuario, $senha)) {
                echo "<h1>Logado como $usuario</h1>";
            } else {
                echo "<h1>Usuário inexistente ou credenciais inválidas!</h1>";
            }
        }
    ?>

    <footer>
        <div>
            <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
      </footer>
    <script src="View/script.js"></script>
</body>
</html>