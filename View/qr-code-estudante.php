<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link rel="stylesheet" href="css/qr-code-estudante.css">
</head>
<body>
    <header class="session-1">
        <a href='https://portal.ifba.edu.br/seabra' target='_blank'>
            <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'>
        </a>
    </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="center">
        <div class="camera-container">
            <div class="subtitle">
                Escanear QR CODE
                <p class="description">Aproxime o QR Code da câmera para escanear automaticamente.</p>
            </div>
            <div class="frame"></div>
        </div>
        
        <div class="buttons">
            <a href="#"><input class="button" type="button" value="Escanear"></a>
            <a href="../index.php"><input class="button voltar" type="button" value="Voltar"></a>
        </div>
    </div>

    <script>
        function requestCameraPermission() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    console.log("Permissão de câmera concedida");
                })
                .catch(function(error) {
                    console.error("Permissão de câmera negada", error);
                    alert("Permissão de câmera negada.");
                });
            } else {
                alert("Navegador não suporta acesso à câmera.");
            }
        }
        window.onload = requestCameraPermission;
    </script>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
