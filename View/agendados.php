<?php
    session_start();
    require("../Controller/controller.php");
    $controller = new LoginController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $motivo = $_POST['motivo'];
        $idUser = $_SESSION['id'];
        $current_day = date("Y-m-d");

        $result = $controller->cancelarRefeicao($idUser, $current_day, $motivo);
        echo $result;
        exit;
        if ($result === "sucesso") {
            echo "sucesso";
        } else {
            echo "erro";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/agendados.css">
    <title>Agendados</title>
</head>
<body>
<header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img class="img-logo" src='../assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("process/navbar.php"); showNav("default"); ?>

    <div class="popup" id="popup"></div>
    <div class="overlay" id="overlay"></div>

    </div>

    <div class="container">
        <h1>AGENDADOS</h1>
        <img src="../assets/cozinheira.png" alt="Imagem do Boneco" class="image2" draggable="false">

        <table>

            <?php 
                $idUser = $_SESSION['id'];
                
                $sql = "SELECT * FROM refeicao WHERE id_usuario = '$idUser'";
                $result = $conn->query($sql);

                $refeicaoData = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $refeicaoData = $row;
                }

                if (count($refeicaoData) > 0) {

                    $cardapioId = $refeicaoData['id_cardapio'];

                    $sql = "SELECT data_refeicao, dia, principal, acompanhamento, sobremesa FROM cardapio WHERE id = $cardapioId";
                    $result = $conn->query($sql);

                    $cardapioData = [];

                    while ($row = mysqli_fetch_assoc($result)) {
                        $cardapioData = $row;
                    }

                    $dia = ucfirst($cardapioData['dia']) . "-feira";

                    echo "
                        <thead>
                            <tr>
                                <th>Dia</th>
                                <th>Proteína</th>
                                <th>Acompanhamento</th>
                                <th>Sobremesa</th>
                                <th></th> <!-- Coluna extra para os botões -->
                            </tr>
                        </thead>
                        <tbody>";
                    
                    echo "<tr>";
                    echo "<td>{$dia}({$cardapioData['data_refeicao']})</td>";
                    echo "<td>{$cardapioData['principal']}</td>";
                    echo "<td>{$cardapioData['acompanhamento']}</td>";
                    echo "<td>{$cardapioData['sobremesa']}</td>";
                    echo "<td>";
                    // echo "<a href='cardapio-cancelar.php'>";
                    echo "<button class='vermelho' onclick='agendadosPopup(1);'><img src='../assets/cancelar.png' alt='none'></button>";
                    echo "</a>";
                    // echo "<a href='cardapio-disponibilizar.php'>";
                    echo "<button class='amarelo' onclick='agendadosPopup(2);'><img src='../assets/transferir.png' alt='none'></button>";
                    echo "</a>";
                    // echo "<button class='azul' onclick='window.location.href=\"qr-code.php\";'><img src='../assets/qrcode.png' alt='none'></button>";
                    echo "</a>";
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<h1 class='texto'>Sem refeição registrada</h1>";
                }
            ?>
        </table>

        <a href='cardapio.php'><button class='editar'>Voltar</button></a>

    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Adições abaixo -->

    <script>
        function agendadosPopup(type) {
            const popup = document.querySelector("#popup");
            const overlay = document.querySelector("#overlay");
            popup.innerHTML = ""; 

            const h2 = document.createElement("h2");
            const inputMotivo = document.createElement("input");
            const divButtons = document.createElement("div");
            const btnConfirm = document.createElement("button");
            const btnCancel = document.createElement("button");
            const labelMotivo = document.createElement("label");

            inputMotivo.setAttribute("id", "outro");
            inputMotivo.setAttribute("name", "outro");
            inputMotivo.setAttribute("placeholder", "Digite o motivo...");

            divButtons.classList.add("botao-container");
            btnConfirm.setAttribute("type", "submit");
            btnConfirm.setAttribute("id", "confirmar");
            btnConfirm.classList.add("validar");
            btnCancel.classList.add("cancelar");

            divButtons.appendChild(btnCancel);
            divButtons.appendChild(btnConfirm);

            btnCancel.addEventListener("click", closeAgendadosPopup);
            if (type === 1) { btnConfirm.addEventListener("click", funcaoReserva); }

            labelMotivo.textContent = "MOTIVO:";
            h2.textContent = type === 1 ? "CANCELAR RESERVA" : "DISPONIBILIZAR RESERVA";

            popup.appendChild(h2);
            popup.appendChild(labelMotivo);
            popup.appendChild(inputMotivo);

            if (type !== 1) {
                const labelMatricula = document.createElement("label");
                const inputMatricula = document.createElement("input");

                inputMatricula.setAttribute("id", "matricula");
                inputMatricula.setAttribute("name", "matricula");
                inputMatricula.setAttribute("placeholder", "Matrícula alvo");

                labelMatricula.textContent = "MATRÍCULA";

                popup.appendChild(labelMatricula);
                popup.appendChild(inputMatricula);

                btnConfirm.addEventListener('click', () => {
                    const motivo = document.querySelector('#outro').value;
                    const matricula = document.querySelector('#matricula').value;

                    let dados = {
                        motivo: motivo,
                        matricula: matricula
                    };

                    fetch('process/transferir-reserva.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(dados).toString()
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === "sucesso") {
                            showNotification(
                                `Reserva transferida com sucesso para o usuário de matrícula ${result.matriculaDestino}!`,
                                "success"
                            );
                        } else {
                            showNotification(
                                `Erro ao transferir a reserva: ${result.mensagem || "Tente novamente mais tarde."}`,
                                "error"
                            );
                        }
                        closeAgendadosPopup();
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        showNotification(
                            "Ocorreu um erro inesperado ao transferir a reserva. Tente novamente mais tarde.",
                            "error"
                        );
                    });
                });

                function showNotification(message, type) {
                    const notification = document.createElement("div");
                    notification.classList.add("notification", type);
                    notification.innerText = message;

                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
                }
            }

            popup.appendChild(divButtons);
            popup.style.display = "block";
            overlay.style.display = "block";

            document.querySelector('.container').classList.add("blur");
        }

        function closeAgendadosPopup() {
            const popup = document.querySelector("#popup");
            const overlay = document.querySelector("#overlay");
            popup.style.display = "none";
            overlay.style.display = "none";
            document.querySelector('.container').classList.remove("blur");
        }

        function funcaoReserva(type, motivo) {
            const data = {
                motivo: document.querySelector("#outro").value
            };

            fetch('agendados.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded' 
                },
                body: new URLSearchParams(data).toString() 
            })
            .then(response => response.text())
            .then(result => {
                window.location.href = 'cardapio.php?id=0';
                console.log('Resposta do servidor:', result);
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        }
    </script>
</body>
</html>
