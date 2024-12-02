<?php session_start();
    require("../../Controller/controller.php");
    $controller = new LoginController();

    $result = $controller->retirarAlmoco($_SESSION['id']);

    if ($result === "confirmar") {
        echo "RECEBIMENTO CONFIRMADO";
    } else {
        echo "RECEBIMENTO CANCELADO";
    }

    exit();
?>