<?php
    require("../../Controller/controller.php");

    $controller = new LoginController();
    $inicio = new DateTime($_POST['data-inicio']);
    $fim = new DateTime($_POST['data-fim']);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $semana = array(
        "segunda" => array(
            "dia" => "segunda",
            "data" => $inicio->format('Y-m-d'),
            "principal" => $_POST['segunda'],
            "acompanhamento" => $_POST['acompanhamento-segunda'] != "" ? $_POST['acompanhamento-segunda'] : "Sem acompanhamento",
            "sobremesa" => $_POST['sobremesa-segunda'] != "" ? $_POST['sobremesa-segunda'] : "Sem sobremesa",
            "id_excluido" => 0
        ),
        "terca" => array(
            "dia" => "terca",
            "data" => $inicio->modify("+1 days")->format('Y-m-d'),
            "principal" => $_POST['terca'],
            "acompanhamento" => $_POST['acompanhamento-terca'] != "" ? $_POST['acompanhamento-terca'] : "Sem acompanhamento",
            "sobremesa" => $_POST['sobremesa-terca'] != "" ? $_POST['sobremesa-terca'] : "Sem sobremesa",
            "id_excluido" => 0
        ),
        "quarta" => array(
            "dia" => "quarta",
            "data" => $inicio->modify("+1 days")->format('Y-m-d'),
            "principal" => $_POST['quarta'],
            "acompanhamento" => $_POST['acompanhamento-quarta'] != "" ? $_POST['acompanhamento-quarta'] : "Sem acompanhamento",
            "sobremesa" => $_POST['sobremesa-quarta'] != "" ? $_POST['sobremesa-quarta'] : "Sem sobremesa",
            "id_excluido" => 0
        ),
        "quinta" => array(
            "dia" => "quinta",
            "data" => $inicio->modify("+1 days")->format('Y-m-d'),
            "principal" => $_POST['quinta'],
            "acompanhamento" => $_POST['acompanhamento-quinta'] != "" ? $_POST['acompanhamento-quinta'] : "Sem acompanhamento",
            "sobremesa" => $_POST['sobremesa-quinta'] != "" ? $_POST['sobremesa-quinta'] : "Sem sobremesa",
            "id_excluido" => 0
        ),
        "sexta" => array(
            "dia" => "sexta",
            "data" => $fim->format('Y-m-d'),
            "principal" => $_POST['sexta'],
            "acompanhamento" => $_POST['acompanhamento-sexta'] != "" ? $_POST['acompanhamento-sexta'] : "Sem acompanhamento",
            "sobremesa" => $_POST['sobremesa-sexta'] != "" ? $_POST['sobremesa-sexta'] : "Sem sobremesa",
            "id_excluido" => 0
        )
    );

    foreach ($semana as $dia) {
        $error = $controller->setCardapio($dia); 
    }

    if ($error == "Sem erros") {
        header("Location: ../cardapio.php");
    }
?>