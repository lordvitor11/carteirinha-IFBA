document.addEventListener("DOMContentLoaded", function() {
    // Obtém referências aos elementos do DOM
    const changePasswordButton = document.querySelector('.alterar-senha-2');
    const popup = document.querySelector('#alterar-senha-popup-2');
    const closePopupButton = document.querySelector('#close-popup-2');
    const passwordForm = document.querySelector('#alterar-senha-form-2');
    
    // Mostra o popup de alteração de senha
    if (changePasswordButton && popup) {
        changePasswordButton.addEventListener('click', () => {
            popup.style.display = 'flex'; // Exibe o popup centralizado
        });
    }

    // Fecha o popup quando o botão de fechar é clicado
    if (closePopupButton) {
        closePopupButton.addEventListener('click', () => {
            popup.style.display = 'none'; // Oculta o popup
        });
    }

    // Submete o formulário de alteração de senha
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            // Obtém os valores dos campos de senha
            const newPassword = document.querySelector('#new-password-2').value;
            const confirmPassword = document.querySelector('#confirm-password-2').value;

            // Valida se as senhas são iguais e não estão vazias
            if (newPassword.length > 0 && newPassword === confirmPassword) {
                alert('Senha alterada com sucesso!');
                popup.style.display = 'none'; // Oculta o popup após a alteração
                passwordForm.reset(); // Limpa os campos do formulário
            } else {
                alert('As senhas não coincidem ou estão vazias.');
            }
        });
    }
});

function check() {
    let submit = document.querySelector("#submit");
    let user = document.querySelector("#username");
    let password = document.querySelector("#password");

    submit.disabled = !(user.value.length > 0 && password.value.length > 0);
    submit.classList.toggle("enabled", !submit.disabled);
}

function showNotification(message, type) {
    let notification = document.querySelector("#notification");
    let inputUser = document.querySelector("#username");
    let inputPass = document.querySelector("#password");

    notification.innerHTML = message;
    notification.className = "notification " + type;
    notification.style.opacity = 1;

    inputUser.value = "";
    inputPass.value = "";
    check();

    setTimeout(() => {
        notification.style.opacity = 0;
    }, 2500);

    setTimeout(() => {
        notification.classList.remove(type);
        notification.innerHTML = "";
    }, 3000);
}

function enviarFormulario() {
    let formElement = document.querySelector("#form");
    let formData = new FormData(formElement);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "process/process-login.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                if (xhr.responseText === "logged") {
                    let resultDiv = document.querySelector(".result");

                    resultDiv.style.display = "flex";
                    resultDiv.style.opacity = "1";

                    setTimeout(() => {
                        window.location.href = "../index.php";
                    }, 2000);
                } else {
                    console.log(xhr.responseText);
                    showNotification("Usuário inexistente ou credenciais inválidas!", "error");
                }
            } else {
                console.error("Erro na requisição: " + xhr.status);
            }
        }
    };

    xhr.send(formData);
}

document.querySelector("#form").addEventListener("submit", function(event) {
    event.preventDefault();
    enviarFormulario();
});

function adicionarCardapio() {
    window.location.href = "cardapio-criar.php";
}

function cancelarCardapio() {
    window.location.href = "cardapio.php";
}

