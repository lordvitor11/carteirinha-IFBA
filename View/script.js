function check() {
    let submit = document.querySelector("#submit");
    let user = document.querySelector("#username");
    let password = document.querySelector("#password");

    if (user.value.length > 0 && password.value.length > 0) {
        submit.disabled = false;
        submit.classList.add("enabled");
    } else {
        submit.disabled = true;
        submit.classList.remove("enabled");
    }
}

function enviarFormulario() {
    let formElement = document.querySelector("#form");
    let formData = new FormData(formElement);
  
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "processLogin.php", true);
  
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if (xhr.responseText == "logged") {
            let resultDiv = document.querySelector(".result");

            resultDiv.style.display = "flex";
            resultDiv.style.opacity = "1";

            setTimeout(() => {
                window.location.href = "../index.php";
            }, 2000);
        }

        settim
      }
    };
  
    xhr.send(formData);
}

document.querySelector("#form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir o envio padrão do formulário
    enviarFormulario();
});