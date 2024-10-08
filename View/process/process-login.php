<?php session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $path = realpath(__DIR__ . "/.." . "/..");
        require($path . "/Controller/controller.php");

        $controller = new LoginController();

        $usuario = $_POST['username'];
        $senha = $_POST['password'];

        $resultadoLogin = $controller->processarLogin($usuario, $senha);

        if ($resultadoLogin['situacao'] == "aprovado") {
            $data = $controller->getUserData($resultadoLogin['id']);
            $_SESSION['id'] = $resultadoLogin['id'];
            $_SESSION['name'] = $data['nome'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['enrollment'] = $data['matricula'];
            $_SESSION['category'] = $data['categoria'];
            $_SESSION['logged_in'] = true;
            echo "logged";
        } else {
            echo "error";
        }
    }
?>
