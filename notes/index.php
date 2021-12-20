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
    <title>سيستم ثبت يادداشت ها - <?php echo $note["title"]; ?></title>
    <link rel="stylesheet" href="../assets/notes/css/style.css">
</head>

<body>
    <div id="paper" dir="rtl">
        <div id="pattern">
            <div id="content">
                <h3><?php echo $note["title"]; ?></h3>
                <br>
                <?php echo $note["content"]; ?>
            </div>
        </div>
    </div>
</body>

</html>