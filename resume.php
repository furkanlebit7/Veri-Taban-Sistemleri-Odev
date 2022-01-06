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
                        $experienceRes = mysqli_query($db,"SELECT resume_experience.workplace_name,resume_experience.explanation, resume_experience.started_date, resume_experience.end_date,resume_experience.is_going,job_titles.title FROM job_titles INNER JOIN resume_experience ON resume_experience.position_id=job_titles.id WHERE resume_experience.resume_id=$resumeId");

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
                                  <h5 class="modal-title" id="exampleModalLabel">Add Experience</h5>
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
                                    
                                    <div class="form-check d-none">
                                        <input name="resumeExperiencePresent" class="form-check-input" type="checkbox" value="0" checked >
                                        <label class="form-check-label" for="resumeExperiencePresent">
                                          Finito
                                        </label>
                                      </div>
                                    <div class="form-check">
                                        <input name="resumeExperiencePresent" id="resumeExperiencePresent" class="form-check-input" type="checkbox" value="1" >
                                        <label class="form-check-label" for="resumeExperiencePresent">
                                          Present
                                        </label>
                                      </div>
                                   
                                    <div class="form-group mt-2" id="resumeEndDateForm">
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
                        $schoolRes = mysqli_query($db,"SELECT * FROM resume_schools WHERE resume_id=$resumeId");
                        ?>
                      <!-- Resume Schools Start -->
                      <div class="resume_schools my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Schools</h1>
                        <!-- Button trigger modal -->
                          <button type="button" class="btn  btn-warning mb-2 float-end text-light" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                            Add School
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel2">Add School</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                   <!-- School Name -->
                                    <div class="form-group">
                                      <label for="resumeSchoolName" class="col-form-label">School Name</label>
                                      <input type="text" name="resumeSchoolName"  placeholder="School Name here" class="form-control" id="resumeSchoolName">
                                      <p class="text-danger"><small id="resumeSchoolNameError"></small></p>
                                    </div>
                                    <!-- School Department -->
                                    <div class="form-group">
                                      <label for="resumeSchoolDepartment" class="col-form-label">Department</label>
                                      <input type="text" name="resumeSchoolDepartment"  placeholder="Department here" class="form-control" id="resumeSchoolDepartment">
                                      <p class="text-danger"><small id="resumeSchoolDepartmentError"></small></p>
                                    </div>
                                    <!-- School Degree -->
                                    <div class="form-group col-md-8 ">
                                      <label for="resumeSchoolDegree">Degree</label>
                                      <select name="resumeSchoolDegree" id="resumeSchoolDegree" class="form-control">
                                        <option value="Associate ">Associate Degree</option>
                                        <option value="Bachelor's" selected>Bachelor's Degree</option>
                                        <option value="Master's" >Master's Degree</option>
                                        <option value="Doctoral" >Doctoral Degree</option>
                                      </select>
                                    </div>
                                    <!-- School Started Date -->
                                    <div class="form-group">
                                      <label for="resumeSchoolStartedDate" class="col-form-label">Started Date</label>
                                      <input type="date" name="resumeSchoolStartedDate"  class="form-control" id="resumeSchoolStartedDate">
                                      <p class="text-danger"><small id="resumeSchoolStartedDateError"></small></p>
                                    </div>
                                    <!-- School Is Going -->
                                    <div class="form-check d-none">
                                        <input name="resumeSchoolIsGoing" class="form-check-input" type="checkbox" value="0" checked >
                                        <label class="form-check-label" for="resumeSchoolIsGoing">
                                          Finito
                                        </label>
                                      </div>
                                    <div class="form-check">
                                        <input name="resumeSchoolIsGoing" id="resumeSchoolIsGoing" class="form-check-input" type="checkbox" value="1" >
                                        <label class="form-check-label" for="resumeSchoolIsGoing">
                                          Present
                                        </label>
                                      </div>
                                    
                                   <!-- School End Date -->
                                    <div class="form-group" id="resumeSchoolEndDateForm">
                                      <label for="resumeSchoolEndDate"  class="col-form-label">End Date</label>
                                      <input type="date" class="form-control" id="resumeSchoolEndDate"  name="resumeSchoolEndDate" >
                                    </div>
                                    <!-- School Class -->
                                    <div class="form-group col-md-8 mt-2">
                                      <label for="resumeSchoolClass">Class (Year)</label>
                                      <select name="resumeSchoolClass" id="resumeSchoolClass" class="form-control">
                                        <option value="5" selected>Preparatory</option>
                                        <option value="1" selected>1</option>
                                        <option value="2" selected>2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4" selected>4</option>
                                      </select>
                                    </div>
                                    <!-- School GPA -->
                                    <div class="form-group mb-4">
                                      <label for="resumeSchoolPoint"  class="col-form-label">GPA</label>
                                      <input type="number" value="2.00" step=0.01 min="0" max="4" class="form-control" id="resumeSchoolPoint"  name="resumeSchoolPoint" >
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="resumeSchoolSubmit" id="resumeSchoolSubmit" >Add School</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
                        <?php
                        while($schoolRow=mysqli_fetch_assoc($schoolRes)){
                          ?>
                          <hr>  
                          <div class="card">
                            <h4 class="card-header"><?php echo $schoolRow["school_name"]?></h4>
                            <div class="card-body">
                              <h5 class="card-title d-inline text-danger"><?php echo $schoolRow["department"]?></h5><small class="mx-4"><?php echo "(".$schoolRow["degree"]." degree)"?></small>
                              <p class="text-dark mt-2 mb-0"><strong><?php if($schoolRow["class"]==5){echo "Preparatory Class";}else{echo $schoolRow["class"]." Class";} ?></strong></p>
                              <p class="text-dark p-0 m-0"><strong><?php echo "GPA = ".$schoolRow["agno"]?></strong></p>
                              <p class="text-muted m-0 p-0 float-end"><small><?php echo $schoolRow["started_date"]?></small> <-> <small><?php if(!$schoolRow["end_date"]){echo "Present";}else{echo $schoolRow["end_date"]; } ?></small><p>
                          </div>
                        </div>
                          <?php
                        }
                        ?>
                      </div>
                      <!-- Resume Schools End -->
                      



                      <?php 
                        $techsRes = mysqli_query($db,"SELECT resume_techs.tech_level,techs.tech_name,techs.id FROM techs INNER JOIN resume_techs ON resume_techs.tech_id=techs.id WHERE resume_techs.resume_id=$resumeId");
                      ?>
                      <?php
                        $allTechsRes = mysqli_query($db,"SELECT * FROM techs");
                      ?>
                      <!-- Resume Techs Start -->
                      <div class="resume_techs my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Technologies</h1>
                        <!-- Button trigger modal -->
                          <button type="button" class="btn  btn-warning mb-2 float-end text-light" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                            Add Technology
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel3">Add Technology</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                    <!-- Technology Name -->
                                    <div class="form-group  mt-2 ">
                                      <label for="resumeTechnologyName">Technology Name</label>
                                      <select name="resumeTechnologyName" id="resumeTechnologyName" class="form-control">
                                        <?php
                                         while($allTechsRow = mysqli_fetch_assoc($allTechsRes)){
                                           ?>
                                          <option value="<?php echo $allTechsRow["id"] ?>" ><?php echo $allTechsRow["tech_name"] ?></option>
                                           <?php
                                         }
                                        ?>
                                      </select>
                                    </div>
                                    <!-- Technology Level -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="resumeTechnologyLevel">Level</label>
                                      <select name="resumeTechnologyLevel" id="resumeTechnologyLevel" class="form-control">
                                        <option value="1" >1</option>
                                        <option value="2" >2</option>
                                        <option value="3" >3</option>
                                        <option value="4" >4</option>
                                        <option value="5" >5</option>
                                      </select>
                                    </div>
                                   
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="resumeTechnologySubmit" id="resumeTechnologySubmit" >Add Technology</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
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
                        $languageRes = mysqli_query($db,"SELECT resume_language.language_level, languages.language_name FROM languages INNER JOIN resume_language ON resume_language.language_id=languages.id WHERE resume_language.resume_id='$resumeId'");
                      ?>
                       <?php
                        $allLangRes = mysqli_query($db,"SELECT * FROM languages");
                      ?>
                      <!-- Resume Languages Start -->
                      <div class="resume_techs my-5">
                        <h1 class="badge bg-primary" style="font-size:1.5rem;">Languages</h1>
                         <!-- Button trigger modal -->
                          <button type="button" class="btn  btn-warning mb-2 float-end text-light" data-bs-toggle="modal" data-bs-target="#exampleModal4">
                            Add Language
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel4">Add Language</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                    <!-- Language Name -->
                                    <div class="form-group  mt-2 ">
                                      <label for="resumeLanguageName">Language</label>
                                      <select name="resumeLanguageName" id="resumeLanguageName" class="form-control">
                                        <?php
                                         while($allLangRow = mysqli_fetch_assoc($allLangRes)){
                                           ?>
                                          <option value="<?php echo $allLangRow["id"] ?>" ><?php echo $allLangRow["language_name"] ?></option>
                                           <?php
                                         }
                                        ?>
                                      </select>
                                    </div>
                                    <!-- Language Level -->
                                    <div class="form-group  mt-2 mb-3">
                                      <label for="resumeLanguageLevel">Level</label>
                                      <select name="resumeLanguageLevel" id="resumeLanguageLevel" class="form-control">
                                        <option value="Advanced" >Advanced</option>
                                        <option value="Intermediate" >Intermediate</option>
                                        <option value="Beginner" >Beginner</option>
                                      </select>
                                    </div>
                                   
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="resumeLanguageSubmit" id="resumeLanguageSubmit" >Add Language</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
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

