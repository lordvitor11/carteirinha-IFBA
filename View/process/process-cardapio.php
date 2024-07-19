<?php
  function substituirValores($array1, $array2) {
    foreach ($array1 as $data => $valores1) {
      if (isset($array2[$data])) {
        // Se a data estiver presente em ambas as arrays, substituir os valores
        $keys1 = array_keys($valores1);
        $keys2 = array_keys($array2[$data]);

        for ($i = 0; $i < min(3, count($keys1), count($keys2)); $i++) {
          $chave1 = $keys1[$i];
          $chave2 = $keys2[$i];
          $array2[$data][$chave2] = $valores1[$chave1];
        }
      }
    }
    return $array2;
  }

  /*function trocarIndice($array, $antigoIndice, $novoIndice) {
    if (array_key_exists($antigoIndice, $array)) {
      $keys = array_keys($array);
      $values = array_values($array);
        
      $indice = array_search($antigoIndice, $keys);
      if ($indice !== false) {
        $keys[$indice] = $novoIndice;
        $array = array_combine($keys, $values[$indice]);
      }
    }
    return $array;
  }*/

  require("../../Controller/controller.php");

  $controller = new LoginController();
  $teste = array();
  $count = 0;

  foreach ($_POST as $chave => $valor) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $valor);

    if (!$dateTime instanceof DateTime) {
      $teste[$count][$chave] = $valor !== "" ? $valor : "-";

      if (count($teste[$count]) % 3 === 0) {
        $count++;
      }
    }
  }

    try {
        $inicio = new DateTime($_POST['data-inicio']);
        $numeroSemana = $inicio->format("W");
        $ano = $inicio->format("Y");

        $segundaRaw = new DateTime();
        $segundaRaw->setISODate($ano, $numeroSemana);

        $sextaRaw = new DateTime();
        $sextaRaw->setISODate($ano, $numeroSemana, 5);

        $segunda = $segundaRaw->format("Y-m-d");
        $sexta = $sextaRaw->format("Y-m-d");

        $semana['Monday'] = $segunda;

        $segundaObj = new DateTime($segunda);
        $sextaObj = new DateTime($sexta);

        $data = clone $segundaObj;
        $data->modify("+1 day");
        while ($data < $sextaObj) {
            $semana[$data->format('l')] = $data->format("Y-m-d");
            $data->modify("+1 day");
        }

        $semana['Friday'] = $sexta;

        $inicioD = new DateTime($_POST['data-inicio']);
        $fimD = new DateTime($_POST['data-fim']);
        $diasPreenchidos = array();

        $newData = clone $inicioD;
        while ($newData <= $fimD) {
            $diasPreenchidos[$newData->format("Y-m-d")] = array();
            $newData->modify("+1 day");
        }

        $novoArray = array();
        for ($c = 0; $c < count($teste); $c++) {
            $novoArray[array_keys($diasPreenchidos)[$c]] = $teste[$c];
        }

        $finalList = array();
        $diasSemana = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        for ($c = 0; $c < count($semana); $c++) {
            $finalList[$semana[$diasSemana[$c]]] = array('principal' => '-', 'acompanhamento' => '-', 'sobremesa' => '-');
        }

        $finalList = substituirValores($novoArray, $finalList);
        $json = array();
        $dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta'];
        $count = 0;

        foreach ($finalList as $key => $valores) {
            $json[] = array(
              $dias[$count] => array(
                'dia' => $dias[$count],
                'data' => $key,
                'principal' => $valores['principal'],
                'acompanhamento' => $valores['acompanhamento'],
                'sobremesa' => $valores['sobremesa']
              )
            );
            $count++;
        }

        for ($c = 0; $c < count($json); $c++) {
            $error = $controller->setCardapio($json[$c][$dias[$c]]);
        }

        if ($error == "Sem erros") {
            header("Location: ../cardapio.php");
        }
    } catch (Exception $e) {

    }
?>