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

        if($_SESSION["userType"]==0){

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
                  <?php
        }else{
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
        <?php
        }
        ?>
              
        
          <?php
          $citiesRes = mysqli_query($db,"SELECT * FROM cities");
          $jobTitlesRes = mysqli_query($db,"SELECT * FROM job_titles");
          
          ?>

        <div class="col-9">
          <div class="container mt-4 mb-4 p-3">
            <!-- Button trigger modal -->
                          <button type="button" class="btn btn-success mb-2 col-4 text-light" data-bs-toggle="modal" data-bs-target="#exampleModalLabeladd">
                            Add Advertisement
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModalLabeladd" tabindex="-1" aria-labelledby="exampleModalLabeladd" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabeladd">Add Advertisement</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                   <!-- Advertisement Position -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="companyAdvertisementPosition">Position</label>
                                      <select name="companyAdvertisementPosition" id="companyAdvertisementPosition" class="form-control">
                                        <?php
                                        while($jobTitlesRow=mysqli_fetch_assoc($jobTitlesRes)){
                                          ?>
                                          <option value="<?php echo $jobTitlesRow["id"] ?>" ><?php echo $jobTitlesRow["title"] ?></option>
                                          <?php
                                        }
                                        ?>
                                        
                                      </select>
                                    </div>
                                    <!-- Advertisement City -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="companyAdvertisementCity">City</label>
                                      <select name="companyAdvertisementCity" id="companyAdvertisementCity" class="form-control">
                                        <?php
                                        while($citiesRow=mysqli_fetch_assoc($citiesRes)){
                                          ?>
                                          <option value="<?php echo $citiesRow["id"] ?>" ><?php echo $citiesRow["city_name"] ?></option>
                                          <?php
                                        }
                                        ?>
                                        
                                      </select>
                                    </div>
                                    <!-- Advertisement Feature -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="companyAdvertisementFeature">Feature</label>
                                      <select name="companyAdvertisementFeature" id="companyAdvertisementFeature" class="form-control">
                                          <option value="Normal" >Normal</option>
                                          <option value="Remote" >Remote</option>
                                          <option value="Hybrid" >Hybrid</option>
                                      </select>
                                    </div>
                                    <!-- Advertisement Type -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="companyAdvertisementType">Type</label>
                                      <select name="companyAdvertisementType" id="companyAdvertisementType" class="form-control">
                                          <option value="Full Time" >Full Time</option>
                                          <option value="Part Time" >Part Time</option>
                                          <option value="Internship" >Internship</option>
                                          <option value="Seasonal" >Seasonal</option>
                                      </select>
                                    </div>
                                    
                                   <!-- Advertisement Min Salary -->
                                   <div class="d-flex flex-wrap justify-content-between">
                                    <div class="form-group col-5" id="resumeSchoolEndDateForm">
                                      <label for="companyAdvertisementMinSalary"  class="col-form-label">Min Salary</label>
                                      <input type="number" class="form-control" id="companyAdvertisementMinSalary" min="0" max="99999" name="companyAdvertisementMinSalary" >
                                    </div>
                                    <div class="form-group col-5" id="resumeSchoolEndDateForm">
                                      <label for="companyAdvertisementMaxSalary"  class="col-form-label">Max Salary</label>
                                      <input type="number" class="form-control" id="companyAdvertisementMaxSalary" min="0"  max="99999" name="companyAdvertisementMaxSalary" >
                                    </div>
                                      <p class="text-danger col-12"><small id="companyAdvertisementSalaryError"></small></p>

                                      </div>
                                    <!-- Advertisement Description -->
                                    <div class="form-group">
                                      <label for="companyAdvertisementDescription" class="col-form-label">Description</label>
                                      <textarea type="text" name="companyAdvertisementDescription"  placeholder="Advertisement description here" class="form-control" id="companyAdvertisementDescription"></textarea>
                                      <p class="text-danger"><small id="companyAdvertisementDescriptionError"></small></p>
                                    </div>

                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="companyAdvertisementSubmit" id="companyAdvertisementSubmit" >Post</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
              <div class="cards d-flex flex-wrap">
              <?php 
              $jobAdvertisementRes = mysqli_query($db,"SELECT job_advertisements.id,job_advertisements.is_active,job_advertisements.id,job_advertisements.description,job_advertisements.min_salary,job_advertisements.max_salary,job_advertisements.created_date,job_advertisements.job_feature,job_advertisements.job_type,cities.city_name,job_titles.title FROM job_advertisements JOIN cities ON cities.id=job_advertisements.city_id JOIN job_titles ON job_titles.id=job_advertisements.job_title_id WHERE job_advertisements.employer_id=$id ORDER BY job_advertisements.created_date DESC");
              $jobAdvertisementRes1=mysqli_num_rows($jobAdvertisementRes);
              ?>
              
              <?php
                    while($jobAdvertisementRow = mysqli_fetch_assoc($jobAdvertisementRes)){
                      $job_id=$jobAdvertisementRow["id"];
                      ?>
                    <div  style="text-decoration:none;" class="m-1">
                      <div class="card <?php if($jobAdvertisementRow["is_active"]==1){echo "text-dark";}else{echo "text-muted";} ?> " style="width: 18rem;">
                      <div class="card-header"><?php echo $jobAdvertisementRow["city_name"] ?></div>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $jobAdvertisementRow["title"] ?></h5>
                        <h6 class="card-title"><?php echo $jobAdvertisementRow["job_feature"] ?></h6>
                        <h6 class="card-title"><?php echo $jobAdvertisementRow["job_type"] ?></h6>
                        <p class="card-text"><?php echo "📅 ".$jobAdvertisementRow["created_date"]." 📅" ?></p>
                      </div>
                      <div class="card-footer d-flex justify-content-between align-items-center">
                        <?php if($jobAdvertisementRow["is_active"]==1){echo "Active";}else{echo "Passive";} ?>
                        <!-- Advertisement Settings modal -->
                          <button type="button" class="btn btn-warning text-light " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $job_id ?>">
                            <i class="fas fa-cog"></i>
                          </button>
                      
                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal<?php echo $job_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $job_id ?>" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel<?php echo $job_id ?>">Settings</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body ">
                                 <form method="POST" class="d-flex justify-content-between">
                                   <input name="companyAdvertisementSettingsId" value="<?php echo $job_id ?>" class="d-none"/>
                                   <input name="companyAdvertisementSettingsIsActive" value="<?php echo $jobAdvertisementRow["is_active"] ?>" class="d-none"/>
                                      <button type="submit" class="btn btn-secondary" name="companyAdvertisementSituationSubmit" id="companyAdvertisementSituationSubmit" >
                                        <?php if($jobAdvertisementRow["is_active"]==1){echo "Make it Passive";}else{echo "Make it Active";} ?>
                                      </button>

                                      <button type="submit" class="btn btn-danger" name="companyAdvertisementDeleteSubmit" id="companyAdvertisementDeleteSubmit" >Delete</button>


                                      <a class="btn btn-success text-light" href="./jobAdvertisementDetail.php?advertisementId=<?php echo$jobAdvertisementRow["id"] ?>">Go Detail</a>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
                    </div>
                    </div>
                    </div>
                      <?php
                    }
                    ?>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script>
      const companyAdvertisementSubmit = document.querySelector("#companyAdvertisementSubmit");
      
      const companyAdvertisementPosition = document.querySelector("#companyAdvertisementPosition");
      const companyAdvertisementCity = document.querySelector("#companyAdvertisementCity");
      const companyAdvertisementFeature = document.querySelector("#companyAdvertisementFeature");
      const companyAdvertisementType = document.querySelector("#companyAdvertisementType");
      const companyAdvertisementMinSalary = document.querySelector("#companyAdvertisementMinSalary");
      const companyAdvertisementMaxSalary = document.querySelector("#companyAdvertisementMaxSalary");
      const companyAdvertisementDescription = document.querySelector("#companyAdvertisementDescription");

      const companyAdvertisementSalaryError = document.querySelector("#companyAdvertisementSalaryError");
      const companyAdvertisementDescriptionError = document.querySelector("#companyAdvertisementDescriptionError");

      
      companyAdvertisementSubmit.addEventListener("click",((e)=>{

        companyAdvertisementSalaryError.innerHTML="";
        companyAdvertisementDescriptionError.innerHTML="";

        if(companyAdvertisementMinSalary.value>=companyAdvertisementMaxSalary.value){
          e.preventDefault();
          companyAdvertisementSalaryError.innerHTML="Minimum maaş Maximum maaş ile eşit veya daha fazla olamaz";
        }else if(companyAdvertisementMaxSalary.value<=companyAdvertisementMinSalary.value){
          e.preventDefault();
          companyAdvertisementSalaryError.innerHTML="Maximum maaş Minimum maaş ile eşit veya daha az olamaz";
        }else if(companyAdvertisementDescription.value.length<=20){
          e.preventDefault();
          companyAdvertisementDescriptionError.innerHTML="İş açıklaması en az 20 karakter olmalıdır";
        }
      }))

    </script>
  
    



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  <?php
      if(isset($_POST["companyAdvertisementSubmit"])){
      $companyAdvertisementPosition=$_POST["companyAdvertisementPosition"];
      $companyAdvertisementCity=$_POST["companyAdvertisementCity"];
      $companyAdvertisementFeature=$_POST["companyAdvertisementFeature"];
      $companyAdvertisementType=$_POST["companyAdvertisementType"];
      $companyAdvertisementMinSalary=$_POST["companyAdvertisementMinSalary"];
      $companyAdvertisementMaxSalary=$_POST["companyAdvertisementMaxSalary"];
      $companyAdvertisementDescription=$_POST["companyAdvertisementDescription"];
       $date = date("Y.m.d");
        
          $addAdvertisement = mysqli_query($db,"INSERT INTO job_advertisements(employer_id, job_title_id, city_id, description, min_salary, max_salary, is_active, created_date, job_feature, job_type) VALUES ('$id','$companyAdvertisementPosition','$companyAdvertisementCity','$companyAdvertisementDescription','$companyAdvertisementMinSalary','$companyAdvertisementMaxSalary',1,'$date','$companyAdvertisementFeature','$companyAdvertisementType')");
      }
  ?>
  <?php
      if(isset($_POST["companyAdvertisementDeleteSubmit"])){
      $companyAdvertisementSettingsId=$_POST["companyAdvertisementSettingsId"];
      
      $deleteAdvertisement = mysqli_query($db,"DELETE FROM job_advertisements WHERE id='$companyAdvertisementSettingsId'");
      }
  ?>
  <?php
      if(isset($_POST["companyAdvertisementSituationSubmit"])){
      $companyAdvertisementSettingsId=$_POST["companyAdvertisementSettingsId"];
      $companyAdvertisementSettingsIsActive=$_POST["companyAdvertisementSettingsIsActive"];
      
      if($companyAdvertisementSettingsIsActive==1){
      $deleteAdvertisement = mysqli_query($db,"UPDATE job_advertisements SET is_active = '0' WHERE id = '$companyAdvertisementSettingsId';");
      }else{
      $deleteAdvertisement = mysqli_query($db,"UPDATE job_advertisements SET is_active = '1' WHERE id = '$companyAdvertisementSettingsId';");

      }
      }
  ?>
  

</body>
</html>

                      