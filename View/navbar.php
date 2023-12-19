<?php
    function showNav($call) {
        if ($call == "login") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div></nav>";
        } else if ($call == "landpage") {
            echo "<nav><div><a href='index.php'>Início</a><a href='View/cardapio.php'>Cardápio</a><a href='View/sobre.php'>Sobre</a></div> <div class='right'><a href='View/login.php'>LOGIN</a></div></nav>";
        } else if ($call == "default") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div> <div class='right'><a href='login.php'>LOGIN</a></div></nav>";
        }
    }
?>