<script> //Resume Experience Script
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

<script> //Resume School Script
      const resumeSchoolSubmit = document.querySelector("#resumeSchoolSubmit");

      const resumeSchoolName = document.querySelector("#resumeSchoolName");
      const resumeSchoolDepartment = document.querySelector("#resumeSchoolDepartment");
      const resumeSchoolStartedDate = document.querySelector("#resumeSchoolStartedDate");


      const resumeSchoolNameError = document.querySelector("#resumeSchoolNameError");
      const resumeSchoolDepartmentError = document.querySelector("#resumeSchoolDepartmentError");
      const resumeSchoolStartedDateError = document.querySelector("#resumeSchoolStartedDateError");

      resumeSchoolSubmit.addEventListener("click",((e)=>{
        resumeSchoolNameError.innerHTML="";
        resumeSchoolDepartmentError.innerHTML="";
        resumeSchoolStartedDateError.innerHTML="";

        if(resumeSchoolName.value==""){
          e.preventDefault();
          resumeSchoolNameError.innerHTML="School Name alanı zorunludur";
        }else if(resumeSchoolDepartment.value==""){
          e.preventDefault();
          resumeSchoolDepartmentError.innerHTML="Department alanı zorunludur";
        }else if(!resumeSchoolStartedDate.value){
          e.preventDefault();
          resumeSchoolStartedDateError.innerHTML="Lütfen okula başlam tarihinizi giriniz";
        }

      }))

