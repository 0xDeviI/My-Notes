<?php

require_once "../mvc/dbConnection.php";
if (defineStruct(connect())){
    header("Location: ../");
    exit();
}

?>