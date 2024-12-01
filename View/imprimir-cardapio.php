<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressão</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="print-content"></div>

    <script>
        window.addEventListener('message', (event) => {
            // Receber o conteúdo da tabela (innerHTML)
            const tableHTML = event.data;

            // Inserir o conteúdo no local correto
            document.getElementById('print-content').innerHTML = tableHTML;

            // Acionar a impressão automaticamente
            setTimeout(() => {
                window.print();
                window.close();
            }, 500);
        });
    </script>
</body>
</html>