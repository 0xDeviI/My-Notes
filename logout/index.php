<?php

session_start();

require_once "../mvc/dbConnection.php";
require_once "../mvc/utill.php";
require_once "../mvc/Models/User.php";


if (!isAppConfigured()) {
  header("Location: ../setup/");
  exit();
}

session_destroy();
header("Location: ../account/");
exit();

?>