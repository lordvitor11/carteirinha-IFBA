document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector(".carousel");
    let currentIndex = 0;
    const items = carousel.querySelectorAll("a").length;

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items;
        updateCarousel();
    }

    function updateCarousel() {
        const translateValue = -320 * currentIndex + "px";
        carousel.style.transform = "translateX(" + translateValue + ")";
    }

    setInterval(nextSlide, 3000);
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

            // Armazena o dia da semana e a data correspondente no objeto
            dias_da_semana_entre_datas[data.toISOString().slice(0, 10)] = diaSemanaNomes[dia_da_semana_numero];
        }

        for (const [data, dia_da_semana] of Object.entries(dias_da_semana_entre_datas)) {
            // Divs
            let divItem = document.createElement('div');
            let divPrincipal = document.createElement('div');
            let divAcompanhamento = document.createElement('div');
            let divSobremesa = document.createElement('div');

            // Content
            let labelPrincipal = document.createElement('label');
            let inputPrincipal = document.createElement('input');

            let labelAcompanhamento = document.createElement('label');
            let inputAcompanhamento = document.createElement('input');

            let labelSobremesa = document.createElement('label');
            let inputSobremesa = document.createElement('input');

            // Configuração dos componentes
            divItem.classList.add('dia-semana');

            // Proteína
            labelPrincipal.setAttribute('id', dia_da_semana);
            labelPrincipal.setAttribute('name', dia_da_semana);
            labelPrincipal.textContent = dia_da_semana.charAt(0).toUpperCase() + dia_da_semana.slice(1).toLowerCase() + '-feira';

            inputPrincipal.setAttribute('id', dia_da_semana);
            inputPrincipal.setAttribute('name', dia_da_semana);
            inputPrincipal.setAttribute('placeholder', 'Proteína');
            inputPrincipal.required = true;

            // Acompanhamento
            labelAcompanhamento.setAttribute('id', 'acompanhamento-' + dia_da_semana);
            labelAcompanhamento.setAttribute('name', 'acompanhamento-' + dia_da_semana);
            labelAcompanhamento.textContent = "‎ ";

            inputAcompanhamento.setAttribute('id', 'acompanhamento-' + dia_da_semana);
            inputAcompanhamento.setAttribute('name', 'acompanhamento-' + dia_da_semana);
            inputAcompanhamento.setAttribute('placeholder', 'Acompanhamento');

            // Sobremesa
            labelSobremesa.setAttribute('id', 'sobremesa-' + dia_da_semana);
            labelSobremesa.setAttribute('name', 'sobremesa-' + dia_da_semana);
            labelSobremesa.textContent = "‎ ";

            inputSobremesa.setAttribute('id', 'sobremesa-' + dia_da_semana);
            inputSobremesa.setAttribute('name', 'sobremesa-' + dia_da_semana);
            inputSobremesa.setAttribute('placeholder', 'Sobremesa');

            // Adição dos componentes aos componetes pais
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

function showHistPopup() {
    const div = document.querySelector('.popup-historico');
    div.style.opacity = "1";
    div.classList.add('show');
}

function getData(dataUser) {
    return `${dataUser[8]}${dataUser[9]}/${dataUser[5]}${dataUser[6]}`;
}

function showInfo(btn) {
    showHistPopup();

    const popup = document.querySelector('.popup-content .semana');
    let h2Data = document.querySelector('#data');
    let idsRaw = btn.classList[2];
    let ids;

    if (idsRaw.length === 5) {
        ids = idsRaw.split('').map(numero => parseInt(numero, 10));
    } else if (idsRaw.length === 6) {
        let temp = idsRaw.split('');
        temp[0] = `${temp[0]}${temp[1]}`;
        temp = temp.map(numero => parseInt(numero, 10));
        temp.splice(1, 1);
        ids = temp;
    } else {
        let temp = [];
        for (let i = 0; i < btn.classList[2].length; i += 2) {
            let parDeNumeros = btn.classList[2].substring(i, i + 2);
            temp.push(parseInt(parDeNumeros));
        }

        ids = temp;
    }

    $.ajax({
        url: "historico.php",
        type: "POST",
        data: { sinal: JSON.stringify(ids) },
        success: function(response) {
            let responseJson = JSON.parse(response);
            popup.innerHTML = "";

            h2Data.textContent = `CARDÁPIO (${getData(responseJson[0].data_refeicao)} - ${getData(responseJson[4].data_refeicao)})`;

            for (let c = 0; c < responseJson.length; c++) {
                let tr = document.createElement('tr');
                let td1 = document.createElement('td');
                let td2 = document.createElement('td');
                let td3 = document.createElement('td');
                let td4 = document.createElement('td');
                let data = getData(responseJson[c].data_refeicao);

                td1.textContent = responseJson[c].dia.charAt(0).toUpperCase() + responseJson[c].dia.slice(1).toLowerCase() + `-feira (${data})`;
                td2.textContent = responseJson[c].principal;
                td3.textContent = responseJson[c].acompanhamento;
                td4.textContent = responseJson[c].sobremesa;

                tr.appendChild(td1);
                tr.appendChild(td2);
                tr.appendChild(td3);
                tr.appendChild(td4);

                popup.appendChild(tr);
            }
        },
        error: function(xhr, status, error) {
            console.error("Erro ao enviar sinal: " + error);
        }
    });
}

function addListener() {
    const buttons = document.querySelectorAll('button.historico');

    for (let c = 0; c < buttons.length; c++) {
        buttons[c].addEventListener('click', function() {
            showInfo(this);
        });
    }
}

function reservaCancelada(popup) {
    popup.innerHTML = "";

    const h2 = document.createElement("h2"); 
    const btnConfirm = document.createElement("button");

    btnConfirm.setAttribute("type", "button");
    h2.textContent = "Reserva Cancelada!";
    btnConfirm.textContent = "Fechar";

    btnConfirm.addEventListener("click", closeAgendadosPopup());

}

function agendadosPopup(type) {
    const popup = document.querySelector("#popup");
    const h2 = document.createElement("h2"); 
    const inputMotivo = document.createElement("input");
    const divButtons = document.createElement("div");
    const btnConfirm = document.createElement("button");
    const btnCancel = document.createElement("button");
    const p = document.createElement("label");

    popup.innerHTML = "";

    inputMotivo.setAttribute("id", "outro");
    inputMotivo.setAttribute("name", "outro");
    inputMotivo.setAttribute("placeholder", "Digite o motivo...");

    divButtons.classList.add("botao-container");
    btnConfirm.setAttribute("type", "submit");
    btnConfirm.classList.add("validar");
    btnCancel.classList.add("cancelar");

    divButtons.appendChild(btnCancel);
    divButtons.appendChild(btnConfirm);

    btnCancel.addEventListener("click", closeAgendadosPopup);
    btnConfirm.addEventListener("click", function() {
        console.log("entrou");
        const value = inputMotivo.textContent;

        fetch('processa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'motivo': value
            })
        })
        .then(response => response.text())
        .then(data => {
            if (data === "sucesso") {
                reservaCancelada(popup);
            } else {

            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });

    p.textContent = "MOTIVO:";
    h2.textContent = "CANCELAR RESERVA";

    popup.appendChild(h2);
    popup.appendChild(p);
    popup.appendChild(inputMotivo);

    if (type != 1) {
        const optP = document.createElement("label");
        const inputMatricula = document.createElement("input");

        inputMatricula.setAttribute("id", "outro");
        inputMatricula.setAttribute("name", "outro");
        inputMatricula.setAttribute("placeholder", "Matrícula alvo");

        optP.textContent = "MATRÍCULA";
        h2.textContent = "DISPONIBILIZAR RESERVA";

        popup.appendChild(optP);
        popup.appendChild(inputMatricula);
    }

    popup.appendChild(divButtons);    
    popup.style.opacity = 1;

    document.querySelector('.container').classList.add("blur");
}

function closeAgendadosPopup() {
    const popup = document.querySelector("#popup");
    popup.style.opacity = 0;
    document.querySelector('.container').classList.remove("blur");
}