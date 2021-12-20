<?php

require_once "../mvc/utill.php";
if (isAppConfigured("../")){
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
    <title>راه اندازی اولیه</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/sweetalert/sweetalert.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body dir="rtl">
    <div class="form">
      <div class="title">خوش آمدید</div>
      <div class="subtitle">قبل از استفاده از برنامه، آن را پیکربندی کنید.</div>
      <div class="input-container ic1">
        <input id="server" dir="ltr" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="server" class="placeholder">سرور</label>
      </div>
      <div class="input-container ic2">
        <input id="port" dir="ltr" class="input" type="number" placeholder=" " />
        <div class="cut"></div>
        <label for="port" class="placeholder">پورت</label>
      </div>
      <div class="input-container ic2">
        <input id="username" dir="ltr" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="username" class="placeholder">نام کاربری</label>
      </div>
      
      <div class="input-container ic2">
        <input id="password" dir="ltr" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="password" class="placeholder">کلمه عبور</label>
      </div>
      
      <div class="input-container ic2">
        <input id="dbName" dir="ltr" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="dbName" class="placeholder">نام پایگاه داده</label>
      </div>
      <button type="text" class="submit" onclick="checkConfig();">ثبت</button>
    </div>
    <script src="assets/js/app.js"></script>
    <script src="../assets/vendor/sweetalert/sweetalert.min.js"></script>
</body>
</html>