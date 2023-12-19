function check() {
    let submit = document.querySelector("#submit");
    let user = document.querySelector("#username");
    let password = document.querySelector("#password");

    submit.disabled = !(user.value.length > 0 && password.value.length > 0);
    submit.classList.toggle("enabled", !submit.disabled);
}

function enviarFormulario() {
    let formElement = document.querySelector("#form");
    let formData = new FormData(formElement);
  
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "processLogin.php", true);
  
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
                }
            } else {
                console.error("Erro na requisição: " + xhr.status);
            }
        }
    };
  
    xhr.send(formData);
}

document.querySelector("#form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir o envio padrão do formulário
    enviarFormulario();
});