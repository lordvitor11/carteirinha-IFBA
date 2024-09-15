<?php session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("../Controller/controller.php");
    $controller = new LoginController();

    $dadosRecebidos = file_get_contents('php://input');
    $dados = json_decode($dadosRecebidos, true);

    if (isset($dados['sinal'])) {
        if ($dados['sinal'] == 'changePass-confirm') {
            $resposta = $controller->changePassword($_SESSION['id'], $dados['dado']);

            if ($resposta == 'sucesso') {
                $resultado = ['status' => 'sucesso'];
            } else {
                $resultado = ['status' => 'erro', 'mensagem' => $resposta];
            }
        } else {
            $resposta = $controller->checkPass($dados['pass'], $_SESSION['id']);
            if ($resposta == "sucess") {
                $resultado = ['status' => 'sucesso'];
            } else if ($resposta == "error") {
                $resultado = ['status' => 'erro', 'mensagem' => 'Senha incorreta'];
            } else {
                $resultado = ['status' => 'erro', 'mensagem' => $resposta];
            }
        }
    } 

    echo json_encode($resultado);
    exit();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ../index.php');
    exit();
}

// Verifica se as variáveis de sessão necessárias estão definidas
$usuario = isset($_SESSION['name']) ? ucfirst($_SESSION['name']) : 'Usuário não definido';
$matricula = isset($_SESSION['enrollment']) ? $_SESSION['enrollment'] : 'Não disponível';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Não disponível';
$foto_perfil = '../assets/Victor Hugo.jpeg'; // Atualize este caminho conforme necessário
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>
<body>
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src="./script.js"></script>
    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            echo "<div class='popup-index'>";
            echo "<script>showIndexPopup();</script>";
            echo "<h2 class='popup-index-title'>Senha Alterada!</h2>";
            echo "</div>";
        }
    ?>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="perfil-container">
        <div class="perfil-card">
            <img src="<?php echo $foto_perfil; ?>" alt="Foto de Perfil" class="foto-perfil">
            <h2><?php echo htmlspecialchars($usuario); ?></h2>
            <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($matricula); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <button class="alterar-senha-2">Alterar Senha</button>
            <a href="process/logout.php" class="btn-logout">Sair</a>
        </div>
    </div>

    <!-- Popup de Alterar Senha -->
    <div id="alterar-senha-popup-2" class="popup-2">
        <div class="popup-content-2">
            <span class="close-btn-2" id="close-popup-2">&times;</span>
            <h3>Alterar Senha</h3>
            <form id="alterar-senha-form-2">
                <label for="current-password">Senha atual:</label>
                <input type="password" name="current-password" id="current-password">
                <label for="current-password" id="error"></label>
<!-- 

                <label for="new-password-2">Nova Senha:</label><br>
                <input type="password" id="new-password-2" name="new-password" required><br><br>

                <label for="confirm-password-2">Confirmar Senha:</label><br>
                <input type="password" id="confirm-password-2" name="confirm-password" required><br><br> -->

                <button onclick="checkPass()">Continuar</button>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
