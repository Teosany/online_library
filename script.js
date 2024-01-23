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
            setTimeout(function() {
                succes.addClass("d-none")}, 2000)
        }
    })
}