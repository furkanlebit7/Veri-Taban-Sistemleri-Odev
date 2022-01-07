<?php
   include_once "db.php";
  session_start();
  session_destroy();
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='login.css'>
    
    <title>Document</title>
</head>
<body>
<div class="cont">
  <form class="form sign-in" method="POST">
    <h2>Welcome back,</h2>
    <label>
      <span>Email</span>
      <input name="sign_in_email" id="sign_in_email" type="email" />
      <p class="error" id="sign_in_email_error"></p>
    </label>
    <label>
      <span>Password</span>
      <input name="sign_in_password" id="sign_in_password" type="password" />
      <p class="error" id="sign_in_password_error"></p>
    </label>
    <p class="forgot-pass">Forgot password?</p>
    <button name="sign_in_button" type="submit" id="sign_in" class="submit">Sign In</button>
</form>
  <div class="sub-cont">
    <div class="img">
      <div class="img__text m--up">
        <h2>New here?</h2>
        <p>Sign up and discover great amount of new job opportunities!</p>
      </div>
      <div class="img__text m--in">
        <h2>One of us?</h2>
        <p>If you already has an account, just sign in. We've missed you!</p>
      </div>
      <div class="img__btn">
        <span class="m--up">Sign Up</span>
        <span class="m--in">Sign In</span>
      </div>
    </div>
    <form class="form sign-up" method="POST">
      <h2>Time to feel like home,</h2>
     
      <label>
        <span>Email</span>
        <input id="sign_up_email" name="sign_up_email" type="email" />
        <p class="error" id="sign_up_email_error"></p>
      </label>
      <label>
        <span>Password</span>
        <input id="sign_up_password" name="sign_up_password" type="password" />
        <p class="error" id="sign_up_password_error"></p>
      </label>
      <div class="radios">
        <div>
          <input type="radio" name="sign_up_radio"  value="0" checked/>
          <label class="radioLabel">Candidate</label>
        </div>
        <div>
          <input type="radio" name="sign_up_radio"  value="1"/>
          <label class="radioLabel">Employer</label>
        </div>
      </div>
      <button name="sign_up_button" type="submit" id="sign_up" class="submit">Sign Up</button>
</form>
  </div>
</div>
    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
      document.querySelector('.cont').classList.toggle('s--signup');
});

  const signin = document.querySelector("#sign_in");
  const signup = document.querySelector("#sign_up");
  const sign_up_email = document.querySelector("#sign_up_email");
  const sign_up_password = document.querySelector("#sign_up_password");
  const sign_in_email = document.querySelector("#sign_in_email");
  const sign_in_password = document.querySelector("#sign_in_password");
  const sign_up_email_error = document.querySelector("#sign_up_email_error");
  const sign_up_password_error = document.querySelector("#sign_up_password_error");
  const sign_in_email_error = document.querySelector("#sign_in_email_error");
  const sign_in_password_error = document.querySelector("#sign_in_password_error");


  signup.addEventListener("click",(e)=>{
    if(sign_up_email.value=="" || sign_up_password.value==""){
        e.preventDefault();
        if(sign_up_email.value==""){
       sign_up_email_error.innerHTML="email alanı boş olamaz"
      }
      if(sign_up_password.value==""){
        sign_up_password_error.innerHTML="password alanı boş olamaz"
      }
    }
    
  })
  signin.addEventListener("click",(e)=>{
    if(sign_in_email.value=="" || sign_in_password.value==""){
        e.preventDefault();
      if(sign_in_email.value==""){
        sign_in_email_error.innerHTML="email alanı boş olamaz"
      }
      if(sign_in_password.value==""){
        sign_in_password_error.innerHTML="password alanı boş olamaz"
      }
    }
    
  })
    </script>


    <?php
      if(isset($_POST["sign_in_button"])){
       $signInEmail=$_POST["sign_in_email"];
       $signInPassword=$_POST["sign_in_password"];


      $res = mysqli_query($db,"SELECT * FROM users WHERE email='$signInEmail' AND password='$signInPassword'");  
      $res1=mysqli_num_rows($res);
      $row = mysqli_fetch_assoc($res);
      if($res1==1){
        session_start();
        $_SESSION["userEmail"]=$signInEmail;
        $_SESSION["userId"]=$row["id"];
        $_SESSION["userType"]=$row["type"];
        Header("Location:mainPage.php");
       }else{
         ?>
         <script>
           window.onload=function(){
            alert("Hatalı kullanıcı adı veya parola dayı");
           }
        </script>
        <?php
       }
      }
    ?>

    <?php
    if(isset($_POST["sign_up_button"])){
       $signUpEmail=$_POST["sign_up_email"];
       $signUpPassword=$_POST["sign_up_password"];


      $res = mysqli_query($db,"SELECT * FROM users WHERE email='$signUpEmail'");  
      $res1=mysqli_num_rows($res);
      if($res1==1){
        ?>
        <script>
           window.onload=function(){
            alert("Kullanıcı kayıtlı");
           }
        </script>
        <?php
       }else{
        ?>
        <script>
          window.onload=function(){
            alert("Kayıt Başarılı");
          }
        </script>
        <?php
            $insert = mysqli_query($db,"INSERT INTO users (email,password)VALUES('$signUpEmail','$signUpPassword')");
         }
    }
    
    ?>
</body>
</html>