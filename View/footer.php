<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>RELATÓRIO DE RESERVAS DIÁRIO</title>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

    <div class="overlay" id="notificationOverlay"></div>
        <div class="popup" id="notificationPopup">
            <h2>Notificações</h2>
            <div id="notificationList">
                <!-- Exemplos de Notificações -->
                <div class="notification-item">Seu horário de aula foi alterado.</div>
                <div class="notification-item">O cardápio de hoje está disponível.</div>
                <div class="notification-item">Atenção: Inscrição para o evento se encerra amanhã.</div>
            </div>
            <?php if ($_SESSION['category'] == 'adm'): ?>
                <h3>Enviar Notificação</h3>
                <label for="notificationMessage">Mensagem:</label>
                <textarea id="notificationMessage" name="notificationMessage" rows="4" placeholder="Digite a mensagem..."></textarea>
                <label for="notificationRecipient">Matrícula (deixe em branco para enviar a todos):</label>
                <input type="text" id="notificationRecipient" name="notificationRecipient" placeholder="Digite a matrícula...">
                <button id="btn-send-notification" onclick="sendNotification()">Enviar Notificação</button>
            <?php endif; ?>
            <button class="close" onclick="closeNotificationPopup()">Fechar</button>
        </div>

        <footer class="rodape">
            <div>
                <img src="../assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo img-logo" draggable="false">
            </div>
            <div class="copyright">
            <p>&copy; 2024 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
                Campus Seabra</p>
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
