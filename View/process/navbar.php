<?php session_start();
    function showNav($call) {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['PHP_SELF']);
        $rootUrl = $protocol . '://' . $host . "/carteirinha-IFBA";

        $cardapio = "$rootUrl/View/cardapio.php";
        $index = "$rootUrl/index.php";
        $logout = "$rootUrl/View/process/logout.php";
        $login = "$rootUrl/View/login.php";
        $sobre = "$rootUrl/View/sobre.php";

        if (isset($_SESSION['logged_in'])) {
            if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
                $nome = $_SESSION['user'];
                $text = "<div class='right'><span class='adm'>Administrador</span><a title='Clique para sair' href='{$logout}'>Logado como <strong>{$nome}!</strong></a></div>";
            } else if ($_SESSION['logged_in']) {
                $nome = $_SESSION['user'];
                $text = "<div class='right'><a title='Clique para sair' href='{$logout}'>Logado como <strong>{$nome}!</strong></a></div>";
            } else {
                $text = "<div class='right'><a href='{$login}'>LOGIN</a></div>";
            }
        }

        $img = $call == "landpage" ? "assets/1b1210fdf4454600bea220983da0cc63.png" : "../assets/1b1210fdf4454600bea220983da0cc63.png";
        echo "<header><a href='https://portal.ifba.edu.br/seabra' target='_blank'><img src='{$img}' alt='logo-ifba-seabra' draggable='false'></a></header>";
        if ($call == "login") {
            echo "<nav><div><a href='{$index}'>Início</a><a href='{$cardapio}'>Cardápio</a><a href='{$sobre}'>Sobre</a></div></nav>";
        } else {
            echo "<nav><div><a href='{$index}'>Início</a><a href='{$cardapio}'>Cardápio</a><a href='{$sobre}'>Sobre</a></div>{$text}</nav>";
        }
    }
?>