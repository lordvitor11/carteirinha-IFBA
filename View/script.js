document.addEventListener("DOMContentLoaded", () => {
    const changePasswordButton = document.querySelector('.alterar-senha-2');
    const popup = document.querySelector('#alterar-senha-popup-2');
    const closePopupButton = document.querySelector('#close-popup-2');

    if (changePasswordButton) {
        changePasswordButton.addEventListener('click', () => {
            popup.style.display = 'flex';
        });
    }

    if (closePopupButton) {
        closePopupButton.addEventListener('click', () => {
            popup.style.display = 'none';
        });
    }
});


function check() {
    const submit = document.querySelector("#submit");
    const user = document.querySelector("#username");
    const password = document.querySelector("#password");

    const isValid = user.value && password.value;
    submit.disabled = !isValid;
    submit.classList.toggle("enabled", isValid);
}

function showNotification(message, type) {
    const notification = document.querySelector("#notification");
    const inputUser = document.querySelector("#username");
    const inputPass = document.querySelector("#password");

    notification.innerHTML = message;
    notification.className = `notification ${type}`;
    notification.style.opacity = 1;

    inputUser.value = "";
    inputPass.value = "";
    check();

    setTimeout(() => {
        notification.style.opacity = 0;
    }, 2500);

    setTimeout(() => {
        notification.className = "notification"; 
        notification.innerHTML = "";
    }, 3000);
}

function enviarFormulario() {
    const formElement = document.querySelector("#form");
    const formData = new FormData(formElement);

    fetch("process/process-login.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Erro na requisição: " + response.status);
        }
        return response.text();
    })
    .then(data => {
        if (data === "logged") {
            const resultDiv = document.querySelector(".result");
            resultDiv.style.display = "flex";
            resultDiv.style.opacity = "1";

            setTimeout(() => {
                window.location.href = "../index.php";
            }, 2000);
        } else {
            console.log(data);
            showNotification("Usuário inexistente ou credenciais inválidas!", "error");
        }
    })
    .catch(error => {
        console.error(error);
    });
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

    if (data_inicio || data_fim) {
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
            const divItem = document.createElement('div');
            divItem.classList.add('dia-semana');

            const createField = (labelText, placeholder, id) => {
                const label = document.createElement('label');
                label.setAttribute('for', id);
                label.textContent = labelText;

                const input = document.createElement('input');
                input.setAttribute('id', id);
                input.setAttribute('name', id);
                input.setAttribute('placeholder', placeholder);
                input.required = true;

                const div = document.createElement('div');
                div.appendChild(label);
                div.appendChild(input);
                return div;
            };

            divItem.appendChild(createField(dia_da_semana.charAt(0).toUpperCase() + dia_da_semana.slice(1) + '-feira', 'Proteína', dia_da_semana));
            divItem.appendChild(createField("‎", 'Acompanhamento', 'acompanhamento-' + dia_da_semana));
            divItem.appendChild(createField("‎", 'Sobremesa', 'sobremesa-' + dia_da_semana));

            component.appendChild(divItem);
        }

        const buttonContainer = document.querySelector('.botao-container');
        buttonContainer.style.display = "flex";
    }
}

