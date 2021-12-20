<?php

session_start();

require_once "../mvc/dbConnection.php";
require_once "../mvc/utill.php";
require_once "../mvc/Models/User.php";
require_once "../mvc/Models/Note.php";


if (!isAppConfigured()) {
    header("Location: ../setup/");
    exit();
}

if (!isset($_SESSION["user"])) {
    header("Location: ../account/");
    exit();
} else {
    $user = $_SESSION["user"];
    $userObject = new User($user["name"], $user["username"], $user["password"], connect());
}

if (!isset($_GET["id"])){
    header("Location: ../");
    exit();
}

$id = $_GET["id"];
$noteObject = new Note($id, $user["username"], "", "", connect());
$result = $noteObject->getNote();
if ($result != false) {
    $note = $result;
} else {
    header("Location: ../");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ويرايش يادداشت</title>
    <link rel="stylesheet" href="../assets/notes/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div id="userInfo" hidden>
        <?php
        $jsonObj = (object) array(
            "name" => $userObject->getName(),
            "username" => $userObject->getUsername(),
            "password" => $userObject->getPassword()
        );
        echo json_encode($jsonObj, JSON_UNESCAPED_UNICODE);
        ?>
    </div>
    <div id="paper" dir="rtl">
        <div id="pattern">
            <div id="content">
                <h3 contenteditable="true" id="title" data-text="عنوان را وارد کنید"><?php echo $note["title"]; ?></h3>
                <div id="textcontent" id="text" contenteditable="true" data-text="شروع به نوشتن کنید ..."><?php echo $note["content"]; ?></div>
            </div>
        </div>
    </div>
    <div id="action_bar">
        <button id="submit" onclick="editNote();">ويرايش يادداشت</button>
    </div>
    <script src="../assets/notes/js/editnote.js"></script>
    <script src="../assets/vendor/sweetalert/sweetalert.min.js"></script>
</body>

</html>