<?php
   include_once "db.php";
  session_start();
  if(!$_SESSION["userId"]){
    Header("Location:login.php");
  }
  $id = $_SESSION["userId"];
  
  $ress = mysqli_query($db,"SELECT * FROM resumes WHERE candidate_id='$id'");   
  $ress1=mysqli_num_rows($ress);
  
  if($ress1!=1){
    Header("Location:editProfile.php");
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
                    <li class="nav-item">
                     <a class="nav-link" href="http://localhost/veritabani/editProfile.php">My Links</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="http://localhost/veritabani/resume.php">Resume</a>
                    </li>
                  </ul>
                </div>
                <a class="navbar-brand" href="#">Log Out</a>
        </div>
    </nav>
    
    <div class="container">
      <div class="row">
        <?php 

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
                $resumeId=$row["id"];
                $counter = 0;

                if($res1==1){
                    $github=$row["candidate_github"];
                    $linkedin=$row["candidate_linkedin"];
                    $desc=$row["description"];
                }

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
            
                        <?php
                        $experienceRes = mysqli_query($db,"SELECT resume_experience.workplace_name,resume_experience.explanation, resume_experience.started_date, resume_experience.end_date,resume_experience.is_going,job_titles.title FROM job_titles INNER JOIN resume_experience ON resume_experience.position_id=job_titles.id WHERE resume_experience.resume_id=$id");

                        $positionsRes = mysqli_query($db,"SELECT * FROM job_titles");
                        ?>


                        
                       <!-- Resume Experience Start -->
                      <div class="resume_experiences mb-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Experiences</h1>
                        <!-- Button trigger modal -->
                          <button type="button" class="btn  btn-warning mb-2 float-end text-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Add Experience
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                    <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">Workplace Name</label>
                                      <input type="text" name="resumeWorkplaceName"  placeholder="Workplce name here" class="form-control" id="resumeWorkplaceName">
                                      <p class="text-danger"><small id="resumeExperienceWorkplaceError"></small></p>
                                    </div>
                                    <div class="form-group col-md-8 mt-2">
                                      <label for="inputState">Position</label>
                                      <select name="resumePositionId" id="resumePositionId" class="form-control">
                                        <option value="0" selected>Choose...</option>
                                        <?php
                                        while($positionsRow=mysqli_fetch_assoc($positionsRes)){
                                          ?>
                                            <option value="<?php echo $positionsRow["id"] ?>" selected><?php echo $positionsRow["title"] ?></option>
                                          <?php
                                        }
                                        ?>
                                      </select>
                                      <p class="text-danger"><small id="resumeExperiencePositionIdError"></small></p>
                                    </div>
                                    <div class="form-group mt-2">
                                      <label for="recipient-name" class="col-form-label">Started Date</label>
                                      <input type="date" name="resumeStartedDate"  class="form-control" id="resumeStartedDate">
                                      <p class="text-danger"><small id="resumeExperienceStartedDateError"></small></p>
                                    </div>
                                    <div class="form-check">
                                        <input name="resumeExperiencePresent" id="resumeExperiencePresent" class="form-check-input" type="radio" value="1" >
                                        <label class="form-check-label" for="resumeExperiencePresent">
                                          Present
                                        </label>
                                      </div>
                                    <div class="form-check d-none">
                                        <input name="resumeExperiencePresent" class="form-check-input" type="radio" value="0" checked >
                                        <label class="form-check-label" for="resumeExperiencePresent">
                                          Finito
                                        </label>
                                      </div>
                                   
                                    <div class="form-group mt-2">
                                      <label for="recipient-name"  class="col-form-label">End Date</label>
                                      <input type="date" class="form-control" id="resumeEndDate"  name="resumeEndDate" >
                                    </div>
                                    <div class="form-group mt-2">
                                      <label for="message-text" class="col-form-label">Description</label>
                                      <textarea class="form-control" placeholder="Description here" id="resumeExperienceExplanation"  name="resumeExplanation"></textarea>
                                      <p class="text-danger"><small  id="resumeExperienceDescriptionError"></small></p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="resumeExperienceSubmit" id="resumeExperienceSubmit" >Add Experience</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                        <?php
                        while($experienceRow=mysqli_fetch_assoc($experienceRes)){
                          ?>
                          <hr>
                          <div class="card">
                            <h4 class="card-header text-dark"><?php echo $experienceRow["workplace_name"]?></h5>
                            <div class="card-body">
                              <h6 class="card-title text-danger"><?php echo $experienceRow["title"]?></h6>
                              <p class="card-text p-0 mb-2 mt-3"><?php echo $experienceRow["explanation"]?></p>
                              <p class="text-muted m-0 p-0 float-end mt-3"><small><?php echo $experienceRow["started_date"]?></small> <-> <small><?php if(!$experienceRow["end_date"]){echo "Present";}else{echo $experienceRow["end_date"]; } ?></small><p>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                      <!-- Resume Experience End -->

                      <?php
                        $schoolRes = mysqli_query($db,"SELECT * FROM resume_schools WHERE resume_id=$id");
                        ?>
                      
                        
                      <!-- Resume Schools Start -->
                      <div class="resume_schools my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Schools</h1>
                        <?php
                        while($schoolRow=mysqli_fetch_assoc($schoolRes)){
                          ?>
                          <hr>  
                          <div class="card">
                            <h4 class="card-header"><?php echo $schoolRow["school_name"]?></h4>
                            <div class="card-body">
                              <h5 class="card-title d-inline text-danger"><?php echo $schoolRow["department"]?></h5><small class="mx-4"><?php echo "(".$schoolRow["degree"]." degree)"?></small>
                              <p class="text-dark mt-2 mb-0"><strong><?php echo $schoolRow["class"]." Class"?></strong></p>
                              <p class="text-dark m-0"><strong><?php echo $schoolRow["point"]?></strong></p>
                              <p class="text-muted m-0 p-0 mt-3 "><small><?php echo $schoolRow["started_date"]?></small> <-> <small><?php if(!$schoolRow["end_date"]){echo "Present";}else{echo $schoolRow["end_date"]; } ?></small><p>
                          </div>
                          
                          <?php
                        }
                        ?>
                      </div>
                      <!-- Resume Schools End -->
                      
                      <?php
                        $techsRes = mysqli_query($db,"SELECT resume_techs.tech_level,techs.tech_name FROM techs INNER JOIN resume_techs ON resume_techs.tech_id=techs.id WHERE resume_techs.resume_id=$id");
                      ?>

                      <!-- Resume Techs Start -->
                      <div class="resume_techs my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Technologies</h1>
                          <hr>
                          <div class="card">
                            <div class="card-body"style="padding:0 1rem;">
                            <?php
                            while($techsRow = mysqli_fetch_assoc($techsRes)){
                              $star=$techsRow["tech_level"];
                              ?>
                              <div class="d-flex align-items-center justify-content-between my-3">
                                <h5 class="card-title m-0"><?php echo $techsRow["tech_name"] ?></h5>
                                <span><?php while($star){echo "⭐";$star--;} ?></span>
                              </div>
                              <hr>
                              <?php
                            }
                            ?>
                            </div>
                          </div>
                      </div>
                      <!-- Resume Techs End -->


                      <?php
                        $languageRes = mysqli_query($db,"SELECT resume_language.language_level, languages.language_name FROM languages INNER JOIN resume_language ON resume_language.language_id=languages.id WHERE resume_language.resume_id='$id'");
                      ?>

                      <!-- Resume Languages Start -->
                      <div class="resume_techs my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Languages</h1>
                          <hr>
                          <div class="card">
                            <div class="card-body"style="padding:0 1rem;">
                            <?php
                            while($languageRow = mysqli_fetch_assoc($languageRes)){
                              ?>
                              <div class="d-flex align-items-center justify-content-between my-3">
                                <h5 class="card-title m-0"><?php echo $languageRow["language_name"] ?></h5>
                                <p class="p-0 m-0"><strong><?php echo $languageRow["language_level"] ?></strong></p>
                              </div>
                              <hr>
                              <?php
                            }
                            ?>
                            </div>
                          </div>
                      </div>
                      <!-- Resume Languages End -->
          </div>
        </div>
                     
      </div>
    </div>

    <script>
      const resumeExperienceSubmit = document.querySelector("#resumeExperienceSubmit");

      const resumeExperienceWorkplaceName=document.querySelector("#resumeWorkplaceName");
      const resumeExperiencePositionId=document.querySelector("#resumePositionId");
      const resumeExperienceStartedDate=document.querySelector("#resumeStartedDate");
      const resumeExperienceExplanation=document.querySelector("#resumeExperienceExplanation");
                   



       const resumeExperienceWorkplaceError = document.querySelector("#resumeExperienceWorkplaceError");
       const resumeExperiencePositionIdError = document.querySelector("#resumeExperiencePositionIdError");
       const resumeExperienceStartedDateError = document.querySelector("#resumeExperienceStartedDateError");
       const resumeExperienceDescriptionError = document.querySelector("#resumeExperienceDescriptionError");
      
      resumeExperienceSubmit.addEventListener("click",((e)=>{
        resumeExperienceWorkplaceError.innerHTML="";
        resumeExperiencePositionIdError.innerHTML="";
        resumeExperienceStartedDateError.innerHTML="";
        resumeExperienceDescriptionError.innerHTML="";

         if(resumeExperienceWorkplaceName.value==""){
          e.preventDefault();
          resumeExperienceWorkplaceError.innerHTML="Workplace Name alanı zorunludur";
        }else if(resumeExperiencePositionId.value==0){
          e.preventDefault();
           resumeExperiencePositionIdError.innerHTML="Lütfen hangi pozisyonda çalıştığınızı seçiniz";
        }else if(!resumeExperienceStartedDate.value){
          e.preventDefault();
          resumeExperienceStartedDateError.innerHTML="İşe başlama tarihi alanı zorunludur";
        }else if(resumeExperienceExplanation.value=="" || resumeExperienceExplanation.value.length<20){
          e.preventDefault();
          resumeExperienceDescriptionError.innerHTML="Açıklama kısmı en az 20 karakter içermelidir";
        }

      }))

    </script>
  
     
<script>
  const present = document.querySelector("#resumeExperiencePresent");
  const endDateInput = document.querySelector("#resumeEndDate");
  present.addEventListener("click",(()=>{
    if(endDateInput.getAttribute("readonly")==null){
      endDateInput.setAttribute("readonly",true);
    }else{
     endDateInput.removeAttribute("readonly");
    }
  }))
</script>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


  <?php
      if(isset($_POST["resumeExperienceSubmit"])){
      $resumeExperienceWorkplaceName=$_POST["resumeWorkplaceName"];
      $resumeExperiencePositionId=$_POST["resumePositionId"];
      $resumeExperienceStartedDate=$_POST["resumeStartedDate"];
      $resumeExperienceEndDate=$_POST["resumeEndDate"];
      $resumeExperienceIsGoing=$_POST["resumeExperiencePresent"];
      $resumeExperienceExplanation=$_POST["resumeExplanation"];
        
      

       if($resumeExperienceIsGoing==1){

        $addExplanationRes = mysqli_query($db,"INSERT INTO resume_experience (resume_id,workplace_name,position_id,started_date,is_going,explanation)  VALUES ('$id','$resumeExperienceWorkplaceName','$resumeExperiencePositionId','$resumeExperienceStartedDate','$resumeExperienceIsGoing','$resumeExperienceExplanation')");  
       
      }else{

        $addExplanationRes = mysqli_query($db,"INSERT INTO resume_experience (resume_id,workplace_name,position_id,started_date,end_date,is_going,explanation)  VALUES ('$id','$resumeExperienceWorkplaceName','$resumeExperiencePositionId','$resumeExperienceStartedDate','$resumeExperienceEndDate','$resumeExperienceIsGoing','$resumeExperienceExplanation')");  

      }
       


      }
  ?>
</body>
</html>