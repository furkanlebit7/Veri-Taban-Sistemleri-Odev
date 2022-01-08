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
              
        <div class="col-9">
          
          <div class="container mt-4 mb-4 p-3">
            <!-- Button trigger modal -->
                          <button type="button" class="btn btn-warning mb-2 col-4 text-light" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                            Write Blog
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel2">Write Blog</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                 <form method="POST">
                                   <!-- Blog Title -->
                                    <div class="form-group">
                                      <label for="companyBlogTitle" class="col-form-label">Blog Title</label>
                                      <input type="text" name="companyBlogTitle"  placeholder="Blog Title here" class="form-control" id="companyBlogTitle">
                                      <p class="text-danger"><small id="companyBlogTitleError"></small></p>
                                    </div>
                                    <!-- Blog Text -->
                                    <div class="form-group">
                                      <label for="companyBlogText" class="col-form-label">Blog Text</label>
                                      <textarea type="text" name="companyBlogText"  placeholder="Blog Text here" class="form-control" id="companyBlogText"></textarea>
                                      <p class="text-danger"><small id="companyBlogTextError"></small></p>
                                    </div>
                                   <!-- Blog Image -->
                                    <div class="form-group" id="resumeSchoolEndDateForm">
                                      <label for="resumeBlogImage"  class="col-form-label">Blog Image</label>
                                      <input type="file" class="form-control" id="resumeBlogImage"  name="resumeBlogImage" >
                                      <p class="text-danger"><small id="resumeBlogImageError"></small></p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary" name="companyBlogSubmit" id="companyBlogSubmit" >Post</button>
                                    </div>
                                  </form>
                                </div>
                                
                              </div>
                            </div>
                          </div>
                          <!-- Modal End -->
              <div class="cards d-flex flex-wrap">
                    <?php
                  $companyBlogRes = mysqli_query($db,"SELECT * FROM blogs WHERE employer_id='$id' ORDER BY post_date DESC");
                  $colorCounter=0;
                
                while($companyBlogRow = mysqli_fetch_assoc($companyBlogRes)){
                    ?>
                   <a href="./blogDetail.php?blogId=<?php echo$companyBlogRow["id"] ?>" style="text-decoration:none;" class="m-1 mb-3">
                   
                      <div class="card text-dark text-center <?php
                         if($colorCounter%6==0){echo "border-primary";}
                         if($colorCounter%6==1) {echo "border-secondary";}
                         if($colorCounter%6==2) {echo "border-success";}
                         if($colorCounter%6==3) {echo "border-danger";}
                         if($colorCounter%6==4) {echo "border-warning";}
                         if($colorCounter%6==5) {echo "border-info";}
                         if($colorCounter%6==6) {echo "border-dark";}
                         ?>" style="width: 17rem;">
                        <img class="card-img-top" src="photos/<?php echo $companyBlogRow["blog_image"] ?>" alt="Blog image cap">
                        
                       <div class="card-body" style="height: 180px;overflow: hidden;">
                          <h5 class="card-title"><?php echo $companyBlogRow["blog_tittle"] ?></h5>
                          <p class="card-text"><?php echo substr($companyBlogRow["blog_text"],0,50 )."..." ?></p>

                        </div>
                          <div class="card-footer text-center">
                            <small class="text-dark"><?php echo "📅 ".$companyBlogRow["post_date"]." 📅" ?></small>
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


    <script>
      const companyBlogSubmit = document.querySelector("#companyBlogSubmit");
      
      const companyBlogTitle = document.querySelector("#companyBlogTitle");
      const companyBlogText = document.querySelector("#companyBlogText");
      const resumeBlogImage = document.querySelector("#resumeBlogImage");

      const companyBlogTitleError = document.querySelector("#companyBlogTitleError");
      const companyBlogTextError = document.querySelector("#companyBlogTextError");
      const resumeBlogImageError = document.querySelector("#resumeBlogImageError");

      
      companyBlogSubmit.addEventListener("click",((e)=>{

        companyBlogTitleError.innerHTML="";
        companyBlogTextError.innerHTML="";
        resumeBlogImageError.innerHTML="";

        if(companyBlogTitle.value=="" || companyBlogTitle.value.length<16){
          e.preventDefault();
          companyBlogTitleError.innerHTML="Blog başlığı 16 karakterden az olamaz";
        }else if(companyBlogText.value=="" || companyBlogText.value.length<50){
          e.preventDefault();
          companyBlogTextError.innerHTML="Blog içeriği 50 karakterden az olamaz";
        }else if(!resumeBlogImage || resumeBlogImage.value==""){
          e.preventDefault();
          resumeBlogImageError.innerHTML="Lütfen bir fotoğraf seçiniz";
        }
      }))

    </script>
  
    



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

  <?php
      if(isset($_POST["companyBlogSubmit"])){
      $companyBlogTitle=$_POST["companyBlogTitle"];
      $companyBlogText=$_POST["companyBlogText"];
      $resumeBlogImage=$_POST["resumeBlogImage"];

      $date = date("Y.m.d");
        
         $addBlog = mysqli_query($db,"INSERT INTO blogs (employer_id, blog_text, blog_image,blog_tittle,post_date) VALUES ('$id','$companyBlogText','$resumeBlogImage','$companyBlogTitle','$date')"); 
      }
  ?>

</body>
</html>