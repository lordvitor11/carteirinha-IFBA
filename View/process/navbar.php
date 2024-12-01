<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['logged_in']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: /carteirinha-IFBA/View/login.php');
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
    $perfil = "$rootUrl/View/perfil.php";
    $notification_icon_path = "$rootUrl/assets/notification.png"; // Caminho atualizado para o ícone
    $qrcode = "$rootUrl/assets/qr-code.png";
    $qrcodeLink = "$rootUrl/View/qr-code.php"; 
    $qrcodeEstudanteLink = "$rootUrl/View/qr-code-estudante.php"; // Novo link para QR Code do estudante

    $notification_icon = "<a href='#' class='notification-icon' title='Notificações'><img src='$notification_icon_path' alt='Notificações'></a>";

    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
            $nome = $_SESSION['name'];
            $text = "<div class='right'>
                        $notification_icon
                        <a class='button-admin' href='$admin'>ADMIN</a>
                        <div class='profile-dropdown'>
                            <div class='profile-icon'>
                                <img src='../assets/Victor Hugo.jpg' alt='Perfil'>
                                <span class='dropdown-arrow'></span>
                            </div>
                            <a href='$perfil'>Logado como <strong>$nome!</strong></a>
                            <div class='dropdown-menu'>
                                <a href='$logout'>Sair</a>
                            </div>
                        </div>
                    </div>";
        } else if ($_SESSION['logged_in']) {
            $nome = $_SESSION['name'];
            $text = "<div class='right'>
                        $notification_icon
                        <div class='profile-dropdown'>
                            <div class='profile-icon'>
                                <img src='../assets/Victor Hugo.jpg' alt='Perfil'>
                                <span class='dropdown-arrow'></span>
                            </div>
                            <a href='$perfil'>Logado como <strong>$nome!</strong></a>
                            <div class='dropdown-menu'>
                                <a href='$logout'>Sair</a>
                            </div>
                        </div>
                    </div>";
        } else {
            $text = "<div class='right'><a href='$login'>LOGIN</a></div>";
        }
    }

    if ($call == "login") {
        echo "<nav><div><a href='$index'>Início</a><a href='$cardapio'>Cardápio</a><a href='$sobre'>Sobre</a></div></nav>";
    } else {
        echo '
        <nav>
            <div class="nav-container">
                <div class="hamburger" id="hamburger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul class="nav-list" id="nav-list">
                    <li><a href="' . $index . '">Início</a></li>
                    <li><a href="' . $cardapio . '">Cardápio</a></li>
                    <li><a href="' . $sobre . '">Sobre</a></li>
                    <li><a href="' . ($_SESSION['category'] == "adm" ? $qrcodeLink : $qrcodeEstudanteLink) . '">
                        <img src="' . $qrcode . '" alt="qr-code">
                    </a></li>
                </ul>
                <div class="right">
                    ' . ($text ?? '') . '
                </div>
            </div>
        </nav>';
    }
}
?>
