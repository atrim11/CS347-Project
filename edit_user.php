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
  }

   $find_user_info = $conn->prepare("
   SELECT * FROM user
   WHERE user_id = ?
   ");
   $find_user_info->bindParam(1, $_SESSION["user_id"]);
   $find_user_info->execute();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- <link rel="stylesheet" href="css/feed.css">  -->
    <style>
      .like {
        color: gray;
      }

      .like:hover {
        color: red;
      } 
      
      .unlike {
        color:red;
      }

      .unlike:hover {
        color: gray;
      } 
      

      .post {
          display: block;
          position: relative;
          margin-bottom: 30px;
      }

      .post .post-author-ava {
          display: block;
          position: absolute;
          top: 0;
          left: 0;
          width: 50px;
          border-radius: 50%;
          overflow: hidden
      }

      .post .post-author-ava>img {
          display: block;
          width: 100%
      }

      .post .post-body {
          position: relative;
          padding: 24px;
          border: 1px solid #e1e7ec;
          border-radius: 7px;
          background-color: #fff
      }

      .post .post-body::after {
          border-width: 9px;
          border-color: transparent;
          border-right-color: #fff
      }

      .post .post-body::before {
          margin-top: -1px;
          border-width: 10px;
          border-color: transparent;
          border-right-color: #e1e7ec
      }

      .post .post-title {
          margin-bottom: 8px;
          color: #606975;
          font-size: 14px;
          font-weight: 500
      }

      .post .post-text {
          margin-bottom: 12px
      }

      .post .post-footer {
          display: table;
          width: 100%
      }

      .post .post-footer>.column {
          display: table-cell;
          vertical-align: middle
      }

      .post .post-footer>.column:last-child {
          text-align: right
      }

      .post .post-meta {
          color: #9da9b9;
          font-size: 13px
      }

      .post .reply-link {
          transition: color .3s;
          color: #606975;
          font-size: 14px;
          font-weight: 500;
          letter-spacing: .07em;
          text-transform: uppercase;
          text-decoration: none
      }

      .post .reply-link>i {
          display: inline-block;
          margin-top: -3px;
          margin-right: 4px;
          vertical-align: middle
      }

      .post .reply-link:hover {
          color: #0da9ef
      }

      .post.post-reply {
          margin-top: 30px;
          margin-bottom: 0
      }

      @media (max-width: 576px) {
          .post {
              padding-left: 0
          }
          .post .post-author-ava {
              display: none
          }
          .post .post-body {
              padding: 15px
          }
          .post .post-body::before,
          .post .post-body::after {
              display: none
          }
      }
    </style>
    <!-- Icon script -->
    <script
      src="https://kit.fontawesome.com/2b70e8a21a.js"
      crossorigin="anonymous"
    ></script>
    <!-- Website Icon -->
    <link rel="icon" type="image/x-icon" href="Images/logo_icon.ico" />
    <title>FitNation</title>
	<style>
		.valid {
			color: green;
			background-color: rgba(36, 207, 147, 0.1);
		}

		.invalid {
			color: red;
			background-color: rgba(255, 49, 101, 0.1);
		}
	</style>
  </head>
  <body>
    <header>
      <?php
        include("navbar.php");
      ?>
    </header>
    <body>
      <div class="container">
        <div class="main-body">

              <!-- /Breadcrumb -->
              <br>
              <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-column align-items-center text-center">
                        <!-- Profile pic <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150"> -->
                        <i class="fa fa-user fa-2xl"></i>
                        <div class="mt-3">
                          <!-- User Name Display -->
                          <h4>
                            <?php
                            echo $_SESSION["user_name"];
                            ?>
                          </h4>
                          <p class="text-secondary mb-1">
                            <!-- Displays Date Joined -->
                            <?php 
                            $date = date_create($_SESSION["date_joined"]);
                            echo "Joined: ".date_format($date,"m/d/Y");
                            ?>
                            
                          </p>
                          <p class="text-muted font-size-sm">Athlete or Coach</p>
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
										<h6 class="mb-0">
											First Name
										</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id ="fn-txtbox" type="text" class="form-control" value="<?php 
										$row = $find_user_info->fetch();
										echo $row["F_Name"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Last Name</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="ln-txtbox" type="text" class="form-control" value="<?php 
										echo $row["L_Name"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Height (in)</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="height-txtbox" type="text" class="form-control" value="<?php 
										echo $row["Height"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Weight (lbs)</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="weight-txtbox" type="text" class="form-control" value="<?php 
										echo $row["Weight"];
										?>">
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Phone Number</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<input id="phone-num-txtbox" type="text" class="form-control" value="<?php 
										if ($row["Phone_Num"] != null) {
											echo $row["Phone_Num"];
										} else {
											echo "-";
										}
										?>">
										<span id="phone_num_message">
											<ul style="list-style-type: none">
												<li id="phone_validator">Phone Number Format: <b>XXXXXXXXXX</b>.</li>
											</ul>
										</span>
									</div>

								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Gender</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<!-- <input type="text" class="form-control" value="Bay Area, San Francisco, CA"> -->
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonForGender" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<?php 
												if ($row["Gender"] != null) {
													echo $row["Gender"];
												} else {
													echo "Other";
												}
												?>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button class="dropdown-item gender-dropdown-item" type="button">Female</button>
												<button class="dropdown-item gender-dropdown-item" type="button">Male</button>
												<button class="dropdown-item gender-dropdown-item" type="button">Other</button>
											</div>
										</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="col-sm-3">
										<h6 class="mb-0">Account Type</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<div class="dropdown">
											<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonForAccounts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<?php 
											if ($row["User_Type"] == "user") {
												echo "User";
											} else {
												echo "Coach";
											}
											?>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<button class="dropdown-item usertype-dropdown-item" type="button">User</button>
												<button class="dropdown-item usertype-dropdown-item" type="button">Coach</button>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3"></div>
									<div class="col-sm-9 text-secondary">
										<input id="submit-button" type="button" class="btn btn-primary px-4" value="Save Changes">
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- </form>						 -->
			</div>
    
            </div>
        </div>
    </body>
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

	<script>


		// gender drop down dynamic functionality
		gender_drop = document.getElementById("dropdownMenuButtonForGender");
		gender_menu_items =document.querySelectorAll(".gender-dropdown-item");

		gender_menu_items.forEach(element => {
			element.onclick = function () {
				gender_drop.innerText = element.innerText;
			}
		});

		// gender drop down dynamic functionality
		usertype_drop = document.getElementById("dropdownMenuButtonForAccounts");
		usertype_menu_items =document.querySelectorAll(".usertype-dropdown-item");

		usertype_menu_items.forEach(element => {
			element.onclick = function () {
				usertype_drop.innerText = element.innerText;
			}
		});

		// save changes dynamic functionality
		submit_button = document.getElementById("submit-button");
		submit_button.onclick = function() {
			valid_weight = false;
			valid_height = false;
			valid_fname = false;
			valid_lname = false;
			valid_phone = false;
			is_coach = usertype_drop.innerText.trim() === "Coach" ? true : false;
			finish = true;

			f_name = document.getElementById("fn-txtbox");
			l_name = document.getElementById("ln-txtbox");
			height = document.getElementById("height-txtbox");
			weight = document.getElementById("weight-txtbox");
			phone_num =document.getElementById("phone-num-txtbox");

			if (!isNaN(weight.value)) {
				valid_weight = true;	
			}

			if (!isNaN(height.value)) {
				valid_height = true;
			}
			
			if (f_name.value.length > 0 && /^[A-Za-z]+$/.test(f_name.value)) {
				valid_fname = true;
			} 

			if (l_name.value.length > 0 && /^[\w'\-,.]*[^0-9_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/.test(l_name.value)) {
				valid_lname = true;
			}

			// /^\(?([0-9]{3})\)?-?([0-9]{3})-?([0-9]{4})$/
			if (/^\d{10}$/.test(phone_num.value)) {
				valid_phone = true;
			} 
			console.log("phone", valid_phone)
			

			console.log("usertype_drop", usertype_drop.innerText)
			console.log("Coach", is_coach)

			if (is_coach) {
				if (!(valid_fname && valid_lname && valid_height && valid_weight && valid_phone)) {
					console.log("Missing fields");
					console.log("iscoach", is_coach);
					console.log("fname", valid_fname);
					console.log("lname", valid_lname);
					console.log("height", valid_height);
					console.log("weight", valid_weight);
					console.log("phone",valid_phone);
					finish = false;
				}
			}
			if (finish) {
				$.ajax({
					url: 'edit_user.php',
					type: 'post',
					async: false,
					data: {
						'edited':1,
						'f_name_edited': valid_fname ? f_name.value : null,
						'l_name_edited': valid_lname ? l_name.value: null,
						'height_edited': valid_height ? height.value : null,
						'weight_edited': valid_weight ? weight.value : null,
						'phone_number_edited': valid_phone ? phone_num.value: null,
						'gender_edited':gender_drop.innerText,
						'user_type_edited':usertype_drop.innerText

					},
					success:function(){
						window.location.href='user.php';
					}
				});
				alert("Saved Changes");
			} else {
				alert("Coaches Must Correctly Fill Out All Information");
			}
			

		}

		// validating phone number
		var phone_input = document.getElementById("phone-num-txtbox");		
		var invalid = "&#x274C";
        var valid = "&#x2713;";

		phone_input.oninput = function() {
			symbol = document.getElementById("phone_validator");
			console.log(symbol)
			if (phone_input.value.match(/^\d{10}$/)) {
            symbol.innerHTML = `${valid} Phone Number Format: <b>XXXXXXXXXX</b>`;
            symbol.classList.remove("invalid");
            symbol.classList.add("valid");
			} else {
				symbol.innerHTML = `${invalid} Phone Number Format: <b>XXXXXXXXXX</b>`;
				symbol.classList.remove("valid");
				symbol.classList.add("invalid");
			}
		}
		



	</script>
  </body>
</html>
