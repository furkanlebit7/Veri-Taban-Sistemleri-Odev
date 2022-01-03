<?php
   include_once "db.php";
  session_start();
  if(!$_SESSION["userId"]){
    Header("Location:login.php");
  }else{
    $idd=$_SESSION["userId"];
    $r = mysqli_query($db,"SELECT * FROM candidates WHERE id='$idd'");
    $r1=mysqli_num_rows($r);
    if($r1){
    Header("Location:profile.php");
    echo "Yönlendir";
    }
    
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Complete Login </title>
    <style>
      .error{color:red;padding:2px 3px;}
    </style>
</head>
<body style="height:100vh;">
    <div class="d-flex align-items-center justify-content-center h-100">
        <div class="card" style="width:40%;">
            <div class="card-body">
                    <div class="mt-4 mb-4 p-3">
                     <form method="POST">
                         <div class="form-group  mt-3">
                          <label for="inputNme4">Name</label>
                          <input type="text" class="form-control" name="candidateName" id="inputNme4" placeholder="Name">
                          <p class="error" id="profile_name_error"></p>
                        </div>
                        <div class="form-group mt-3">
                          <label for="inputSurname4">Surname</label>
                          <input  type="text" class="form-control" name="candidateSurname" id="inputSurname4" placeholder="Surname">
                          <p class="error" id="profile_surname_error"></p>

                        </div>

                        <div class="form-group  mt-3">
                          <label for="inputIdentity4">Identity Number</label>
                          <input class="form-control" id="inputIdentity4" name="inputIdentity4" type="text" placeholder="Identity Number">
                          <p class="error" id="profile_identity_error"></p>

                        </div>
                        <div class="form-group  mt-3">
                          <label for="candidateBirthday">Birth Date</label>
                          <input  type="date" name="candidateBirthday" class="form-control" id="inputBirthday">
                          <p class="error" id="profile_birthday_error"></p>

                        </div>
                        <div class="form-group  mt-3">
                          <img src="<?php echo "photos/user.svg" ?>" alt="..." class="img-thumbnail w-50">
                          <div class="custom-file mt-2">
                            <input type="file" class="custom-file-input" id="inputPhoto" name="inputPhoto">

                          </div>
                        </div>

                      <button type="submit" id="completeProfileSubmit" name="completeProfileSubmit" class="btn btn-primary mt-3">Save</button>
                    </form>
              </div>
            </div>
        </div>
    </div>

    
    <script>
      const submitBtn = document.querySelector("#completeProfileSubmit");
      const name = document.querySelector("#inputNme4");
      const surname = document.querySelector("#inputSurname4");
      const identity = document.querySelector("#inputIdentity4");
      const birthday = document.querySelector("#inputBirthday");
      const photo = document.querySelector("#inputPhoto");
      const profile_name_error = document.querySelector("#profile_name_error");
      const profile_surname_error = document.querySelector("#profile_surname_error");
      const profile_identity_error = document.querySelector("#profile_identity_error");
      const profile_birthday_error = document.querySelector("#profile_birthday_error");
      
      
      submitBtn.addEventListener("click",((e)=>{
        profile_name_error.innerHTML="";
        profile_surname_error.innerHTML="";
        profile_identity_error.innerHTML="";
        profile_birthday_error.innerHTML="";

        if(name.value=="" || name.value.length<=3||name.value.length>16){
          e.preventDefault();
          profile_name_error.innerHTML="İsim alanı 3 ile 16 karakter aralığında olması gerekiyor";
        }else if(surname.value=="" || surname.value.length<=3||surname.value.length>16){
          e.preventDefault();
          profile_surname_error.innerHTML="İsim alanı 3 ile 16 karakter aralığında olması gerekiyor";
        }else if(identity.value=="" || identity.value.length!=11){
           e.preventDefault();
          profile_identity_error.innerHTML="Identity alanı 11 karakter uzunluğunda olmalı";
        }else if(!birthday.value){
          
          console.log(identity.value.length)
          e.preventDefault();
          profile_birthday_error.innerHTML="Paşam alanı doğru gir sana zahmet";
        }
      }))
    </script>
    <?php
            if(isset($_POST["completeProfileSubmit"])){
              $id = $_SESSION["userId"];

              $candidateName=$_POST["candidateName"];
              $candidateSurname=$_POST["candidateSurname"];
              $candidateIdentity=$_POST["inputIdentity4"];
              $candidateBirthday=$_POST["candidateBirthday"];
              $candidatePhoto=$_POST["inputPhoto"];

              $res = mysqli_query($db,"SELECT * FROM candidates WHERE identity_number='$candidateIdentity'");
              $res1=mysqli_num_rows($res);
              if($res1==1){
              ?>
              <script>
              window.onload=function(){
              alert("Identity Number kullanılıyor");
              }
              </script>
              <?php
              }else{
                $res2 = mysqli_query($db,"INSERT candidates VALUES ('$id','$candidateName','$candidateSurname','$candidateIdentity','$candidateBirthday','$candidatePhoto')");
                ?>
                <script>
                window.onload=function(){
                alert("Başarılı");
                }
                </script>
                <?php
                
                //header yollanmıyor fixlenecek hatalar var
              }
            }
          ?>
                



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>