<?php session_start();
    require("../../Controller/controller.php");
    $controller = new LoginController();

    $motivo = $_POST['motivo'];
    $matricula = $_POST['matricula'];
    $idUsuario = $_SESSION['id'];

    $result = $controller->transferirReserva($idUsuario, $motivo, $matricula);

    if ($result === "Notificação enviada") {
        echo "<h1>Notificação enviada</h1>";
    } else {
        echo "<h1>Notificação não enviada</h1>";
    }


    exit();
?>