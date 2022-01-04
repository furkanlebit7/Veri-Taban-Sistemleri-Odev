<?php
   include_once "db.php";
  session_start();
  if(!$_SESSION["userId"]){
    Header("Location:login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Profile</title>
</head>
<body>


   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
       <div class="container">
            <a class="navbar-brand" href="#">Career.net</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link" href="#">Jobs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Companies</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/profile.php">Profile</a>
                    </li>
                  </ul>
                </div>
        </div>
    </nav>
    
    <div class="container">
      <div class="row">
        <?php 
                $id = $_SESSION["userId"];

                //gets user
                $userRes = mysqli_query($db,"SELECT * FROM users WHERE id='$id'");
                $userRes1 = mysqli_num_rows($userRes); 
                $userRow = mysqli_fetch_assoc($userRes);

                //gets candidate
                $can = mysqli_query($db,"SELECT * FROM employers WHERE id='$id'");   
                $can1=mysqli_num_rows($can);
                $candidates = mysqli_fetch_assoc($can);
                if($candidates["company_logo"]){
                  $userPhoto = $candidates["company_logo"];
                }else{
                  $userPhoto="user.svg";
                }

                
                ?>
        <div class="col-3">
          <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
            <div class="card p-4">     
              <div class=" image d-flex flex-column justify-content-center align-items-center"> <button class="btn" style="background-color:#212529;"> <img src="photos/<?php echo $userPhoto  ?>" height="100" width="100" /></button> <span class="name mt-3"><?php echo $candidates["company_name"] ?></span>
              <span class="name mt-3"><?php echo $candidates["phone_number"] ?></span>
              
              <a href="<?php echo $candidates["web_adress"] ?>"  type="button" class="btn mt-3 btn-outline-dark">Company Website</a>
              </div>
              </div>  
          </div>
        </div>
              
        <div class="col-9">
          <div class="container mt-4 mb-4 p-3">
                 <form method="POST">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Email</label>
                      <input value="<?php echo $userRow["email"] ?>" type="email" class="form-control" name="companyEmail" placeholder="Email" readonly>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputEmail4">Password</label>
                      <input value="<?php echo $userRow["password"] ?>" type="text" class="form-control" name="companyPassword"  placeholder="Password " >
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputEmail4">Company Name</label>
                      <input value="<?php echo $candidates["company_name"] ?>" type="text" class="form-control" name="companyName" placeholder="Company Name" >
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputPassword4">Web Adress</label>
                      <input value="<?php echo $candidates["web_adress"] ?>" type="text" class="form-control" name="companyWeb" placeholder="Web Address">
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputIdentity4">Phone Number</label>
                      <input value="<?php echo $candidates["phone_number"] ?>" class="form-control"  type="text" placeholder="Phone Number" name="companyPhone">
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <img src="<?php echo "photos/".$userPhoto ?>" alt="..." class="img-thumbnail w-50">
                      <div class="custom-file mt-2">
                        <input type="file" class="custom-file-input"" name="companyPhoto">
                      </div>
                    </div>
                  
                  <button type="submit" name="companyProfileEditSubmit" class="btn btn-primary mt-3">Save</button>
                </form>
          </div>
        </div>

        
      </div>
    </div>
  
     <?php
      if(isset($_POST["companyProfileEditSubmit"])){
        $companyPassword=$_POST["companyPassword"];
        $companyName=$_POST["companyName"];
        $companyWebAdress=$_POST["companyWeb"];
        $companyPhone=$_POST["companyPhone"];
        $companyPhoto=$_POST["companyPhoto"];
        if($companyPhoto){
            $userPhoto=$companyPhoto;
        }
        
        $res = mysqli_query($db,"UPDATE users SET password = '$companyPassword' WHERE id = '$id'");
        $res1 = mysqli_query($db,"UPDATE employers SET company_name = '$companyName', web_adress='$companyWebAdress',phone_number='$companyPhone',company_logo='$userPhoto' WHERE id = '$id'");

        if($res==1 && $res1==1){
            ?>
          <script>
           window.onload=function(){
            alert("Değişiklikler başarılı bir şekilde kaydedildi");
           }
        </script>
          <?php
        }
      }
         ?>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>