function addFields() {
    const data_inicio = document.querySelector('#data-inicio').value;
    const data_fim = document.querySelector('#data-fim').value;

    if (data_inicio !== "" || data_fim !== "") {
        const inicio = new Date(data_inicio);
        const fim = new Date(data_fim);
        const component = document.querySelector('.content');
        component.innerHTML = "";
        fim.setDate(fim.getDate() + 1);

        const diaSemanaNomes = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sábado', 'domingo'];
        const dias_da_semana_entre_datas = {};
        for (let data = inicio; data < fim; data.setDate(data.getDate() + 1)) {
            const dia_da_semana_numero = data.getDay();

            dias_da_semana_entre_datas[data.toISOString().slice(0, 10)] = diaSemanaNomes[dia_da_semana_numero];
        }

        for (const [data, dia_da_semana] of Object.entries(dias_da_semana_entre_datas)) {
            let divItem = document.createElement('div');
            let divPrincipal = document.createElement('div');
            let divAcompanhamento = document.createElement('div');
            let divSobremesa = document.createElement('div');

            let labelPrincipal = document.createElement('label');
            let inputPrincipal = document.createElement('input');

            let labelAcompanhamento = document.createElement('label');
            let inputAcompanhamento = document.createElement('input');

            let labelSobremesa = document.createElement('label');
            let inputSobremesa = document.createElement('input');

            divItem.classList.add('dia-semana');

            labelPrincipal.setAttribute('id', dia_da_semana);
            labelPrincipal.setAttribute('name', dia_da_semana);
            labelPrincipal.textContent = dia_da_semana.charAt(0).toUpperCase() + dia_da_semana.slice(1).toLowerCase() + '-feira';

            inputPrincipal.setAttribute('id', dia_da_semana);
            inputPrincipal.setAttribute('name', dia_da_semana);
            inputPrincipal.setAttribute('placeholder', 'Proteína');
            inputPrincipal.required = true;

            labelAcompanhamento.setAttribute('id', 'acompanhamento-' + dia_da_semana);
            labelAcompanhamento.setAttribute('name', 'acompanhamento-' + dia_da_semana);
            labelAcompanhamento.textContent = "‎ ";

            inputAcompanhamento.setAttribute('id', 'acompanhamento-' + dia_da_semana);
            inputAcompanhamento.setAttribute('name', 'acompanhamento-' + dia_da_semana);
            inputAcompanhamento.setAttribute('placeholder', 'Acompanhamento');

            labelSobremesa.setAttribute('id', 'sobremesa-' + dia_da_semana);
            labelSobremesa.setAttribute('name', 'sobremesa-' + dia_da_semana);
            labelSobremesa.textContent = "‎ ";

            inputSobremesa.setAttribute('id', 'sobremesa-' + dia_da_semana);
            inputSobremesa.setAttribute('name', 'sobremesa-' + dia_da_semana);
            inputSobremesa.setAttribute('placeholder', 'Sobremesa');

            divPrincipal.appendChild(labelPrincipal);
            divPrincipal.appendChild(inputPrincipal);

            divAcompanhamento.appendChild(labelAcompanhamento);
            divAcompanhamento.appendChild(inputAcompanhamento);

            divSobremesa.appendChild(labelSobremesa);
            divSobremesa.appendChild(inputSobremesa);

            divItem.appendChild(divPrincipal);
            divItem.appendChild(divAcompanhamento);
            divItem.appendChild(divSobremesa);

            component.appendChild(divItem);
        }

        const buttonContainer = document.querySelector('.botao-container');
        buttonContainer.style.display = "flex";
    }
}

function cardapio_popup() {
    let deleteButton = document.querySelector('.excluir');
    let editButton = document.querySelector('.editar');
    let container = document.querySelector('.container');
    let div = document.createElement('div');
    let label = document.createElement('div');
    let confirmBtn = document.createElement('button');
    let cancelBtn = document.createElement('button');
    let divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');
    deleteButton.disabled = true;
    editButton.disabled = true;

    label.textContent = 'Excluir Cardápio?';

    confirmBtn.addEventListener('click', () => {
        $.ajax({
            url: "cardapio.php",
            type: "POST",
            data: { sinal: "Sinal enviado!" },
            success: function() {
                document.body.classList.remove('popup-open');
                container.removeChild(div);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Erro ao enviar sinal: " + error);
            }
        });
    });

    cancelBtn.addEventListener('click', () => {
        document.body.classList.remove('popup-open');
        container.removeChild(div);
        deleteButton.disabled = false;
        editButton.disabled = false;
    });

    div.classList.add('popup');
    divBtns.classList.add('botao-container');

    div.appendChild(label);
    divBtns.appendChild(cancelBtn);
    divBtns.appendChild(confirmBtn);
    div.appendChild(divBtns);

    container.appendChild(div);

    document.body.classList.add('popup-open');
}

function agendar_popup() {
    let popupContainer = document.querySelector('.container');
    let div = document.createElement('div');
    let label = document.createElement('div');
    let confirmBtn = document.createElement('button');
    let cancelBtn = document.createElement('button');
    let divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');

    label.textContent = 'Deseja salvar as alterações?';

    confirmBtn.addEventListener('click', () => {
        $.ajax({
            url: "agendados.php",
            type: "POST",
            data: { sinal: "Sinal enviado!" },
            success: function() {
                document.body.classList.remove('popup-open');
                popupContainer.removeChild(div);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("Erro ao enviar sinal: " + error);
            }
        });
    });

    cancelBtn.addEventListener('click', () => {
        document.body.classList.remove('popup-open');
        popupContainer.removeChild(div);
    });

    div.classList.add('popup');
    divBtns.classList.add('botao-container');

    div.appendChild(label);
    divBtns.appendChild(cancelBtn);
    divBtns.appendChild(confirmBtn);
    div.appendChild(divBtns);

    popupContainer.appendChild(div);

    document.body.classList.add('popup-open');
}

