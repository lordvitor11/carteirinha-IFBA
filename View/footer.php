<?php 
$css = 'css/style.css';
$img = '../assets/1b1210fdf4454600bea220983da0cc63.png';
$script = 'script.js';
$relativePath = '/' . basename($_SERVER['SCRIPT_FILENAME']); 

// Verifica o caminho atual para incluir o controlador apenas quando necessário
if ($relativePath == "/index.php") {
    $css = 'View/css/style.css';
    $img = 'assets/1b1210fdf4454600bea220983da0cc63.png';
    $script = 'View/script.js';
    require("Controller/controller.php");
    $controller = new LoginController();
} else if ($relativePath == "/painel-administrador.php" || $relativePath == "/sobre.php" || $relativePath == "/qr-code-estudante.php" || $relativePath == "/qr-code.php" || $relativePath == "/perfil.php.php") {
    require("../Controller/controller.php"); // Ajuste aqui
    $controller = new LoginController();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <title>FOOTER</title>
    <script src="<?php echo $script; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div class="overlay" id="notificationOverlay"></div>
    <div class="popup" id="notificationPopup">
        <h2>Notificações</h2>
        <div id="notificationList">
            <?php
            if (isset($_SESSION['logged_in'])) {
                $userId = $_SESSION['id'];
                $result = $controller->hasNotification($userId);

                if ($result) {
                    $assuntos = $controller->getAssunto($userId);
                    foreach ($assuntos as $assunto) {
                        echo "<div class='notification-item'>" . htmlspecialchars($assunto, ENT_QUOTES, 'UTF-8') . "</div>";
                    }
                } else {
                    echo "<h3 class='notification-item null'>Sem notificações.</h3>";
                }
            }
            ?>
        </div>
        <?php if ($_SESSION['category'] == 'adm'): ?>
            <div class="buttons">
                <button class='send' onclick='sendNotification(1)'>Enviar notificação</button>
                <button class="close" onclick="closeNotificationPopup()">Fechar</button>
            </div>
        <?php endif; ?>
    </div>
    
    <footer class="rodape">
        <div>
            <img src="<?php echo $img; ?>" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
            <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>

    <script>
        // Função para abrir o pop-up de notificações
        function openNotificationPopup() {
            document.getElementById('notificationPopup').style.display = 'block';
            document.getElementById('notificationOverlay').style.display = 'block';
        }

        // Função para fechar o pop-up de notificações
        function closeNotificationPopup() {
            document.getElementById('notificationPopup').style.display = 'none';
            document.getElementById('notificationOverlay').style.display = 'none';
        }

        // Adiciona o evento de clique no ícone de notificações
        document.querySelector('.notification-icon').addEventListener('click', openNotificationPopup);
    </script>

</body>
</html>
