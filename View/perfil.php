<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: ../index.php');
    exit();
}

// Verifica se as variáveis de sessão necessárias estão definidas
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuário não definido';
$matricula = isset($_SESSION['matricula']) ? $_SESSION['matricula'] : 'Não disponível';
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
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p><br>
            <button id="alterar-senha">Alterar Senha</button>
            <a href="process/logout.php" class="btn-logout">Sair</a><br>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>