function cardapio_popup() {
    const deleteButton = document.querySelector('.excluir');
    const editButton = document.querySelector('.editar');
    const container = document.querySelector('.container');
    const div = document.createElement('div');
    const label = document.createElement('div');
    const confirmBtn = document.createElement('button');
    const cancelBtn = document.createElement('button');
    const divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');
    deleteButton.disabled = true;
    editButton.disabled = true;

    label.textContent = 'Excluir Cardápio?';

    confirmBtn.addEventListener('click', () => {
        fetch("cardapio.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sinal: "Sinal enviado!" })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao enviar sinal");
            }
            document.body.classList.remove('popup-open');
            container.removeChild(div);
            location.reload();
        })
        .catch(error => {
            console.error("Erro ao enviar sinal: " + error);
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
    const popupContainer = document.querySelector('.container');
    const div = document.createElement('div');
    const label = document.createElement('div');
    const confirmBtn = document.createElement('button');
    const cancelBtn = document.createElement('button');
    const divBtns = document.createElement('div');

    confirmBtn.classList.add('validar');
    cancelBtn.classList.add('cancelar');

    label.textContent = 'Deseja salvar as alterações?';

    confirmBtn.addEventListener('click', () => {
        fetch("agendados.php", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sinal: "Sinal enviado!" })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao enviar sinal");
            }
            document.body.classList.remove('popup-open');
            popupContainer.removeChild(div);
            location.reload();
        })
        .catch(error => {
            console.error("Erro ao enviar sinal: " + error);
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
    const div = document.querySelector('.popup-index');

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

    if (type === 1) {
        popupButtons.remove();
        popup.classList.add("transformPopup");
        popupList.innerHTML = '';

        const array = createSend();
        setTimeout(() => {
            array.forEach(element => popup.appendChild(element));
        }, 500);
    }
}

function createSend() {
    const items = {
        h3: document.createElement('h3'),
        inputAssunto: document.createElement('input'),
        labelMsg: document.createElement('label'),
        textarea: document.createElement('textarea'),
        labelMatricula: document.createElement('label'),
        input: document.createElement('input'),
        buttonConfirm: document.createElement('button'),
        buttonCancel: document.createElement('button'),
        divButtons: document.createElement('div')
    };

    // Configurações dos elementos
    items.buttonCancel.textContent = 'Cancelar';
    items.buttonCancel.classList.add('close');
    items.buttonCancel.addEventListener('click', () => {
        closeNotificationPopup();
        location.reload();
    });

    items.buttonConfirm.textContent = 'Enviar';
    items.buttonConfirm.classList.add('send');
    items.buttonConfirm.type = 'submit';

    items.divButtons.classList.add('buttons');
    items.h3.textContent = "Enviar Notificação";

    items.labelMsg.textContent = 'Mensagem:';
    items.labelMsg.setAttribute('for', 'notificationMessage');

    Object.assign(items.textarea, {
        id: 'notificationMessage',
        name: 'notificationMessage',
        rows: 4,
        placeholder: 'Digite a mensagem...',
        required: true
    });

    Object.assign(items.inputAssunto, {
        id: 'assunto',
        name: 'assunto',
        placeholder: 'Assunto',
        required: true
    });

    items.labelMatricula.setAttribute('for', 'notificationRecipient');
    items.labelMatricula.textContent = 'Matrícula (deixe em branco para enviar a todos):';
    Object.assign(items.input, {
        id: 'notificationRecipient',
        name: 'notificationRecipient',
        placeholder: 'Digite a matrícula...'
    });

    items.buttonConfirm.addEventListener('click', () => {
        const inputAssunto = document.querySelector('#assunto');
        const input = document.querySelector('#notificationRecipient');
        const msg = document.querySelector('#notificationMessage');
        const popup = document.querySelector('#notificationPopup');

        if (msg.value) {
            const dados = {
                matricula: input.value,
                assunto: inputAssunto.value,
                mensagem: msg.value
            };

            fetch('process/process-notification.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            })
            .then(response => response.json())
            .then(data => {
                const h2 = document.createElement('h2');
                const button = document.createElement('button');

                h2.textContent = data.status === "success" ? 'Notificação Enviada!' : 'Notificação enviada a todos!';
                popup.innerHTML = '';
                popup.classList.add('enviado');
                
                button.classList.add('close');
                button.textContent = 'Fechar';
                button.addEventListener('click', () => {
                    closeNotificationPopup();
                    location.reload();
                });

                popup.appendChild(h2);
                popup.appendChild(button);
            })
            .catch(error => console.error('Erro:', error));
        }
    });

    items.divButtons.append(items.buttonConfirm, items.buttonCancel);

    return [items.h3, items.inputAssunto, items.labelMsg, items.textarea, items.labelMatricula, items.input, items.divButtons];
}

const data = {
    tipo: 'especifico',
    mensagem: 'john.doe@example.com',
    destino: ''
};

function search() {
    const string = document.querySelector('#buscador').value.trim();
    const identifier = /^\d+$/.test(string) ? 'matricula' : 'nome';

    const body = JSON.stringify(string ? { type: identifier, value: string } : { type: 'all' });

    fetch('relatorio-diario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: body
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Houve um problema com a requisição:', error);
    });
}

function checkPass(event) {
    event.preventDefault();
    
    const input = document.querySelector("#current-password").value;
    const data = {
        sinal: "checkPass",
        pass: input
    };

    fetch('perfil.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
        }
        return response.text();
    })
    .then(text => {
        document.querySelector("#current-password").value = "";
        const labelErro = document.querySelector('#error');
        
        try {
            const resultado = JSON.parse(text);
            labelErro.textContent = resultado.status === "sucesso" ? "" : resultado.mensagem || "";
            if (resultado.status === "sucesso") {
                passSection();
            }
        } catch (e) {
            console.error('Erro ao analisar JSON:', e);
            console.log('Resposta recebida:', text);
        }
    })
    .catch(error => {
        console.error('Houve um problema com a requisição:', error);
    });
}

function passSection() {
    const form = document.querySelector("#alterar-senha-form-2");
    form.innerHTML = "";

    const items = {
        label1: createElement('label', { for: 'new-password-2', textContent: 'Nova Senha:' }),
        input1: createElement('input', { type: 'password', id: 'new-password-2', name: 'new-password', required: true }),
        label2: createElement('label', { for: 'confirm-password-2', textContent: 'Confirmar Senha:' }),
        input2: createElement('input', { type: 'password', id: 'confirm-password-2', name: 'confirm-password', required: true }),
        labelError: createElement('div', { id: 'error-2' }),
        submit: createElement('button', { textContent: 'Confirmar' })
    };

    items.submit.addEventListener('click', function (event) {
        event.preventDefault();
        const input1 = document.querySelector('#new-password-2');
        const input2 = document.querySelector('#confirm-password-2');

        if (input1.value && input2.value) {
            if (input1.value === input2.value) {
                fetch('perfil.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ sinal: 'changePass-confirm', dado: input2.value })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => Promise.reject(`Network response was not ok: ${text}`));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'sucesso') {
                        window.location.href = 'perfil.php?id=1';
                    } else {
                        console.log('Resposta inesperada:', data);
                    }
                })
                .catch(error => console.error('Houve um problema com a requisição:', error));
            } else {
                items.labelError.textContent = 'Senhas não coincidem';
            }
        } else {
            items.labelError.textContent = 'Os campos não podem estar vazios';
        }
    });

    Object.values(items).forEach(item => form.appendChild(item));
}

function createElement(tag, attributes) {
    const element = document.createElement(tag);
    Object.assign(element, attributes);
    return element;
}
