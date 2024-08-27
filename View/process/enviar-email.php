<?php
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // $nome = htmlspecialchars($_POST['nome']);
        // $email = htmlspecialchars($_POST['email']);
        // $assunto = htmlspecialchars($_POST['assunto']);
        // $mensagem = htmlspecialchars($_POST['mensagem']);
        $nome = "Almoço IFBA - Confirmação";
        $assunto = "teste numero 1";
        $mensagem = "teste";
    
        // Define o destinatário e o remetente
        // $para = $email;
        $para = "vitorcesarsouza7@gmail.com";
        $de = "suporte.whoslv@gmail.com";
        
        // Cria o cabeçalho do e-mail
        $cabecalhos = "From: $de\r\n";
        $cabecalhos .= "Reply-To: $de\r\n";
        $cabecalhos .= "X-Mailer: PHP/" . phpversion();
    
        // Envia o e-mail
        $resultado = mail($para, $assunto, $mensagem, $cabecalhos);
    
        if ($resultado) {
            echo "E-mail enviado com sucesso!";
            // header("Location: ../cardapio.php");
        } else {
            echo "Falha ao enviar o e-mail.";
            exit;
        }
    // } else {
    //     echo "Método de requisição não suportado.";
    // }
?>