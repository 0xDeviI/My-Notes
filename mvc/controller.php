<?php

session_start();

require_once "utill.php";
require_once "Models/User.php";
require_once "Models/Note.php";
require_once "dbConnection.php";


function hasRequestedFields($requestedFields, $requestMethod)
{
    if ($requestMethod === "POST"){
        foreach ($requestedFields as $field) {
            if (!isset($_POST[$field])) {
                return false;
            }
        }
    } else if ($requestMethod === "GET") {
        foreach ($requestedFields as $field) {
            if (!isset($_GET[$field])) {
                return false;
            }
        }
    }
    return true;
}
function parseRequest($method){
    if ($method == "signup") {
        if (hasRequestedFields(["name", "username", "password"], 
        $_SERVER['REQUEST_METHOD'])){
            $userObject = new User($_POST["name"], $_POST["username"], $_POST["password"], connect());
            if ($userObject->isUserExist()) {
                $response = new CResponse(
                    400,
                    "حساب کاربری با این نام کاربری قبلا ثبت شده است.",
                    null
                );
                echo $response->getResponse();
            } else {
                $userObject->createUser();
                $response = new CResponse(
                    200,
                    "حساب کاربری با موفقیت ایجاد شد",
                    [
                        "name" => safeInput($_POST["name"]),
                        "username" => safeInput($_POST["username"]),
                        "password" => safeInput($_POST["password"])
                    ]
                );
                echo $response->getResponse();
            }
            
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
    else if ($method == "signin"){
        if (hasRequestedFields(["username", "password"], $_SERVER['REQUEST_METHOD'])){
            $userObject = new User("", $_POST["username"], $_POST["password"], connect());
            $loginAttempt = $userObject->login();
            if ($loginAttempt != false) {
                $_SESSION["user"]["name"] = $loginAttempt->getName();
                $_SESSION["user"]["username"] = $loginAttempt->getUsername();
                $_SESSION["user"]["password"] = $loginAttempt->getPassword();
                $response = new CResponse(
                    200,
                    "ورود با موفقیت انجام شد",
                    [
                        "name" => $loginAttempt->getName(),
                        "username" => $loginAttempt->getUsername(),
                        "password" => $loginAttempt->getPassword()
                    ]
                );
                echo $response->getResponse();
            } else {
                $response = new CResponse(
                    400,
                    "نام کاربری یا کلمه عبور اشتباه است",
                    null
                );
                echo $response->getResponse();
            }
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
    else if ($method == "checkConfig"){
        if (hasRequestedFields(["server", "port", "username", "password", "dbName"],
        $_SERVER['REQUEST_METHOD'])){
            $server = safeInput($_POST["server"]);
            $port = intval(safeInput($_POST["port"]));
            $username = safeInput($_POST["username"]);
            $password = safeInput($_POST["password"]);
            $dbName = safeInput($_POST["dbName"]);

            $conn = @mysqli_connect($server, $username, $password, $dbName, $port);
                if ($conn) {
                    saveConfig([
                        "isConfigured" => true,
                        "server" => $server,
                        "port" => $port,
                        "username" => $username,
                        "password" => $password,
                        "dbName" => $dbName
                    ]);
                    $response = new CResponse(200, "اتصال به سرور با موفقیت انجام شد", null);
                    echo $response->getResponse();
                }
                else{
                    $response = new CResponse(400, "خطا در اتصال به سرور", null);
                    echo $response->getResponse();
                }
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
    else if ($method == "addNote"){
        if (hasRequestedFields([
            "title",
            "content",
            "username"
        ], $_SERVER['REQUEST_METHOD'])){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $username = safeInput($_POST["username"]);
            $noteObject = new Note(uuidv4(), $username, $title, $content, connect());
            if ($noteObject->addNote()){
                $response = new CResponse(200, "یادداشت با موفقیت ثبت شد", null);
                echo $response->getResponse();
            }
            else{
                $response = new CResponse(400, "خطا در ثبت یادداشت", null);
                echo $response->getResponse();
            }
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
    else if ($method == "editNote"){
        if (hasRequestedFields([
            "id",
            "title",
            "content",
            "username"
        ], $_SERVER['REQUEST_METHOD'])){
            $id = safeInput($_POST["id"]);
            $title = $_POST["title"];
            $content = $_POST["content"];
            $username = safeInput($_POST["username"]);
            $noteObject = new Note($id, $username, $title, $content, connect());
            if ($noteObject->updateNote()){
                $response = new CResponse(200, "یادداشت با موفقیت ویرایش شد", null);
                echo $response->getResponse();
            }
            else{
                $response = new CResponse(400, "خطا در ویرایش یادداشت", null);
                echo $response->getResponse();
            }
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
    else if ($method == "deleteNote"){
        if (hasRequestedFields(["id"], $_SERVER['REQUEST_METHOD'])){
            $id = $_POST["id"];
            $noteObject = new Note($id, "", "", "", connect());
            if ($noteObject->deleteNote()){
                $response = new CResponse(200, "یادداشت با موفقیت حذف شد", null);
                echo $response->getResponse();
            }
            else{
                $response = new CResponse(400, "خطا در حذف یادداشت", null);
                echo $response->getResponse();
            }
        }
        else{
            $response = new CResponse(400, "خطا در ارسال اطلاعات", null);
            echo $response->getResponse();
        }
    }
}


$method = safeInput($_POST["method"]);
parseRequest($method);

?>