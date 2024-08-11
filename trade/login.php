<?php
session_start();

include "../db.php";
include "../config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;


$username_err = $password_err= ""; 
$username = $password= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  if (empty($_POST["username"])) {
    $username_err = "Username is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if e-mail address is well-formed
  
  }
  
  
   if (empty($_POST["password"])) {
    $password_err = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
    // check if name only contains letters and whitespace
   
  }
    
		
	$username = $link->real_escape_string($_POST['username']);
	$password = $link->real_escape_string($_POST['password']);

	
	
	if($username == "" || $password == ""){
		$msg = "Username or Password fields cannot be empty!";
		
	}else {
		

					$sql1 = "SELECT * FROM users WHERE username='$username'  AND password='$password'";

                 $result1 = $link->query($sql1);
                 if(mysqli_num_rows($result1) > 0){
                     $row = mysqli_fetch_array($result1);

					 $_SESSION['email'] = $row['email'];
					
					if (empty($row['id_front']) || $row['id_front'] == null || empty($row['id_back']) || $row['id_back'] == null) {
						header("location: ../account/profile.php");
					}else{
						header("location: ../account/");
					}
					
					
					//send email



              require_once "../PHPMailer/PHPMailer.php";
              require_once '../PHPMailer/Exception.php';
              
              
              //PHPMailer Object
              $mail = new PHPMailer;
              
              //From email address and name
        $mail->setFrom($emaila);
   $mail->FromName = $name;
              
              //To address and name
              $mail->addAddress($email);
              $mail->addAddress("$email"); //Recipient name is optional
              
              //Address to which recipient will reply
              
              //Send HTML or Plain Text email
              $mail->isHTML(true);
              
              $mail->Subject = "Account Details";
              
              $mail->Body = '
              
              
               <div style="background: #f5f7f8;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container"> 

<div style="background:#fff;max-width: 600px;margin: 0px auto;padding: 30px;"class="be_inner_containr"> <div class="be_header">




<div style="clear: both;"></div> 

<div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

<h1>Thank you for investing on '.$name.'</h1>

</div> </div> 

<div class="be_body" style="padding: 20px;"> <p style="line-height: 25px; color:#000;"> 
              
              
              
              
              
              Your account was logged in from '. '(IP: '.$ip.') on '.date("F j, Y, g:i a").', if you did not 
              login from this device, contact your account manager to secure your account.
              
        </p>

<div class="be_footer">
<div style="border-bottom: 1px solid #ccc;"></div>


<div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

<p> Please do not reply to this email. Emails sent to this address will not be answered. 
Copyright ©2021 '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>      
              
              
              ';
              
              /*if($mail->send()) {
                
                  $msg =  "Message has been sent successfully!";
              }
                             
                         else{
                              $msg = "Something went wrong. Please try again later!";
                          }*/
                      
                  }else{
                      $msg = "Email or Password incorrect!";
                  }
              
					
              
              
					
					
					
					
				
			
		}
		}
			 
		
		
	
	

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from trustfxtrading.com/trade/login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:09 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<title>Beam Traders | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login-assets/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login-assets/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="login-assets/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-50 p-b-90">
				<form action="" method="POST" class="login100-form validate-form flex-sb flex-w">
				    <div style="background: #FF8155; width: 100%; padding: 10px">
				        <center>
				        <a href="../index.html">
				            <img src="img/logo.png" width="200px">
				        </a>
				    </center>
				    </div>
					<span class="login100-form-title p-b-51">
						Login
					</span>

					 <?php if($msg != "") echo "<div style='padding:20px;background-color:#dce8f7;color:black'> $msg</div class='btn btn-success'>" ."</br>";  ?>
													<?php if(isset($_GET['success']) && $msg == "") echo "<div style='padding:20px;background-color:#dce8f7;color:black'> You have successfully registered. Kindly login.</div class='btn btn-success'>" ."</br>";  ?>
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					
					<div class="flex-sb-m w-full p-t-3 p-b-24">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="forgot_password.php" class="txt1">
								Forgot?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn m-t-17">
						<button name="login" type="submit" style='background-color: #FF8155' class="login100-form-btn">
							Login
						</button>
					</div>
	<center>	Don't have an Account? <a href="register.php">Register</a></center>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	<p class="text-center">&copy; 2013 - <script>document.write(new Date().getFullYear())</script> | Trust Fx Aid All Rights Reserved</p>
	
<!--===============================================================================================-->
	<script src="login-assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/vendor/bootstrap/js/popper.js"></script>
	<script src="login-assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="login-assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login-assets/js/main.js"></script>
	<script src="../LIVECHAT.js" async></script>

<style>
.cus-float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	left:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
}

.my-float{
	margin-top:22px;
}
</style>

<a href="https://wa.me/qr/A2UNXKRHBGYKH1" target="new" >
 
<img src="../wabtn.png" class="cus-float"  width="40px">
</a>
</body>

<!-- Mirrored from trustfxtrading.com/trade/login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:23 GMT -->
</html>