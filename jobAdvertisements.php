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
                        <div class=" px-2 rounded mt-4 date "> <span class="join"><?php echo "👉".$candidates["birth_date"]."👈" ?></span> </div>
                      </div>
                   </div>
                  </div>
                  </div>
              
        <div class="col-9">
          <div class="container mt-4 mb-4 p-3">
              <div class="cards d-flex flex-wrap">
                    <?php
                    //gets resume
                $jobAdvertisementsRes = mysqli_query($db,"SELECT job_advertisements.id,job_advertisements.description,job_advertisements.min_salary,job_advertisements.max_salary,job_advertisements.created_date,job_advertisements.job_feature,job_advertisements.job_type,cities.city_name,job_titles.title,employers.company_name FROM job_advertisements JOIN cities ON cities.id=job_advertisements.city_id JOIN employers ON employers.id=job_advertisements.employer_id JOIN job_titles ON job_titles.id=job_advertisements.job_title_id WHERE job_advertisements.is_active='1'");  
                $jobAdvertisementsRes1=mysqli_num_rows($jobAdvertisementsRes);
                $colorCounter=0;
                
                while($jobAdvertisementsRow = mysqli_fetch_assoc($jobAdvertisementsRes)){
                    ?>
                   <a href="./jobAdvertisementDetail.php?advertisementId=<?php echo$jobAdvertisementsRow["id"] ?>" style="text-decoration:none;" class="m-1">
                      <div class="card text-white <?php
                       if($colorCounter%6==0){echo "bg-primary";}
                       if($colorCounter%6==1) {echo "bg-secondary";}
                       if($colorCounter%6==2) {echo "bg-success";}
                       if($colorCounter%6==3) {echo "bg-danger";}
                       if($colorCounter%6==4) {echo "bg-warning";}
                       if($colorCounter%6==5) {echo "bg-info";}
                       if($colorCounter%6==6) {echo "bg-dark";}
                       ?>" style="width: 18rem;">
                      <div class="card-header"><?php echo $jobAdvertisementsRow["company_name"] ?></div>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $jobAdvertisementsRow["title"] ?></h5>
                        <p class="card-title"><?php echo "( ".$jobAdvertisementsRow["city_name"]." )" ?></p>
                        <p class="card-title"><?php echo $jobAdvertisementsRow["job_feature"] ?></p>
                        <p class="card-title"><?php echo $jobAdvertisementsRow["job_type"] ?></p>
                        <p class="card-text"><?php echo $jobAdvertisementsRow["min_salary"]."₺ <---> ".$jobAdvertisementsRow["max_salary"]."₺" ?></p>
                      </div>
                      <div class="card-footer text-center">
                          <small class="text-white"><?php echo "📅 ".$jobAdvertisementsRow["created_date"]." 📅" ?></small>
                        </div>
                    </div>
                    </a>
                    <?php
                    $colorCounter++;
                }
                    ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  
    



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>