var title = document.getElementById("title");
var textContent = document.getElementById("textcontent");
var userInfo = document.getElementById("userInfo");

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

function showAutoCloseTimerMessage(title, message, time, confirmFunction) {
    swal({
        title: title,
        text: message,
        timer: time,
        type: "success",
        showConfirmButton: false
    }, confirmFunction);
}

function submitNote() {
    if (title.innerHTML.length == 0 || textContent.innerHTML.length == 0) {
        showFailedMessage("خطا", "لطفا همه فیلدها را پر کنید");
    } else {
        var jsonInfoParsed = JSON.parse(userInfo.innerHTML);
        $.ajax({
            url: "http://192.168.1.200/MyNotes/mvc/controller.php",
            type: "POST",
            data: {
                method: "addNote",
                title: title.innerHTML,
                content: textContent.innerHTML,
                username: jsonInfoParsed.username
            },
            success: function(data) {
                var jsonParsed = JSON.parse(data);
                if (jsonParsed.status == 200) {
                    showAutoCloseTimerMessage("موفقیت", jsonParsed.message, 3000, function() {
                        window.location.href = window.location.href.replace("/addnote/", "/");
                    });
                } else {
                    showFailedMessage("خطا", jsonParsed.message);
                }
            },
            error: function(data) {
                showFailedMessage("خطا", "خطايي در ارتباط با سرور رخ داده است");
            }
        });
    }
}