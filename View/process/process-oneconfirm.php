<?php
    header('Content-Type: application/json');

    require("../../Controller/controller.php");

    $controller = new LoginController();
    $response = [];

    if (isset($_POST['matricula'])) {
        $matricula = $_POST['matricula'];
        
        // Inicializa o objeto do usuário
        $userData = $controller->getDataByMatricula($matricula);
        // Verifica se ocorreu erro na busca dos dados
        if ($userData[0] !== 'erro') {
            $response['status'] = 'success';
            $response['data'] = $userData; // Adiciona os dados do usuário à resposta
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao buscar os dados do usuário.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Matrícula não informada';
    }

    // Envia a resposta final como JSON
    echo json_encode($response);
?>