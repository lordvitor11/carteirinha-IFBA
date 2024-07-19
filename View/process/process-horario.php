<?php
    require("../../Controller/controller.php");
    $controller = new LoginController();

    date_default_timezone_set('America/Sao_Paulo');
    $horario_atual = date('H:i:s');
    $data = $_POST['data'] . ' ' . $horario_atual;

    $cardapio = $controller->setDefaultTime($data, $_POST['hora']);

    if ($cardapio == "Sem erros") {
        header('Location: ../../index.php?id=0');
    } else {
        header('Location: ../../index.php?id=1');
    }
