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
            <a class="navbar-brand" href="http://localhost/veritabani/mainPage.php">Career.net</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <?php
                    if($_SESSION["userType"]==0){
                      ?>  
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/jobAdvertisements.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/companies.php">Companies</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/blogs.php">Blogs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/editProfile.php">My Links</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/resume.php">Resume</a>
                    </li>
                      <?php
                    }else{
                      ?>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/jobAdvertisements.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/companies.php">Companies</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/blogs.php">Blogs</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/companyProfile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/companyBlogs.php">My Blog</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/companyAdvertisements.php">My Advertisements</a>
                    </li>
                      <?php
                    }
                    ?>
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
                $can = mysqli_query($db,"SELECT * FROM candidates WHERE id='$id'");   
                $can1=mysqli_num_rows($can);
                $candidates = mysqli_fetch_assoc($can);
                if($candidates["photo"]){
                  $userPhoto = $candidates["photo"];
                }else{
                  $userPhoto="user.svg";
                }

                //gets resume
                $res = mysqli_query($db,"SELECT * FROM resumes WHERE candidate_id='$id'");   
                $res1=mysqli_num_rows($res);
                $row = mysqli_fetch_assoc($res);
                $counter = 0;
                
                ?>
                  <div class="col-3">
                    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
                      <div class="card p-4">     
                        <div class=" image d-flex flex-column justify-content-center align-items-center"> <button class="btn" style="background-color:#212529;"> <img src="photos/<?php echo $userPhoto  ?>" height="100" width="100" /></button> <span class="name mt-3"><?php echo $candidates["first_name"]." ".$candidates["last_name"] ?></span> <span class="idd"><?php echo "@".strtolower($candidates["first_name"]).strtolower($candidates["last_name"]) ?></span>
                        
                        <?php
                        
                          if($res1==1 && $row["description"]){?>
                            <div class="text text-center mt-3"> <span><?php echo $row["description"] ?> </span> </div>
                          <?php
                          $counter+=1;
                          }
                        ?>
                        
                        <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                          <?php
                          if($res1==1 && $row["candidate_linkedin"]){?>
                          <a href="<?php echo $row["candidate_linkedin"] ?>" class="btn"><i class="fab fa-2x fa-linkedin"></i></a>
                          <?php
                          $counter+=1;
                          }
                        ?>
                        <?php
                          if($res1==1 && $row["candidate_github"]){?>
                          <a href="<?php echo $row["candidate_github"] ?>" class="btn"><i class="fab fa-2x fa-github"></i></a>
                          <?php
                          $counter+=1;
                          }
                          if($counter!=3){?>
                        <div class=" d-flex mt-2"> <a href="http://localhost/veritabani/editProfile.php" class="btn1 btn btn-dark">Edit Profile</a> </div>
                        <?php
                        }
                        ?>
                        </div>
                        <div class=" px-2 rounded mt-4 date "> <span class="join"><?php echo "????".$candidates["birth_date"]."????" ?></span> </div>
                      </div>
                   </div>
                  </div>
                </div>
              
        <div class="col-9">
          <div class="container mt-4 mb-4 p-3">
                 <form method="POST">
                  <div class="form-row d-flex justify-content-between">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Email</label>
                      <input value="<?php echo $userRow["email"] ?>" type="email" class="form-control" name="candidateEmail" id="inputEmail4" placeholder="Email " readonly>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Password</label>
                      <input value="<?php echo $userRow["password"] ?>" type="password" class="form-control" name="candidatePassword" id="inputPassword4" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-row d-flex justify-content-between">
                     <div class="form-group col-md-6 mt-3">
                      <label for="inputNme4">Name</label>
                      <input value="<?php echo $candidates["first_name"] ?>" type="text" class="form-control" name="candidateName" id="inputNme4" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputSurname4">Surname</label>
                      <input value="<?php echo $candidates["last_name"] ?>" type="text" class="form-control" name="candidateSurname" id="inputSurname4" placeholder="Surname">
                    </div>
                  </div>
                   
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputIdentity4">Identity Number</label>
                      <input value="<?php echo $candidates["identity_number"]; ?>" class="form-control" id="inputIdentity4" type="text" placeholder="identity" readonly>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <label for="inputCity">Birth Date</label>
                      <input value="<?php echo $candidates["birth_date"]; ?>" type="date" name="candidateBirthday" class="form-control" id="inputBirthday" readonly>
                    </div>
                    <div class="form-group col-md-6 mt-3">
                      <img src="<?php echo "photos/".$userPhoto ?>" alt="..." class="img-thumbnail w-50">
                      <div class="custom-file mt-2">
                        <input type="file" class="custom-file-input" id="inputPhoto" name="inputPhoto">
                      </div>
                    </div>
                  
                  <button type="submit" id="profileSubmit" name="profileSubmit" class="btn btn-primary mt-3">Save</button>
                </form>
          </div>
        </div>
      </div>
    </div>
  
     <?php
      if(isset($_POST["profileSubmit"])){
        $candidatePassword=$_POST["candidatePassword"];
        $candidateName=$_POST["candidateName"];
        $candidateSurname=$_POST["candidateSurname"];
        $candidatePhoto=$_POST["inputPhoto"];

        
        $res = mysqli_query($db,"UPDATE users SET password = '$candidatePassword' WHERE id = '$id'");
        $res = mysqli_query($db,"UPDATE candidates SET first_name = '$candidateName', last_name='$candidateSurname',photo='$candidatePhoto' WHERE id = '$id'");
      }
         ?>





<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>