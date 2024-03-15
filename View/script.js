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

    setInterval(nextSlide, 3000); // Troca de slide a cada 3 segundos
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

    // xhr.open("POST", "process/delete-cardapio.php", true);

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
    window.location.href = "cardapio-admin.php";
}
