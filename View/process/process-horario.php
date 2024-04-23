<?php
  require("../../Controller/controller.php");
  $controller = new LoginController();

  $cardapio = $controller->setDefaultTime($_POST['data'], $_POST['hora']);
  
  if ($cardapio == "Sem erros") {
    header('Location: ../../index.php?id=0');   
  } else {
    header('Location: ../../index.php?id=1');
  }
?>