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
            return response.text()
        }
        throw new Error(response.statusText)
    })
        .then(function (response) {
            document.getElementById('error').innerHTML = response
            if (response.length > 10) {
                $("#button").addClass("disabled").attr("disabled", true);
            } else {
                $("#button").removeClass("disabled").attr("disabled", false);
            }
        })
}

function succes() {
    $("#succes").removeClass("d-none")
}

function insucces() {
    $("#insucces").removeClass("d-none")
}

let init = function () {
    succes();
}