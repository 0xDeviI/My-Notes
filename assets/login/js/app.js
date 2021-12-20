//* Primary Inputs
var header = document.getElementById("app_header");
var forms = document.getElementById("container");
var dashboard = document.getElementById("dashboard");

//! Sign-in Inputs
var signInUsername = document.getElementById("si_username");
var signInPassword = document.getElementById("si_password");

//? Sign-up Inputs
var signUpName = document.getElementById("su_name");
var signUpUsername = document.getElementById("su_username");
var signUpPassword = document.getElementById("su_password");
var signUpPasswordVerify = document.getElementById("su_passwordverify");


//* Application Functions
//TODO: User will not interact with these functions directly.
//TODO: these functions will call from client methods.
function logout() {
    if (localStorage.getItem("loggedIn") != null)
        localStorage.removeItem("loggedIn");
    if (localStorage.getItem("loggedIn_user") != null)
        localStorage.removeItem("loggedIn_user");
    location.reload();
}

function isValidName(name) {
    var p = /^[a-zA-Z\u0600-\u06FF\s]+$/;

    if (!p.test(name)) {
        return false;
    } else {
        return true;
    }
}

function isValidUserName(username) {
    var p = /^[a-zA-Z0-9\s]+$/;

    if (!p.test(username)) {
        return false;
    } else {
        return true;
    }
}

function isValidPassword(password) {
    var p = /^[a-zA-Z0-9!@#$\s]+$/;

    if (!p.test(password)) {
        return false;
    } else {
        return true;
    }
}

function isValidEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function isValidSignupCondition() {
    return signUpName.value != "" && signUpUsername.value != "" &&
        signUpPassword.value != "" && signUpPassword.value === signUpPasswordVerify.value &&
        isValidName(signUpName.value) && isValidUserName(signUpUsername.value);
}

function isValidSigninCondition() {
    return signInUsername.value != "" && signInPassword.value != "" && isValidUserName(signInUsername.value) &&
        isValidPassword(signInPassword.value);
}

function clearSignUpFields() {
    signUpName.value = "";
    signUpUsername.value = "";
    signUpPassword.value = "";
    signUpPasswordVerify.value = "";
}

function showSuccessMessage(title, message) {
    swal(
        title,
        message,
        "success"
    );
}

function showFailedMessage(title, message) {
    swal(
        title,
        message,
        "error"
    );
}

function showAutoCloseTimerMessage(title, message, time) {
    swal({
        title: title,
        text: message,
        timer: time,
        showConfirmButton: false
    }, function() {
        window.location.href = window.location.href.replace("/account/", "/");
    });
}

// ------------------------------------------------------------------------

//* Client Functions
//TODO: User will interact with these functions directly.
function singup() {
    if (isValidSignupCondition()) {
        $.ajax({
            type: "POST",
            url: "http://localhost/MyNotes/mvc/controller.php",
            data: {
                method: "signup",
                name: signUpName.value,
                username: signUpUsername.value,
                password: signUpPassword.value
            },
            cache: false,
            success: function(html) {
                var parsedJson = JSON.parse(html);
                if (parsedJson["status"] == 200) {
                    clearSignUpFields();
                    showSuccessMessage("موفق", parsedJson["message"]);
                } else {
                    showFailedMessage("خطا", parsedJson["message"]);
                }
            },
            error: function(html) {
                showFailedMessage("خطا", "خطا در برقراری ارتباط با سرور!");
            }
        });
    } else
        showFailedMessage("خطا", "ورودي ها كامل نيستند يا كلمه عبور مشابه نيست.");
}

function signin() {
    if (isValidSigninCondition()) {
        $.ajax({
            type: "POST",
            url: "http://localhost/MyNotes/mvc/controller.php",
            data: {
                method: "signin",
                username: signInUsername.value,
                password: signInPassword.value
            },
            cache: false,
            success: function(html) {
                var parsedJson = JSON.parse(html);
                if (parsedJson["status"] == 200) {
                    showAutoCloseTimerMessage("موفق", parsedJson["message"] + "\n کمی صبر کنید، به حساب کاربری منتقل می شوید.", 3500);
                } else {
                    showFailedMessage("خطا", parsedJson["message"]);
                }
            },
            error: function(html) {
                showFailedMessage("خطا", "خطا در برقراری ارتباط با سرور!");
            }
        });
    } else
        showFailedMessage("خطا", "ورودي ها كامل نيستند يا كلمه عبور مشابه نيست.");
}