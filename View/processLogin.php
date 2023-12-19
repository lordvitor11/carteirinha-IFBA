<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require("../Controller/controller.php");

        $controller = new LoginController();

        $usuario = $_POST['username'];
        $senha = $_POST['password'];

        if ($controller->processarLogin($usuario, $senha)) {
            // echo "<h1>Logado como $usuario</h1>";
            echo "logged";
        } else {
            echo "<h1>Usuário inexistente ou credenciais inválidas!</h1>";
        }
    }
?>
