<?php
  require("../../Controller/controller.php");
  $controller = new LoginController();
  $cardapio = $controller->getCardapio(); 
  $valoresPost = array();
  $count = 0;
  $index = 1;

  foreach ($_POST as $key => $value) {
    $valoresPost[$count][] = $value;

    if ($index % 3 === 0) {
      $count++;
    }
    
    $index++;
  }

  for ($c = 0; $c < count($cardapio); $c++) {
    $cardapio[$c]['principal'] = $valoresPost[$c][0] === "" ? "-" : $valoresPost[$c][0];
    $cardapio[$c]['acompanhamento'] = $valoresPost[$c][1] === "" ? "-" : $valoresPost[$c][1];
    $cardapio[$c]['sobremesa'] = $valoresPost[$c][2] === "" ? "-" : $valoresPost[$c][2];
  }

  print_r($cardapio);

  $controller->deleteCardapio(1);

  for ($c = 0; $c < count($cardapio); $c++) {
    $error = $controller->setCardapio($cardapio[$c]);
  }

  if ($error == "Sem erros") {
    header("Location: ../cardapio.php?id=0");
  } else {
    header("Location: ../cardapio.php?id=1");
  }
?>