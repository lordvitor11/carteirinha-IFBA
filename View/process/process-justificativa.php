<?php session_start();
    require('../../Model/connect.php');
    require('../../Controller/controller.php');
    $controller = new LoginController();
    global $conn;

    $justificativa = $_POST['justificativa'];
    $idUser = $_SESSION['user'];
    $sql = "SELECT id FROM usuario WHERE nome = '$idUser'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    $idUser = $row[0];
    $idJustificativa = 0;

    if ($_POST["justificativa"] == "outro") {
        $idJustificativa = 4;
        $justificativa = $_POST["outro"];
    } else {
        switch ($_POST["justificativa"]) {
            case "contra-turno": $idJustificativa = 1; break;
            case "transporte": $idJustificativa = 2; break;
            case "projeto": $idJustificativa = 3; break;
        }
        $justificativa = null;
    }

    $diaDaSemana = $_SESSION['diaSemana'];
    $sql = "SELECT id FROM cardapio WHERE dia = '$diaDaSemana'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $idCardapio = $row['id'];
    $statusRef = 1;
    $dataSolicitacao = date("Y-m-d H:i:s");
    $result = $controller->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $justificativa);

    if ($result == "Sem erros") {
        header("location: ../cardapio.php");
    } else {
        echo $result;
    }
