<?php

session_start();

require_once "mvc/dbConnection.php";
require_once "mvc/utill.php";
require_once "mvc/Models/User.php";
require_once "mvc/Models/Note.php";


if (!isAppConfigured()) {
  header("Location: setup/");
  exit();
}

if (!isset($_SESSION["user"])) {
  header("Location: account/");
  exit();
} else {
  $user = $_SESSION["user"];
  $userObject = new User($user["name"], $user["username"], $user["password"], connect());
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>سیستم ثبت یادداشت ها</title>
  <link rel="stylesheet" href="assets/main/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="assets/vendor/sweetalert/sweetalert.css">
</head>

<body>
  <h4>سیستم ثبت یادداشت ها - سلام <?php echo $userObject->getName() ?> عزيز</h4>
  <div id="tableContainer" dir="rtl">
    <table>
      <tr>
        <th>شناسه</th>
        <th>عنوان</th>
        <th>عملیات</th>
      </tr>
      <?php
      $noteObject = new Note("", $userObject->getUsername(), "", "", connect());
      $notes = $noteObject->getNotes();
      foreach ($notes as $note) {
        echo "<tr id='" . $note["id"] . "'>";
        echo "<td class='autoWidth'>" . $note["id"] . "</td>";
        echo "<td class='autoWidth'>" . $note["title"] . "</td>";
        echo "<td class='autoWidth'>";
        echo "<button id='tableActionButtonBlue' onclick='showNote(\"" . $note["id"] . "\")'>مشاهده</button>";
        echo " | ";
        echo "<button id='tableActionButtonGreen' onclick='editNote(\"" . $note["id"] . "\")'>ویرایش</button>";
        echo " | ";
        echo "<button id='tableActionButtonRed' onclick='deleteNote(\"" . $note["id"] . "\")'>حذف</button>";
        echo "</td>";
        echo "</tr>";
      }
      ?>
    </table>
  </div>
  <div class="adminActions">
    <input type="checkbox" name="adminToggle" class="adminToggle" />
    <a class="adminButton" href="#!"><i class="fa fa-cog"></i></a>
    <div class="adminButtons">
      <a href="logout" title="خروج از حساب"><i class="fa fa-sign-out"></i></a>
      <a href="addnote" title="افزودن یادداشت"><i class="fa fa-pencil"></i></a>
    </div>
  </div>
  <script src="assets/main/js/app.js"></script>
  <script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
</body>

</html>