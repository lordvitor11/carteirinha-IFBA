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