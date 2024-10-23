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
} else if ($relativePath == "/painel-administrador.php" || $relativePath == "/sobre.php" || $relativePath == "/qr-code-estudante.php" || $relativePath == "/qr-code.php" || $relativePath == "/perfil.php" || $relativePath == "/aprovado.php" || $relativePath == "/negado.php" || $relativePath == "/relatorio-feedbacks.php" || $relativePath == "/editar-horario.php" || $relativePath == "/cardapio-criar.php" || $relativePath == "/cardapio-cancelar.php" || $relativePath == "/cardapio-alterar.php" || $relativePath == "/cardapio-disponibilizar.php") {
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
    </div>

    <template id="show">
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
        <div class="buttons">
            <?php if ($_SESSION['category'] == 'adm'): ?>
                <button class='send'>Enviar notificação</button>
                <!-- <button class='send' onclick='sendNotification(1)'>Enviar notificação</button> -->
            <?php endif; ?>
            <button class="close" onclick="closeNotificationPopup()">Fechar</button> <!-- Botão de fechar para todos -->
        </div>
    </template>

    <template id="send">
        <h3>Enviar Notificação</h3>
        <input type="text" id="assunto" name="assunto" placeholder="Assunto" required>
        <textarea name="notificationMessage" id="notificationMessage" placeholder="Digite a mensagem..." rows="4" required></textarea>
        <input type="text" id="notificationRecipient" name="notificationRecipient" placeholder="Digite a matrícula...">
        <div class="buttons">
            <button class="confirm">Enviar</button>
            <button class="close" onclick="closeNotificationPopup(); location.reload();">Fechar</button>
        </div>
    </template>
    <template id="allconfirm">
        <h1>ALLCONFIRM</h1>
    </template>
    <template id="oneconfirm">
        <h1>Essa é a pessoa que deve receber?</h1>

        <h2>Nome: <span class="nome"></span></h2>
        <h2>E-mail: <span class="email"></span></h2>
        <h2>Matricula: <span class="matricula"></span></h2>
        <h2>Telefone: <span class="telefone"></span></h2>

    </template>
    <!-- <template id="screen1">
    </template>
    <template id="screen1">
    </template> -->

    
    
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

        // Mudando de Telas na Área de Notificação
        document.querySelector('#notificationPopup').innerHTML = document.querySelector('#show').innerHTML;

        document.querySelector('.send').addEventListener('click', () => {
            document.querySelector('#notificationPopup').innerHTML = document.querySelector('#send').innerHTML;
            
            document.querySelector('.confirm').addEventListener('click', () => {
                if (document.querySelector('#notificationRecipient').value != '') {
                    const matricula = document.querySelector('#notificationRecipient').value;
                    document.querySelector('#notificationPopup').innerHTML = document.querySelector('#oneconfirm').innerHTML;
                    

                    fetch('process/process-oneconfirm.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'matricula': matricula
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Exibe os dados do usuário
                            // alert('Nome: ' + data.data.nome + '\nEmail: ' + data.data.email + '\nTelefone: ' + data.data.telefone);
                            document.querySelector('.nome').innerText = data.data.nome;
                            document.querySelector('.email').innerText = data.data.email;
                            document.querySelector('.matricula').innerText = data.data.matricula;
                            document.querySelector('.telefone').innerText = data.data.telefone;

                        } else {
                            // Exibe a mensagem de erro
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao enviar o sinal:', error);
                    });
                } else {
                    document.querySelector('#notificationPopup').innerHTML = document.querySelector('#allconfirm').innerHTML;
                }
            });
        }); 


        
    // items.buttonConfirm.addEventListener('click', function () {
    //     const inputAssunto = document.querySelector('#assunto');
    //     const input = document.querySelector('#notificationRecipient');
    //     const msg = document.querySelector('#notificationMessage');
    //     const popup = document.querySelector('#notificationPopup');
    //     const h2 = document.createElement('h2');
    //     const button = document.createElement('button');
    //     const value = input.value;
    //     const message = msg.value;

    //     if (message != "") {
    //         const dados = {
    //             matricula: input.value,
    //             assunto: inputAssunto.value,
    //             mensagem: message
    //         };

    //         fetch('process/process-notification.php', {
    //             method: 'POST',
    //             headers: {
    //               'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify(dados)
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.status == "success") {
    //                 h2.textContent = 'Notificação Enviada!';
    //             } else {
    //                 h2.textContent = 'Notificação enviada a todos!';
    //             }
    
    //             popup.innerHTML = '';
    //             popup.classList.add('enviado');
    //             button.classList.add('close');
    //             button.textContent = 'Fechar';
    //             button.addEventListener('click', function() {
    //                 closeNotificationPopup();
    //                 location.reload();
    //             });
                
    //             popup.appendChild(h2);
    //             popup.appendChild(button);
    //         })
    //         .catch(error => console.error('Erro:', error));            
    //     }
    // });


    // items.divButtons.appendChild(items.buttonConfirm);
    // items.divButtons.appendChild(items.buttonCancel);

    // const array = [items.h3, items.inputAssunto, items.labelMsg, items.textarea, items.labelMatricula,
    //     items.input, items.divButtons
    // ];

    // return array;
    </script>

</body>
</html>
