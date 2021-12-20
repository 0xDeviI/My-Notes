var server = document.getElementById("server");
var port = document.getElementById("port");
var username = document.getElementById("username");
var password = document.getElementById("password");
var dbName = document.getElementById("dbName");

function showSuccessMessage(title, message) {
    swal(
        title,
        message,
        "success"
    );
}

function showSuccessMessageConfirm(title, message) {
    swal({
        title: title,
        text: message,
        type: "success",
        closeOnConfirm: false,
    }, function(confirm) {
        if (confirm) {
            window.location.href = window.location.href.replace("/setup/", "/install/");
        }
    });
}

function showFailedMessage(title, message) {
    swal(
        title,
        message,
        "error"
    );
}

function isSafeInput(input) {
    if (input.length == 0)
        return true;
    return /^[a-zA-Z0-9_/:.]+$/.test(input);
}

function checkConfig() {
    if (server.value != "" && port.value != "" && username.value != "" &&
        dbName.value != "") {
        if (isSafeInput(server.value) && isSafeInput(port.value) && isSafeInput(username.value) &&
            isSafeInput(dbName.value) && isSafeInput(password.value)) {
            // send ajax request
            $.ajax({
                url: "../mvc/controller.php",
                type: "POST",
                data: {
                    method: "checkConfig",
                    server: server.value,
                    port: port.value,
                    username: username.value,
                    password: password.value,
                    dbName: dbName.value
                },
                success: function(data) {
                    var jsonParsed = JSON.parse(data);
                    if (jsonParsed.status == 200) {
                        showSuccessMessageConfirm("موفق", jsonParsed.message);
                    } else {
                        showFailedMessage("خطا", jsonParsed.message);
                    }
                },
                error: function(data) {
                    showFailedMessage("خطا", "خطایی در ارتباط با سرور رخ داده است");
                }
            });
            return true;
        } else {
            showFailedMessage("خطا", "اطلاعات وارد شده صحیح نیست");
        }
    } else {
        showFailedMessage("خطا", "لطفا همه فیلدهای الزامی را پر کنید");
    }
}