function changeRadio(label) {
    let home = document.querySelector("#home-label");
    let menu = document.querySelector("#menu-label");
    
    if (label.id == "menu-label") {
        menu.style.borderBottom = "2px solid #274E13";
        home.style.borderBottom = "2px solid #337A30";

        menu.style.color = "#274E13";
        home.style.color = "white";
    } else {
        home.style.borderBottom = "2px solid #274E13";
        menu.style.borderBottom = "2px solid #337A30";

        home.style.color = "#274E13";
        menu.style.color = "white";
        //
    };
}