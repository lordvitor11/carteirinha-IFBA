<?php session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require("../Controller/controller.php");

        $controller = new LoginController();

        $usuario = $_POST['username'];
        $senha = $_POST['password'];

        $resultadoLogin = $controller->processarLogin($usuario, $senha);

        if ($resultadoLogin['situacao'] == "aprovado") {
            $data = $controller->getUserData($resultadoLogin['id']);
            $_SESSION['id'] = $resultadoLogin['id'];
            $_SESSION['user'] = $data['nome'];
            $_SESSION['logged_in'] = true;
            $_SESSION['category'] = $data['categoria'];
            echo "logged";
        } else {
            echo "error";
        }
    }
?>
