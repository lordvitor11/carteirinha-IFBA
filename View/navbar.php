<?php session_start();
    function showNav($call) {
        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in']) {
                $nome = $_SESSION['user'];
                $text = "<div class='right' title='Clique para sair'><a href='View/logout.php'>Logado como <strong>{$nome}!</strong></a></div>";
            } else {
                $text = "<div class='right'><a href='View/login.php'>LOGIN</a></div>";
            }
        }

        if ($call == "login") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div></nav>";
        } else if ($call == "landpage") {
            echo "<nav><div><a href='index.php'>Início</a><a href='View/cardapio.php'>Cardápio</a><a href='View/sobre.php'>Sobre</a></div>{$text}</nav>";
        } else if ($call == "default") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div>{$text}</nav>";
        }
    }
?>