function valid() {
    let password = document.getElementById('password').value;
    let passwordConf = document.getElementById('passwordConf').value;
    if (password === passwordConf) {
        return true
    } else {
        document.getElementById('passwordError').innerHTML = "Le mot de passe n'a pas été saisi correctement !"
        setTimeout(() => {
            document.getElementById('passwordError').innerHTML = ""
        }, 3000)
        return false
    }
}

async function checkAvailability(email) {
    await fetch(`check_availability.php/?email=${email}`, {
        method: 'GET'
    }).then(function (response) {
        if (response.status >= 200 && response.status < 300) {
            return response.json()
        }
        throw new Error(response.statusText)
    })
        .then(function (data) {
            document.getElementById('error').innerHTML = data.rep
            if (data.rep.length > 15) {
                $("#button").addClass("disabled").attr("disabled", true);
            } else {
                $("#button").removeClass("disabled").attr("disabled", false);
            }
        })
}

async function checkId(id) {
    if (id !== '') {
        $.ajax({
            type: 'POST',
            url: 'get_reader&book.php',
            data: {id: id}
        }).done(function (msg) {
            messageMsg('#messageId', msg, 'Utilisateur introuvable')
        })
    } else {
        $(messageId).addClass("d-none")
    }
}

async function checkIsbn(isbn) {
    if (isbn !== '') {
        $.ajax({
            type: 'POST',
            url: 'get_reader&book.php',
            data: {isbn: isbn}
        }).done(function (msg) {
            messageMsg('#messageIsbn', msg, 'ISBN introuvable')
        })
    } else {
        console.log(isbn)
        $(messageIsbn).addClass("d-none")
    }
}

function messageMsg(messageId, msg, error) {
    if (msg !== '0') {
        if (msg == '-1') {
            $(messageId).removeClass("d-none alert-primary")
            $(messageId).addClass("alert-danger")
            $(messageId).text('Utilisateur bloqué ou supprimé')

            $("#button").addClass("disabled").attr("disabled", true);
        } else {
            $(messageId).removeClass("d-none alert-danger")
            $(messageId).addClass("alert-primary")
            $(messageId).text(msg)

            $("#button").removeClass("disabled").attr("disabled", false);
        }
    } else {
        $(messageId).removeClass("d-none alert-primary")
        $(messageId).addClass("alert-danger")
        $(messageId).text(error)

        $("#button").addClass("disabled").attr("disabled", true);
    }
}

function succes() {
    $("#succes").removeClass("d-none")
    setTimeout(function () {
        $("#succes").addClass("d-none")
    }, 2000)
}

function insucces() {
    $("#insucces").removeClass("d-none")
    setTimeout(function () {
        $("#insucces").addClass("d-none")
    }, 2000)
}

$('.blurControl').on("blur", function () {
    ajax(this.name, this.value)
});


function ajax(nameVar, value) {
    let updateTime = document.getElementById('disabledTextInput1')

    $.ajax({
        type: 'POST',
        url: 'my-profile.php',
        data: {name: nameVar, data: value}
    }).done(function (msg) {
        if (msg.length > 5) {
            updateTime.placeholder = msg;
            let succes = $("#succes")
            succes.removeClass("d-none")
            setTimeout(function () {
                succes.addClass("d-none")
            }, 2000)
        }
    })
}

function getContent(int) {
    document.getElementById("my-textarea" + int).value = document.getElementById("titre" + int).innerText;
    document.getElementById("my-textarea_1" + int).value = document.getElementById("titre_1" + int).innerText;
    document.getElementById("my-textarea_2" + int).value = document.getElementById("titre_2" + int).innerText;
}

function preventDef(event, maxLength) {
    /* Any Shortcut except Ctrl + V */
    const isValidShortcut = (event.ctrlKey && event.keyCode != 86);
    /* Backspace - Delete - Arrow Keys - Ctrl - Shift */
    const isValidKeyCode = [8, 16, 17, 37, 38, 39, 40, 46].includes(event.keyCode);
    const text = event.target.innerText;
    if (text.length >= maxLength && !isValidKeyCode && !isValidShortcut) {
        event.preventDefault();
    }
}

$('.onlyInt').keypress(function (e) {
    var x = event.charCode || event.keyCode;
    if (isNaN(String.fromCharCode(e.which)) && x != 45 && x != 46 || x === 32 || x === 13 || (x === 46 && event.currentTarget.innerText.includes('.'))) e.preventDefault();
});