<?php 
  $servername = "carteirinha23.mysql.dbaas.com.br";
  $username = "carteirinha23";
  $password = "LEDS@ifseabra0";
  $dbname = "carteirinha23";

  // $servername = "localhost";
  // $username = "root";
  // $password = "";
  // $dbname = "carteirinha23";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
  }
?>
