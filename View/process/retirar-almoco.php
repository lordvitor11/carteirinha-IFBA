<?php session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require("../../Controller/controller.php");
    $controller = new LoginController();

    $result = $controller->retirarAlmoco($_SESSION['id']);

    echo $result;

    if ($result === "confirmar") {
        echo "<h1>RECEBIMENTO CONFIRMADO</h1>";
    } else {
        echo "<h1>RECEBIMENTO CANCELADO</h1>";
    }
?>