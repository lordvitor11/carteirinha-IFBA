<?php 
    $servername = "localhost"; 
    $dbname = "data";
    $dbuser = "root";
    $dbpass = "";

    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }
?>