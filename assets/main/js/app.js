function showNote(noteId) {
    window.location.href = "http://localhost/MyNotes/notes?id=" + noteId;
}

function editNote(noteId) {
    window.location.href = "http://localhost/MyNotes/edit?id=" + noteId;
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


function deleteNote(noteId) {
    $.ajax({
        url: "http://localhost/MyNotes/mvc/controller.php",
        type: "POST",
        data: {
            method: "deleteNote",
            id: noteId
        },
        success: function(data) {
            var jsonParsed = JSON.parse(data);
            if (jsonParsed.status == 200) {
                showSuccessMessage("موفقیت", jsonParsed.message);
                document.getElementById(noteId).remove();
            } else {
                showFailedMessage("خطا", jsonParsed.message);
            }
        },
        error: function(data) {
            showFailedMessage("خطا", "خطايي در ارتباط با سرور رخ داده است");
        }
    });
}