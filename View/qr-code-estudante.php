<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link rel="stylesheet" href="css/qr-code-estudante.css">
    <script src="https://cdn.jsdelivr.net/npm/zxing@0.18.1/dist/zxing.min.js"></script>
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
            <div class="frame">
                <video id="video" autoplay playsinline></video>
            </div>
            <p id="result"></p>
        </div>
        
        <div class="buttons">
            <a href="#"><input class="button" type="button" value="Escanear"></a>
            <a href="../index.php"><input class="button voltar" type="button" value="Voltar"></a>
        </div>
    </div>

    <script>
        // Função para verificar se o dispositivo é móvel
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        // Configuração de vídeo baseada no tipo de dispositivo
        const constraints = isMobileDevice()
            ? { video: { facingMode: "environment" } } // Móveis: câmera traseira
            : { video: true }; // Computadores: qualquer câmera disponível

        // Solicitação de permissão para usar a câmera
        navigator.mediaDevices.getUserMedia(constraints)
            .then(stream => {
                const videoElement = document.getElementById('video');
                videoElement.srcObject = stream;
                videoElement.play();
            })
            .catch(error => {
                console.error("Erro ao acessar a câmera:", error);
                alert("Não foi possível acessar a câmera. Verifique as permissões do dispositivo.");
            });

        // Configuração do leitor de QR Code
        const codeReader = new ZXing.BrowserMultiFormatReader();
        const video = document.getElementById('video');

        codeReader.decodeFromVideoDevice(null, video, (result, err) => {
            if (result) {
                document.getElementById('result').innerText = 'QR Code lido: ' + result.text;
            }
            if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error(err);
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
