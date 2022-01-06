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
                

                //gets GET method
                $companyId=$_GET["companyId"];
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
                    //gets company
                $companyRes = mysqli_query($db,"SELECT * FROM employers WHERE id='$companyId'");
                $companyRow = mysqli_fetch_assoc($companyRes);
                  ?>

        <div class="col-9">
          <div class="container mt-4 mb-4 p-3">
              <!--Information Card Start -->
                  <div class="card text-center">
                  <div class="card-header">
                    Information
                  </div>
                  <div class="card-body">
                    <img class="card-img-top" src="<?php echo "photos/".$companyRow["company_logo"] ?>" alt="Card image cap" style="width:200px;height:200px;">
                    <h5 class="card-title text-primary my-3"><?php echo $companyRow["company_name"] ?></h5>
                    <p class="card-text mt-2"><?php echo $companyRow["phone_number"] ?></p>
                    <a href="<?php echo $companyRow["web_adress"] ?>" class="btn btn-primary">Go Website</a>
                  </div>
                </div>
              <!--Information Card End -->

              <?php 
              $jobAdvertisementRes = mysqli_query($db,"SELECT job_advertisements.id,job_advertisements.description,job_advertisements.min_salary,job_advertisements.max_salary,job_advertisements.created_date,job_advertisements.job_feature,job_advertisements.job_type,cities.city_name,job_titles.title FROM job_advertisements JOIN cities ON cities.id=job_advertisements.city_id JOIN job_titles ON job_titles.id=job_advertisements.job_title_id WHERE job_advertisements.employer_id=$companyId AND job_advertisements.is_active=1");
              $jobAdvertisementRes1=mysqli_num_rows($jobAdvertisementRes);              
              ?>

              <!-- Advertisements Card Start -->
                  <div class="card text-center mt-4 ">
                  <div class="card-header">
                    Job Advertisements
                  </div>
                  <?php
                  if($jobAdvertisementRes1!=0){
                    ?>
                     <div class="card-body d-flex flex-wrap justify-content-center">
                    <!-- advertisement card start -->
                    <?php
                    while($jobAdvertisementRow = mysqli_fetch_assoc($jobAdvertisementRes)){
                      ?>
                    <a href="./jobAdvertisementDetail.php?advertisementId=<?php echo$jobAdvertisementRow["id"] ?>" style="text-decoration:none;" class="m-1">
                      <div class="card text-white bg-dark " style="width: 18rem;">
                      <div class="card-header"><?php echo $jobAdvertisementRow["city_name"] ?></div>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $jobAdvertisementRow["title"] ?></h5>
                        <h6 class="card-title"><?php echo $jobAdvertisementRow["job_feature"] ?></h6>
                        <h6 class="card-title"><?php echo $jobAdvertisementRow["job_type"] ?></h6>
                        <p class="card-text"><?php echo "📅 ".$jobAdvertisementRow["created_date"]." 📅" ?></p>
                      </div>
                    </div>
                    </a>
                      <?php
                    }
                    ?>
                    
                    <!-- advertisement card end -->
                  </div>
                    <?php
                  }else{
                    ?>
                    <h5 class="m-5 text-danger">There is no any job advertisement for  <?php echo $companyRow["company_name"] ?></h5>
                    <?php
                  }
                  ?>
                 
                </div>
              <!-- Advertisements Card End -->

              
                
              <?php 
              $companyBlogRes = mysqli_query($db,"SELECT * FROM blogs WHERE employer_id=$companyId");
              $companyBlogRes1=mysqli_num_rows($companyBlogRes);
              ?>
              <!-- Blogs Card Start -->
                  <div class="card text-center mt-4">
                  <div class="card-header">
                    Blogs
                  </div>
                  <?php
                  if($companyBlogRes1!=0){
                    ?>
                    <div class="card-body d-flex flex-wrap justify-content-center">
                    <?php
                    while($companyBlogRow = mysqli_fetch_assoc($companyBlogRes)){
                      ?>
                    <a href="./blogDetail.php?blogId=<?php echo$companyBlogRow["id"] ?>" class="mx-2 text-dark mb-3" style="text-decoration:none;">
                     <div class="card" style="width: 16em;">
                        <img class="card-img-top" src="photos/<?php echo $companyBlogRow["blog_image"] ?>" alt="Blog image cap">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $companyBlogRow["blog_tittle"] ?></h5>
                          <p class="card-text"><?php echo substr($companyBlogRow["blog_text"],0,110)."..." ?></p>
                        </div>
                      </div>
                   </a>
                      <?php
                    }
                    ?>
                   
                   
                  </div>
                    <?php
                  }else{
                    ?>
                    <h5 class="m-5 text-danger">There is no any blog post for  <?php echo $companyRow["company_name"] ?></h5>
                    <?php
                  }
                  ?>
                </div>
              <!-- Blogs Card End -->
          </div>
        </div>
      </div>
    </div>
  
    



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>
</html>