<!-- <?php
    require("../../Controller/controller.php");

    $controller = new LoginController();
    $inicio = new DateTime($_POST['data-inicio']);
    $fim = new DateTime($_POST['data-fim']);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
    $diasDaSemana = array();
    $semana = array();

    // Itere por cada dia dentro do intervalo
    while ($inicio <= $fim) {
        $diaDaSemana = $inicio->format('N');
    
        switch ($diaDaSemana) {
            case 1:
                $diasDaSemana[0][] = $dias[0]; break;
            case 2: 
                $diasDaSemana[0][] = $dias[1]; break;
            case 3:
                $diasDaSemana[0][] = $dias[2]; break;
            case 4:
                $diasDaSemana[0][] = $dias[3]; break;
            case 5: 
                $diasDaSemana[0][] = $dias[4]; break;
        }

        if ($diaDaSemana >= 1 && $diaDaSemana <= 5) {
            $diasDaSemana[1][] = $inicio->format('Y-m-d');
        }
    
        // Avance para o próximo dia
        $inicio->modify('+1 day');
    }

    for ($c = 0; $c < count($dias); $c++) {
        if (in_array($dias[$c], $diasDaSemana[0])) {
            $semana[] = array(
                $dias[$c] => array(
                    'dia' => $dias[$c],
                    'data' => $diasDaSemana[1][array_search($dias[$c], $diasDaSemana[0])],
                    'principal' => $_POST[$dias[$c]],
                    'acompanhamento' => $_POST["acompanhamento-{$dias[$c]}"] != "" ? $_POST["acompanhamento-{$dias[$c]}"] : '-',
                    'sobremesa' => $_POST["sobremesa-{$dias[$c]}"] != "" ? $_POST["sobremesa-{$dias[$c]}"] : '-'
                )
            );
        } else {
            print_r($dias);
            $semana[] = array(
                $dias[$c] => array(
                    'dia' => $dias[$c],
                    'data' => $diasDaSemana[1][array_search($dias[$c], $diasDaSemana[0])],
                    'principal' => '-',
                    'acompanhamento' => '-',
                    'sobremesa' => '-'
                )
            );
        }
    }

    for ($c = 0; $c < count($semana); $c++) {
        if ($semana[$c][$dias[$c]]['data'] == '-') {
            continue;
        } else {
            $error = $controller->setCardapio($semana[$c][$dias[$c]]);
        }
    }

    // if ($error == "Sem erros") {
    //     header("Location: ../cardapio.php");
    // }
?> -->