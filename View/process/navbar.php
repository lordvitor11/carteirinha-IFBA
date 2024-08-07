<?php session_start();
    if (!isset($_SESSION['logged_in'])) {
        $_SESSION['user'] = "";
        $_SESSION['id_user'] = "";
        $_SESSION['logged_in'] = false;
        $_SESSION['category'] = "";
    }
?>

<?php
function showNav($call) {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $rootUrl = $protocol . '://' . $host . "/carteirinha-IFBA";

    $cardapio = "$rootUrl/View/cardapio.php";
    $index = "$rootUrl/index.php";
    $logout = "$rootUrl/View/process/logout.php";
    $login = "$rootUrl/View/login.php";
    $sobre = "$rootUrl/View/sobre.php";
    $admin = "$rootUrl/View/painel-administrador.php";
    $notification_icon_path = "$rootUrl/assets/notification.png"; // Caminho atualizado para o ícone

    $notification_icon = "<a href='#' class='notification-icon' title='Notificações'><img src='$notification_icon_path' alt='Notificações'></a>";

    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
            $nome = $_SESSION['user'];
            $text = "<div class='right'>$notification_icon<a class='button-admin' href='$admin'>Administrador(a)</a><a href='$logout'>Logado como <strong>$nome!</strong></a></div>";
        } else if ($_SESSION['logged_in']) {
            $nome = $_SESSION['user'];
            $text = "<div class='right'>$notification_icon<a title='Clique para sair' href='$logout'>Logado como <strong>$nome!</strong></a></div>";
        } else {
            $text = "<div class='right'><a href='$login'>LOGIN</a></div>";
        }
    }

    if ($call == "login") {
        echo "<nav><div><a href='$index'>Início</a><a href='$cardapio'>Cardápio</a><a href='$sobre'>Sobre</a></div></nav>";
    } else {
        echo "<nav><div><a href='$index'>Início</a><a href='$cardapio'>Cardápio</a><a href='$sobre'>Sobre</a></div>$text</nav>";
    }
}
?>