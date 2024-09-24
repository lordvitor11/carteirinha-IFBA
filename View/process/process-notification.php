<?php session_start();
    header('Content-Type: application/json');
    require("../../Controller/controller.php");
    $controller = new LoginController();

    $response = file_get_contents('php://input');
    $data = json_decode($response, true);

    $matricula = $data['matricula'];
    $assunto = $data['assunto'];
    $mensagem = $data['mensagem'];
    $remetente = $_SESSION['id'];

    $result = $controller->sendNotification($matricula, $remetente, $assunto, $mensagem);

    $resposta = [
        'status' => $result,
    ];
    
    echo json_encode($resposta);
    exit();
?>