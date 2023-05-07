<?php
  session_start();
  if (!isset($_SESSION["user_name"])) {
    header("location:index.php");
  } 
  include("db_connection.php");
  include("auth.php");

  if(isset($_POST['edited'])){
	$q= "UPDATE user SET ";
	$update_query = $conn->prepare("
	UPDATE user
	SET F_name=?, L_name=?, Height=?, Weight=?, Phone_Num = ?, Gender = ?, User_Type = ?
	WHERE user_id=?
	");

	$param_1 = $_POST['f_name_edited'] != null ? $_POST['f_name_edited'] : null;
	$param_2 = $_POST['l_name_edited'] != null ? $_POST['l_name_edited'] : null;
	$param_3 = $_POST['height_edited'] != null ? $_POST['height_edited'] : null;
	$param_4 = $_POST['weight_edited'] != null ? $_POST['weight_edited'] : null;
	$param_5 = $_POST['phone_number_edited'] != null ? $_POST['phone_number_edited'] : null;
	$param_6 = $_POST['gender_edited'] != null ? $_POST['gender_edited'] : null;
	$param_7 = $_POST['user_type_edited'] != null ? $_POST['user_type_edited'] : null;

	$update_query->bindParam(1, $param_1);
	$update_query->bindParam(2, $param_2);
	$update_query->bindParam(3, $param_3);
	$update_query->bindParam(4, $param_4);
	$update_query->bindParam(5, $param_5);
	$update_query->bindParam(6, $param_6);
	$update_query->bindParam(7, $param_7);

	$update_query->bindParam(8, $_SESSION["user_id"]);
	$update_query->execute();
	echo $_SESSION["user_id"];
	exit;
  }

   $find_user_info = $conn->prepare("
   SELECT * FROM user
   WHERE user_id = ?
   ");
   $find_user_info->bindParam(1, $_SESSION["user_id"]);
   $find_user_info->execute();
   $user_info = $find_user_info->fetch();



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    >
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Icon script -->
    <script
      src="https://kit.fontawesome.com/2b70e8a21a.js"
      crossorigin="anonymous"
    ></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico">
    <title>FitNation</title>
  	<link rel="stylesheet" href="css/edit_user.css">
  </head>
  <body>
    <header>
      <?php
        include("navbar.php");
      ?>
    </header>
      <div class="container">
        <div class="main-body">

              <!-- /Breadcrumb -->
              <br>
              <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                  <div class="card">
				  <div style="background-color: #7768AE">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center text-center">
                        <!-- Profile pic <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150"> -->
                        <i class="fa fa-user fa-2xl" style="color:white"></i>
                        <div class="mt-3" style="color:black">
                          <!-- User Info Display -->
						  <?php
                            echo "<h4 style='color:white;'>$user_info[Username]</h4>";
                            $date = date_create($user_info["Date_Joined"]);
                            echo "<p class='mb-1' style='color: white;'>Joined: ".date_format($date,"m/d/Y")."</p>"; 
                            $user_type = $user_info["User_Type"] == "coach" ? "Coach" : "User";
                            echo "<p class='font-size-sm' style='color: white'>$user_type</p>";
						   ?>
                          </p>
                        </div>
                      </div>
					</div>
                    </div>
                  </div>
                </div>
				<!-- <form action=""> -->
					<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-sm-3">
										<label for="fn-txtbox" class="mb-0">
											First Name
										</label>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id ="fn-txtbox" type="text" class="form-control" value="<?php 
										echo $user_info["F_Name"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<label for="ln-txtbox" class="mb-0">Last Name</label>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="ln-txtbox" type="text" class="form-control" value="<?php 
										echo $user_info["L_Name"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<label for="height-txtbox" class="mb-0">Height (in)</label>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="height-txtbox" type="text" class="form-control" value="<?php 
										echo $user_info["Height"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<label for="weight-txtbox" class="mb-0">Weight (lbs)</label>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="weight-txtbox" type="text" class="form-control" value="<?php 
										echo $user_info["Weight"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<label for="phone-num-txtbox" class="mb-0">Phone Number</label>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="phone-num-txtbox" type="text" class="form-control" value="<?php 
										if ($user_info["Phone_Num"] != null) {
											echo $user_info["Phone_Num"];
										} else {
											echo "-";
										}
										?>">
										<div id="phone_num_message">
											<ul style="list-style-type: none">
												<li id="phone_validator">Phone Number Format: <b>XXXXXXXXXX</b>.</li>
											</ul>
										</div>
									</div>

								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<p class="mb-0">Gender</p>
									</div>
									<div class="col-sm-9 text-secondary">
										<!-- <input type="text" class="form-control" value="Bay Area, San Francisco, CA"> -->
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonForGender" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php 
												if ($user_info["Gender"] != null) {
													echo $user_info["Gender"];
												} else {
													echo "Other";
												}
												?>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButtonForGender">
												<button class="dropdown-item gender-dropdown-item" type="button">Female</button>
												<button class="dropdown-item gender-dropdown-item" type="button">Male</button>
												<button class="dropdown-item gender-dropdown-item" type="button">Other</button>
											</div>
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<p class="mb-0">Account Type</p>
									</div>
									<div class="col-sm-9 text-secondary">
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonForAccounts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php 
											if ($user_info["User_Type"] == "user") {
												echo "User";
											} else {
												echo "Coach";
											}
											?>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButtonForAccounts">
												<button class="dropdown-item usertype-dropdown-item" type="button">User</button>
												<button class="dropdown-item usertype-dropdown-item" type="button">Coach</button>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3"></div>
									<div class="col-sm-9 text-secondary">
										<!-- if it breaks this was what it was class="btn btn-primary px-4" -->
										<input id="submit-button" type="button" class="btn btn-primary"  value="Save Changes">
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- </form>						 -->
			</div>
    
            </div>
        </div>
    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>

	<script src=".\script\edit_user.js"></script>
  </body>
</html>
