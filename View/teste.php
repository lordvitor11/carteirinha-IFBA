<?php 
    require "../Controller/controller.php";

    $controller = new LoginController();

    echo "<h1> Teste</h1>";

    $usuario = $_POST['username'];
    $senha = password_hash($_POST['password']);

    echo $controller->teste($usuario, $senha);

    /*if ($controller->processarLogin($usuario, $senha)) {
        echo "<h1>Logado como $usuario</h1>";
    } else {
        echo "<h1>Usuário inexistente ou credenciais inválidas!</h1>";
    }*/
?>