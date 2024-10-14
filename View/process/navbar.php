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
            $text = "<div class='right'>$notification_icon<a class='button-admin' href='$admin'>Administrador(a)</a><a href='$perfil'>Logado como <strong>$nome!</strong></a></div>";
        } else if ($_SESSION['logged_in']) {
            $nome = $_SESSION['name'];
            $text = "<div class='right'>$notification_icon<a href='$perfil'>Logado como <strong>$nome!</strong></a></div>";
        } else {
            $text = "<div class='right'><a href='$login'>LOGIN</a></div>";
        }
    }

    if ($call == "login") {
        echo "<nav><div><a href='$index'>Início</a><a href='$cardapio'>Cardápio</a><a href='$sobre'>Sobre</a></div></nav>";
    } else {
        if ($_SESSION['logged_in'] && $_SESSION['category'] == "adm") {
            echo "<nav>
                    <div>
                      <a href='$index'>Início</a>
                      <a href='$cardapio'>Cardápio</a>
                      <a href='$sobre'>Sobre</a>
                      <a href='$qrcodeLink'><img src='$qrcode' alt='qr-code-alomoço'></a>
                    </div>
                    $text
                  </nav>
            ";
        } else {
            echo "<nav>
                    <div>
                      <a href='$index'>Início</a>
                      <a href='$cardapio'>Cardápio</a>
                      <a href='$sobre'>Sobre</a>
                      <a href='$qrcodeEstudanteLink'><img src='$qrcode' alt='qr-code-estudante'></a> <!-- Botão QR Code para estudante -->
                    </div>
                    $text
                  </nav>";
        }
    }
}
?>
