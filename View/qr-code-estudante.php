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
                <video id="video" width="100%" height="100%" style="border-radius: 10px;"></video>
            </div>
            <p id="result"></p>
        </div>
        
        <div class="buttons">
            <a href="#"><input class="button" type="button" value="Escanear"></a>
            <a href="../index.php"><input class="button voltar" type="button" value="Voltar"></a>
        </div>
    </div>

    <script>
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                document.getElementById('video').srcObject = stream;
                document.getElementById('video').play();
            })
            .catch(error => {
                console.error('Erro ao solicitar acesso à câmera:', error);
            });

        const video = document.getElementById('video');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        video.addEventListener('play', () => {
            setInterval(() => {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const codeReader = new ZXing.BrowserMultiFormatReader();
                codeReader.decodeFromImage(imageData)
                    .then(result => {
                        document.getElementById('result').innerText = 'QR-code lido: ' + result.text;
                    })
                    .catch(error => {
                        console.error('Erro ao ler QR-code:', error);
                    });
            }, 100);
        });
    </script>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>
</html>