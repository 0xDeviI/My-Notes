<?php

require_once "../mvc/utill.php";
require_once "../mvc/dbConnection.php";

if (!isAppConfigured()){
    header("Location: ../setup/");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم یادداشت من</title>
    <link rel="stylesheet" href="../assets/login/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <h2 id="app_header" dir="rtl">وارد حساب كاربری خود شوید، یا حسابی را ایجاد كنید.</h2>
    <div class="container" id="container">
        <div class="div-container sign-up-container">
            <div class="div-form">
                <h1>ساخت حساب</h1>
                <span dir="rtl">حساب كاربری جدیدی را ایجاد كنید.</span>
                <input type="text" id="su_name" maxlength="32" placeholder="نام و نام خانوادگی" />
                <input type="text" id="su_username" maxlength="16" placeholder="نام كاربری" />
                <input type="password" id="su_password" maxlength="32" placeholder="كلمه عبور" />
                <input type="password" id="su_passwordverify" maxlength="32" placeholder="تكرار كلمه عبور" />
                <button onclick="singup();">ثبت نام</button>
            </div>
        </div>
        <div class="div-container sign-in-container">
            <div class="div-form">
                <h1>ورود به حساب</h1>
                <span dir="rtl">اگر حسابی دارید، وارد شوید.</span>
                <input id="si_username" type="text" maxlength="16" placeholder="نام كاربری" />
                <input id="si_password" type="password" maxlength="32" placeholder="كلمه عبور" />
                <button onclick="signin();">ورود به حساب</button>
            </div>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>خوش آمدید</h1>
                    <p dir="rtl">اگر قبلا ثبت نام كرده اید و حساب كاربری دارید، وارد شوید.</p>
                    <button class="ghost" id="signIn">ورود به حساب</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>عضو شوید</h1>
                    <p dir="rtl">اگر هنوز حسابی ندارید، ثبت نام كنید و وارد شوید.</p>
                    <button class="ghost" id="signUp">ثبت نام</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p class="footer_info" dir="rtl">
            ساخته شده توسط <i class="fa fa-heart "></i>
            <a target="_blank " href="https://github.com/0xDeviI">آرمین آصفی</a> - برای مشاهده كد اصلی در node-js
            <a target="_blank " href="https://github.com/0xDeviI/UserSystem">اینجا</a> كلیك كنید.
        </p>
    </footer>
    <script src="../assets/login/js/page.js "></script>
    <script src="../assets/login/js/app.js "></script>
    <script src="../assets/vendor/sweetalert/sweetalert.min.js"></script>

</body>

</html>