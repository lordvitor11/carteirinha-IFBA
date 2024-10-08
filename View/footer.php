<?php 
    $css = 'css/style.css';
    $img = '../assets/1b1210fdf4454600bea220983da0cc63.png';
    $script = 'script.js';
    $relativePath = '/' . basename($_SERVER['SCRIPT_FILENAME']); 
    
    if ($relativePath == "/index.php") {
        $css = 'View/css/style.css';
        $img = 'assets/1b1210fdf4454600bea220983da0cc63.png';
        $script = 'View/script.js';
        require("Controller/controller.php");
        $controller = new LoginController();
    } else if ($relativePath == "/painel-administrador.php" || $relativePath == "/sobre.php") {
        require("../Controller/controller.php");
        $controller = new LoginController();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $css; ?>">
    <title>RELATÓRIO DE RESERVAS DIÁRIO</title>
    <script src="<?php echo $script; ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div class="overlay" id="notificationOverlay"></div>
        <div class="popup" id="notificationPopup">
            <h2>Notificações</h2>
            <div id="notificationvList">
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
                <!-- <h3>Enviar Notificação</h3>
                <label for="notificationMessage">Mensagem:</label>
                <textarea id="notificationMessage" name="notificationMessage" rows="4" placeholder="Digite a mensagem..."></textarea>
                <label for="notificationRecipient">Matrícula (deixe em branco para enviar a todos):</label>
                <input type="text" id="notificationRecipient" name="notificationRecipient" placeholder="Digite a matrícula..."> -->
            <?php endif; ?>
            <div class="buttons">
                <?php if ($_SESSION['category'] == "adm") { echo "<button class='send' onclick='sendNotification(1)'>Enviar notificação</button>"; } ?>
                <button class="close" onclick="closeNotificationPopup()">Fechar</button>
            </div>
        </div>
    </div>

    <footer class="rodape">
        <div>
            <img src="<?php echo $img; ?>" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
        </div>
        <div class="copyright">
            <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
    </footer>
    <!-- </div> -->

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
