document.addEventListener("DOMContentLoaded", function() {
    var carousel = document.querySelector(".carousel");
    var currentIndex = 0;
    var items = carousel.querySelectorAll("a").length;

    function nextSlide() {
        currentIndex = (currentIndex + 1) % items;
        updateCarousel();
    }

    function updateCarousel() {
        var translateValue = -320 * currentIndex + "px";
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
    xhr.open("POST", "process/processLogin.php", true);

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

function excluirCardapio() {
    let xhr = new XMLHttpRequest();

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById("resultado").innerHTML = xhr.responseText;
        } else {
            console.error("Erro na requisição AJAX:", xhr.statusText);
        }
    };

    xhr.send();
}

function adicionarCardapio() {
    window.location.href = "cardapio-criar.php";
}

function cancelarCardapio() {
    window.location.href = "cardapio.php";
}

function addFields() {
    const data_inicio = document.querySelector('#data-inicio').value;
    const data_fim = document.querySelector('#data-fim').value;

    if (data_inicio != "" || data_fim != "") {
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
    let container = document.querySelector('.container');
    let div = document.createElement('div');
    let label = document.createElement('span');
    let confirmBtn = document.createElement('button');
    let cancelBtn = document.createElement('button');
    let divBtns = document.createElement('div');
    let imgValidar = document.createElement('img');
    let imgCancelar = document.createElement('img');

    imgValidar.setAttribute('src', '../assets/validar-100px.png');
    imgCancelar.setAttribute('src', '../assets/cancelar-100px.png');

    label.textContent = 'Excluir Cardápio?';

    confirmBtn.addEventListener('click', () => {
        $.ajax({
            url: "cardapio.php",
            type: "POST",
            data: { sinal: "Sinal enviado!" },
            success: function(response) {
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
    });

    div.classList.add('popup');
    divBtns.classList.add('div-btns');

    div.appendChild(label);
    confirmBtn.appendChild(imgValidar);
    cancelBtn.appendChild(imgCancelar);
    divBtns.appendChild(cancelBtn);
    divBtns.appendChild(confirmBtn);
    div.appendChild(divBtns);

    container.appendChild(div);

    document.body.classList.add('popup-open');
}
