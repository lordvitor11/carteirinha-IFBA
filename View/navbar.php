<?php session_start();
    function showNav($call) {
        if (isset($_SESSION['logged_in'])) {
            $path = $call == "landpage" ? "View/logout.php" : "logout.php";
            $pathLogin = $call == "landpage" ? "View/login.php" : "login.php";
            
            if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
                $nome = $_SESSION['user'];
                $text = "<div class='right'><span class='adm'>Administrador</span><a title='Clique para sair' href='{$path}'>Logado como <strong>{$nome}!</strong></a></div>";

            } else if ($_SESSION['logged_in']) {
                $nome = $_SESSION['user'];
                $text = "<div class='right'><a title='Clique para sair' href='{$path}'>Logado como <strong>{$nome}!</strong></a></div>";
            } else {
                $text = "<div class='right'><a href='{$pathLogin}'>LOGIN</a></div>";
            }
        }

        $img = $call == "landpage" ? "assets/1b1210fdf4454600bea220983da0cc63.png" : "../assets/1b1210fdf4454600bea220983da0cc63.png";
        echo "<header><a href='https://portal.ifba.edu.br/seabra' target='_blank'><img src='{$img}' alt='logo-ifba-seabra'></a></header>";
        if ($call == "login") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div></nav>";
        } else if ($call == "landpage") {
            echo "<nav><div><a href='index.php'>Início</a><a href='View/cardapio.php'>Cardápio</a><a href='View/sobre.php'>Sobre</a></div>{$text}</nav>";
        } else if ($call == "default") {
            echo "<nav><div><a href='../index.php'>Início</a><a href='cardapio.php'>Cardápio</a><a href='sobre.php'>Sobre</a></div>{$text}</nav>";
        }
    }
?>