</script>
     
<script> // End Date Close Toggle
  const present = document.querySelector("#resumeExperiencePresent");
  const resumeEndDateForm = document.querySelector("#resumeEndDateForm");
  present.addEventListener("click",(()=>{
    resumeEndDateForm.classList.toggle("d-none")
  }))

  const resumeSchoolIsGoing = document.querySelector("#resumeSchoolIsGoing");
  const resumeSchoolEndDateForm = document.querySelector("#resumeSchoolEndDateForm");
  resumeSchoolIsGoing.addEventListener("click",(()=>{
    resumeSchoolEndDateForm.classList.toggle("d-none")
  }))
</script>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>



        <!-- Resume Experience Submit -->
  <?php
      if(isset($_POST["resumeExperienceSubmit"])){
      $resumeExperienceWorkplaceName=$_POST["resumeWorkplaceName"];
      $resumeExperiencePositionId=$_POST["resumePositionId"];
      $resumeExperienceStartedDate=$_POST["resumeStartedDate"];
      $resumeExperienceEndDate=$_POST["resumeEndDate"];
      $resumeExperienceIsGoing=$_POST["resumeExperiencePresent"];
      $resumeExperienceExplanation=$_POST["resumeExplanation"];
        
       if($resumeExperienceIsGoing==1){

        $addExplanationRes = mysqli_query($db,"INSERT INTO resume_experience (resume_id,workplace_name,position_id,started_date,is_going,explanation)  VALUES ('$resumeId','$resumeExperienceWorkplaceName','$resumeExperiencePositionId','$resumeExperienceStartedDate','$resumeExperienceIsGoing','$resumeExperienceExplanation')");  
      }else{
        $addExplanationRes = mysqli_query($db,"INSERT INTO resume_experience (resume_id,workplace_name,position_id,started_date,end_date,is_going,explanation)  VALUES ('$resumeId','$resumeExperienceWorkplaceName','$resumeExperiencePositionId','$resumeExperienceStartedDate','$resumeExperienceEndDate','$resumeExperienceIsGoing','$resumeExperienceExplanation')");  

      }
      }
  ?>

        <!-- Resume Schol Submit -->
  <?php
      if(isset($_POST["resumeSchoolSubmit"])){
      $resumeSchoolName=$_POST["resumeSchoolName"];
      $resumeSchoolDepartment=$_POST["resumeSchoolDepartment"];
      $resumeSchoolDegree=$_POST["resumeSchoolDegree"];
      $resumeSchoolStartedDate=$_POST["resumeSchoolStartedDate"];
      $resumeSchoolEndDate=$_POST["resumeSchoolEndDate"];
      $resumeSchoolIsGoing=$_POST["resumeSchoolIsGoing"];
      $resumeSchoolClass=$_POST["resumeSchoolClass"];
      $resumeSchoolPoint=$_POST["resumeSchoolPoint"];
        
        
      if($resumeSchoolIsGoing==1){
        $addSchoolRes = mysqli_query($db,"INSERT INTO resume_schools (resume_id, degree, department, started_date, is_going, school_name, class, agno) VALUES ('$resumeId','$resumeSchoolDegree','$resumeSchoolDepartment','$resumeSchoolStartedDate','$resumeSchoolIsGoing','$resumeSchoolName','$resumeSchoolClass','$resumeSchoolPoint')");  
      }else{
        $addSchoolRes = mysqli_query($db,"INSERT INTO resume_schools (resume_id, degree, department, started_date,end_date is_going, school_name, class, agno) VALUES ('$resumeId','$resumeSchoolDegree','$resumeSchoolDepartment','$resumeSchoolStartedDate','$resumeSchoolEndDate','$resumeSchoolIsGoing','$resumeSchoolName','$resumeSchoolClass',$resumeSchoolPoint)"); 
      }
      }
  ?>

        <!-- Resume Technology Submit -->
  <?php
      if(isset($_POST["resumeTechnologySubmit"])){
      $resumeTechnologyName=$_POST["resumeTechnologyName"];
      $resumeTechnologyLevel=$_POST["resumeTechnologyLevel"];
        
       $addTechRes = mysqli_query($db,"INSERT INTO resume_techs (resume_id, tech_id, tech_level) VALUES ('$resumeId','$resumeTechnologyName','$resumeTechnologyLevel')"); 
      }
  ?>

        <!-- Resume Language Submit -->
  <?php
      if(isset($_POST["resumeLanguageSubmit"])){
      $resumeLanguageName=$_POST["resumeLanguageName"];
      $resumeLanguageLevel=$_POST["resumeLanguageLevel"];

      echo $resumeLanguageName."</br>";
      echo $resumeLanguageLevel."</br>";
        
       $addLanguageRes = mysqli_query($db,"INSERT INTO resume_language (resume_id, language_id, language_level) VALUES ('$resumeId','$resumeLanguageName','$resumeLanguageLevel')"); 
      }
  ?>
</body>
</html>