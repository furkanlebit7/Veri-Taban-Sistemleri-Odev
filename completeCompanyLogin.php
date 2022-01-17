<?php
   include_once "db.php";
  session_start();
  if(!$_SESSION["userId"]){
    Header("Location:login.php");
  }else{
    $idd=$_SESSION["userId"];
    $r = mysqli_query($db,"SELECT * FROM employers WHERE id='$idd'");
    $r1=mysqli_num_rows($r);
    if($r1){
    Header("Location:companyProfile.php");
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
                         <div class="form-group ">
                          <label for="inputNme4">Company Name</label>
                          <input type="text" class="form-control" name="companyName" id="companyName" placeholder="Name">
                          <p class="error" id="company_name_error"></p>
                        </div>
                        <div class="form-group mt-3">
                          <label for="inputSurname4">Web Adress</label>
                          <input  type="text" class="form-control" name="companyWebAdress" id="companyWebAdress" placeholder="Surname">
                          <p class="error" id="company_web_error"></p>

                        </div>

                        <div class="form-group  mt-3">
                          <label for="inputIdentity4">Phone Number</label>
                          <input class="form-control" name="companyPhone"  id="companyPhone"  type="text" placeholder="Identity Number">
                          <p class="error" id="company_phone_error"></p>

                        </div>
                        <div class="form-group  mt-3">
                          <img src="<?php echo "photos/company.svg" ?>" class="img-thumbnail w-50">
                          <div class="custom-file mt-2">
                            <input type="file" class="custom-file-input" id="companyPhoto" name="companyPhoto">
                          </div>
                        </div>

                      <button type="submit" id="completeCompanySubmit" name="completeCompanySubmit" class="btn btn-primary mt-3">Save</button>
                    </form>
              </div>
            </div>
        </div>
    </div>

    
    <script>
      const submitBtn = document.querySelector("#completeCompanySubmit");
      const companyName = document.querySelector("#companyName");
      const companyWebAdress = document.querySelector("#companyWebAdress");
      const companyPhone = document.querySelector("#companyPhone");
      const birthday = document.querySelector("#companyPhoto");
      const company_name_error = document.querySelector("#company_name_error");
      const company_web_error = document.querySelector("#company_web_error");
      const company_phone_error = document.querySelector("#company_phone_error");
      
      
      submitBtn.addEventListener("click",((e)=>{
        company_name_error.innerHTML="";
        company_web_error.innerHTML="";
        company_phone_error.innerHTML="";

        if(companyName.value=="" || companyName.value.length<=3||companyName.value.length>16){
          e.preventDefault();
          company_name_error.innerHTML="Şirket adı alanı 3 ile 16 karakter aralığında olması gerekiyor";
        }else if(companyWebAdress.value=="" || companyWebAdress.value.length<=3||companyWebAdress.value.length>100){
          e.preventDefault();
          company_web_error.innerHTML="Şirket web adresi alanı 3 ile 100 karakter aralığında olması gerekiyor";
        }else if(companyPhone.value=="" || companyPhone.value.length!=11){
           e.preventDefault();
          company_phone_error.innerHTML="Şirket telefonu alanı 11 karakter uzunluğunda olmalı";
        }
      }))
    </script>
    <?php
            if(isset($_POST["completeCompanySubmit"])){
              $id = $_SESSION["userId"];
              $companyName=$_POST["companyName"];
              $companyWebAdress=$_POST["companyWebAdress"];
              $companyPhone=$_POST["companyPhone"];
              $companyPhoto=$_POST["companyPhoto"];

              $res = mysqli_query($db,"SELECT * FROM employers WHERE web_adress='$companyWebAdress'");
              $res1=mysqli_num_rows($res);
              $ras = mysqli_query($db,"SELECT * FROM employers WHERE phone_number='$companyPhone'");
              $ras1=mysqli_num_rows($ras);
              if($res1==1){
              ?>
              <script>
              window.onload=function(){
              alert("Web Adress Kullanılıyor");
              }
              </script>
              <?php
              }else if($ras1==1){

              ?>
              <script>
              window.onload=function(){
              alert("Telefon numarası kullanılıyor");
              }
              </script>
              <?php
              }
              else{
                $res2 = mysqli_query($db,"INSERT employers VALUES ('$id','$companyName','$companyWebAdress','$companyPhone','$companyPhoto')");
                ?>
                <script>
                window.onload=function(){
                alert("Başarılı");
                window.location.href = "http://localhost/veritabani/companyProfile.php";
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