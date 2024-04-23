<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user['password'])) {

        session_start();

        session_start();

        session_regenerate_id();

//            this is to increase the security of
// our website and prevent a session fixation attack
        $_SESSION["user_id"] = $user["user_id"];
        header("Location: /MainProgram/MainPage/mainLoged.php");
        exit();
    } else {
        $is_invalid = true;
    }
}


if ($is_invalid) {
  ?>

    <script> alert("Wrong Email or Password");</script>
    
    <?php
}


?>
<!--  -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Carvan IO Login</title>
  <link rel="stylesheet" href="login.css">

</head>
<body>

<main>




<!-- main block of whole form -->
<div class="loginForm" >
  <!--form with pictures -->
  <div class="picture-form">
    <div id="img"> </div>
  </div>
  <!--Form block where username and password blocks are,  with post method  -->
  <form   method="POST" class="all-func-loginForm">
    <h1>User Login</h1>
    <!-- div block that resposible for username label and input -->
    <div class="form-username">
      <label class="form-label">Email</label>
        <input class="form-input-username" placeholder="login@.something.com" type="text" name="email">
    </div>
    <!--div with password input and label -->
    <div class ="form-password">
      <label class="form-password-label">Password</label>
        <input class="form-input-password" placeholder="0-9_a-Z!" type="password" required name="password">
        <i class="fa fa-eye togglePassword"></i>
    </div>
      <!--forgot your password block with hyperlink -->
    <div class="hyper-link-form1">
      <a href="/MainProgram/loginFormFolder/forgottenPassoword.html">Forgot your password?</a>
    </div>
    <!-- block with buttons -->
      <div class="buttons">
        <button type="submit" class="button-1">Login</button>
      </div>
      <!-- hyperlink dont have account -->
    <div class="hyper-link-form2">
      <label class="next-url">Don't have account? </label>
      <a href="/MainProgram/regestration/regestr.html">Create account</a>
    </div>

  </form>
</div>

</main>

<script src="loginForm.js"></script>

</body>
</html>