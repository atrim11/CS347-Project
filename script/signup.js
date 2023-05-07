var password = document.getElementById("Password");
password.oninput = function verifyPassword() {

    var letter = document.getElementById("password_letter");
    var number = document.getElementById("password_number");
    var symbol = document.getElementById("password_symbol");
    var length = document.getElementById("password_length");

    var invalid = "&#x274C";
    var valid = "&#x2713;";

    var accepted_letters = /[a-zA-Z]/g;
    if (password.value.match(accepted_letters)) {
        letter.innerHTML = `${valid} Password contains at least <b>one letter</b>.`;
        letter.classList.remove("invalid");
        letter.classList.add("valid");
    } else {
        letter.innerHTML = `${invalid} Password contains at least <b>one letter</b>.`;
        letter.classList.remove("valid");
        letter.classList.add("invalid");
    }

    var accepted_numbers = /[0-9]/g;
    if (password.value.match(accepted_numbers)) {
        number.innerHTML = `${valid} Password contains at least <b>one number</b>.`;
        number.classList.remove("invalid");
        number.classList.add("valid");
    } else {
        number.innerHTML = `${invalid} Password contains at least <b>one number</b>.`;
        number.classList.remove("valid");
        number.classList.add("invalid");
    }

    var accepted_symbols = /[~`!@#\$%\^&\*_:;",.\?\/]/g;
    var not_accepted = /[<>\[\]\\'\(\)\-\+\=\{\}]/g;
    if (password.value.match(accepted_symbols) && !password.value.match(not_accepted)) {
        symbol.innerHTML = `${valid} Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~\`!@#$%^&*_:;",.?/<br>Not Allowed Symbols: <>[]'()\+-={}`;
        symbol.classList.remove("invalid");
        symbol.classList.add("valid");
    } else {
        symbol.innerHTML = `${invalid} Password contains at least <b>one symbol</b>.<br>Allowed Symbols: ~\`!@#$%^&*_:;",.?/<br>Not Allowed Symbols: <>[]'()\+-={}`;
        symbol.classList.remove("valid");
        symbol.classList.add("invalid");
    }

    if (password.value.length > 7) {
        length.innerHTML = `${valid} Password must be at least <b>7 characters</b> in length.`;
        length.classList.remove("invalid");
        length.classList.add("valid");
    } else {
        length.innerHTML = `${invalid} Password must be at least <b>7 characters</b> in length.`;
        length.classList.remove("valid");
        length.classList.add("invalid");
    }
}

function submitPasswordValid() {
    var letter = document.getElementById("password_letter");
    var number = document.getElementById("password_number");
    var symbol = document.getElementById("password_symbol");
    var length = document.getElementById("password_length");

    console.log(letter.classList.contains("valid"));
    console.log(number.classList.contains("valid"));
    console.log(symbol.classList.contains("valid"));
    console.log(length.classList.contains("valid"));

    if (letter.classList.contains("valid") && number.classList.contains("valid") &&
        symbol.classList.contains("valid") && length.classList.contains("valid")) {
        return true;
    } else {
        alert("Password doesn't meet the requirements. Please type a password that meets them and try again.");
        return false;
    }
}


