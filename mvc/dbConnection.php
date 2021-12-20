<?php

require_once "DataDiagram.php";
require_once "utill.php";

$_CONFIG_ = readJsonConfig();

$DB_HOST = $_CONFIG_["server"];
$DB_PORT = $_CONFIG_["port"];
$DB_USER = $_CONFIG_["username"];
$DB_PASS = $_CONFIG_["password"];
$DB_NAME = $_CONFIG_["dbName"];

function defineStruct($conn){
    $database = new Database($GLOBALS["DB_HOST"], [
        new Table("users", [
            new Column("id", "int", 11, false, true, true),
            new Column("name", "varchar", 255, false, false, false),
            new Column("username", "varchar", 255, false, false, false),
            new Column("password", "varchar", 72, false, false, false)
        ]),
        new Table("notes", [
            new Column("id", "varchar", 36, false, true, false),
            new Column("username", "varchar", 255, false, false, false),
            new Column("title", "varchar", 255, false, false, false),
            new Column("content", "text", 0, false, false, false)
        ])
    ]);

    return $database->createTables($conn);
}

function firstConnect(){
    $conn = @mysqli_connect($GLOBALS["DB_HOST"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASS"], $GLOBALS["DB_NAME"], $GLOBALS["DB_PORT"]);
    return defineStruct($conn) && $conn;
}

function connect(){
    $conn = @mysqli_connect($GLOBALS["DB_HOST"], $GLOBALS["DB_USER"], $GLOBALS["DB_PASS"], $GLOBALS["DB_NAME"], $GLOBALS["DB_PORT"]);
    return $conn;
}



?>