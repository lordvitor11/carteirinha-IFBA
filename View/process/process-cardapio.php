<?php
    $inicio = new DateTime($_POST['data-inicio']);
    $fim = new DateTime($_POST['data-fim']);

    $semana = array(
        "segunda" => $inicio->format('d-m-Y'),
        "terca" => $inicio->modify("+1 days")->format('d-m-Y'),
        "quarta" => $inicio->modify("+1 days")->format('d-m-Y'),
        "quinta" => $inicio->modify("+1 days")->format('d-m-Y'),
        "sexta" => $fim->format('d-m-Y'),
    );
    
?>