function showIndexPopup() {
    let div = document.querySelector('.popup-index');

    div.style.display = "flex";

    setTimeout(() => {
        div.classList.add('hide-popup-index');

        setTimeout(() => {
            div.style.display = "none";
        }, 500);
    }, 3500);   
}

function sendNotification(type) {
    const popup = document.querySelector('#notificationPopup');
    const popupList = document.querySelector('#notificationvList');
    const popupButtons = document.querySelector('.buttons');

    if (type == 1) {
        popupButtons.parentNode.removeChild(popupButtons);
        popup.classList.add("transformPopup");
        popupList.innerHTML = '';

        const array = createSend();

        console.log(array[7])

        array.forEach(element => {
            popup.appendChild(element);
        });
    }

    // popup.appendChild(h3);
    // popup.appendChild(labelMsg);
    // popup.appendChild(textarea);
    // popup.appendChild(labelMatricula);
    // popup.appendChild(input);
    // divButtons.appendChild(buttonConfirm);
    // divButtons.appendChild(buttonCancel);
    // popup.appendChild(divButtons);

}

function createSend() {
    const h3 = document.createElement('h3');
    const labelMsg = document.createElement('label');
    const textarea = document.createElement('textarea');
    const labelMatricula = document.createElement('label');
    const input = document.createElement('input');
    const buttonConfirm = document.createElement('button');
    const buttonCancel = document.createElement('button');
    const divButtons = document.createElement('div');

    buttonCancel.textContent = 'Fechar';
    buttonConfirm.textContent = 'Enviar';
    buttonConfirm.classList.add('send');
    buttonCancel.classList.add('close');
    divButtons.classList.add('buttons');
    h3.textContent = "Enviar Notificação";
    labelMsg.textContent = 'Mensagem:'
    labelMsg.setAttribute('for', 'notificationMessage');
    textarea.setAttribute('id', 'notificationMessage');
    textarea.setAttribute('name', 'notificationMessage');
    textarea.setAttribute('rows', '4');
    textarea.setAttribute('placeholder', 'Digite a mensagem...');
    textarea.required = true;
    labelMatricula.setAttribute('for', 'notificationRecipient');
    labelMatricula.textarea = 'Matrícula (deixe em branco para enviar a todos):';
    input.setAttribute('id', 'notificationRecipient');
    input.setAttribute('name', 'notificationRecipient');
    input.setAttribute('placeholder', 'Digite a matrícula...');
    buttonConfirm.setAttribute('type', 'submit');

    buttonConfirm.addEventListener('click', function () {
        const input = document.querySelector('#notificationRecipient');
        const msg = document.querySelector('#notificationMessage');
        const popup = document.querySelector('#notificationPopup');
        const h2 = document.createElement('h2');
        const button = document.createElement('button');
        const value = input.value;
        const message = msg.value;

        // popupButtons.parentNode.removeChild(popupButtons);

        if (message != "") {
            if (value == "") {
                h2.textContent = 'Notificação enviada a todos!';
            } else {
                h2.textContent = 'Notificação Enviada!';
            }

            popup.innerHTML = '';
            popup.classList.add('enviado');
            button.classList.add('close');
            button.textContent = 'Fechar';
            button.addEventListener('click', function() {
                closeNotificationPopup();
                location.reload();
            });
            
            popup.appendChild(h2);
            popup.appendChild(button);
        }

    });

    buttonCancel.addEventListener('click', closeNotificationPopup);

    divButtons.appendChild(buttonConfirm);
    divButtons.appendChild(buttonCancel);

    const array = [h3, labelMsg, textarea, labelMatricula,
                   input, divButtons
    ];

    return array;
}

const data = {
    tipo: 'especifico',
    mensagem: 'john.doe@example.com',
    destino: ''
};

function search() {
    const string = document.querySelector('#buscador').value;
    let identfier = '';

    if (/^\d+$/.test(string)) {
        identfier = 'matricula';
    } else {
        identfier = 'nome';
    }

    const data = {
        tipo: identfier,
        value: string
    };

    fetch('relatorio-diario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Success:', result);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// // Envio dos dados usando fetch
// fetch('process.php', {
//     method: 'POST',
//     headers: {
//         'Content-Type': 'application/json'
//     },
//     body: JSON.stringify(data)
// })
// .then(response => response.json())
// .then(result => {
//     console.log('Success:', result);
//     alert('Dados enviados com sucesso!');
// })
// .catch(error => {
//     console.error('Error:', error);
//     alert('Ocorreu um erro ao enviar os dados.');
// });