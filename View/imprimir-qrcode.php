<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressão</title>
    <link rel="stylesheet" href="css/imprimir-qrcode.css">
</head>
<body>
    <div id="print-content">
        <!-- Título centralizado -->
        <h1>QR Code para Almoço</h1>
        <!-- O conteúdo do QR Code será inserido aqui -->
    </div>

    <script>
        window.addEventListener('message', (event) => {
            // Receber o conteúdo da tabela (innerHTML)
            const tableHTML = event.data;

            // Inserir o conteúdo no local correto
            document.getElementById('print-content').innerHTML += tableHTML;

            // Acionar a impressão automaticamente
            setTimeout(() => {
                window.print();
                window.close();
            }, 500);
        });
    </script>
</body>
</html>
