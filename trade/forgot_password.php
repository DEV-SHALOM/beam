<?php
session_start();

include "../db.php";
include "../config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;


$email_err = $password_err= ""; 
$email = $password= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
  if (empty($_POST["email"])) {
    $email_err = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format"; 
    }
  }
  
 
		
	$email = $link->real_escape_string($_POST['email']);

	
	
	if($email == ""){
		$msg = "Email fields cannot be empty!";
		
	}else {
		

					$sql1 = "SELECT * FROM users WHERE email='$email'";

                 $result1 = $link->query($sql1);
                 if(mysqli_num_rows($result1) > 0){
                     $row = mysqli_fetch_assoc($result1);

					 $password = $row['password'];
					 $username = $row['username'];
					
					
					//send email



              require_once "../PHPMailer/PHPMailer.php";
              require_once '../PHPMailer/Exception.php';
              
              
              //PHPMailer Object
              $mail = new PHPMailer;
              
              //From email address and name
        $mail->setFrom($emaila);
   $mail->FromName = $name;
              
              //To address and name
              $mail->addAddress($email); //Recipient name is optional
              
              //Address to which recipient will reply
              
              //Send HTML or Plain Text email
              $mail->isHTML(true);
              
              $mail->Subject = "Password Recovery";
              
              $mail->Body = '
          <div style="background: #fff;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container"> 
 
 <div style="background:#fff;max-width: 600px;margin: 0px auto;padding: 30px;"class="be_inner_containr"> <div class="be_header">
 
 
 
 <div class="be_user" style="float: left"> <p>Dear: '.$username.'</p> </div> 
 
 <div style="clear: both;"></div> 
 
 <div class="be_bluebar" style="background: #fff; padding: 20px; color: #000;margin-top: 10px;">
 
 <h1>Password Recovery</h1>
 
 </div> </div> 
 
 <div class="be_body" style="padding: 20px;"> <p style="line-height: 25px; color:#fff;"> 
 
 Your password is: <b>'.$password.'</b>
 
 </p>
 
 <div class="be_footer">
 <div style="border-bottom: 1px solid #ccc;"></div>
 
 
 <div class="be_bluebar" style="background: #fff; padding: 20px; color: #000;margin-top: 10px;">
 
 <p>
 Copyright ©'.$cy.' '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>';
     

              
              if($mail->send()) {
                
                 $msg =  "Check Your Email to get your password";
              }
                             
                         else{
                              $msg = "Something went wrong. Please try again later!";
                          }
                      
                  }else{
                     $msg =  "E-mail not found!";
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

<!-- Mirrored from trustfxtrading.com/trade/forgot_password by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:30 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
	<title>Trust Fx Trading | Forgot Password</title>
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
					<span class="login100-form-title p-b-51">
						Forget password
					</span>
                    <?php if($msg != "") echo "<div style='padding:20px;background-color:#dce8f7;color:black'> $msg</div class='btn btn-success'>" ."</br>";  ?>
					
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Email is required">
						<input class="input100" type="text" name="email" placeholder="Email address">
						<span class="focus-input100"></span>
					</div>
					
					
				 

					<div class="container-login100-form-btn m-t-17">
						<button name="reset_password" type="submit" class="login100-form-btn">
							Submit
						</button>
					</div>
 
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
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

</body>

<!-- Mirrored from trustfxtrading.com/trade/forgot_password by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:30 GMT -->
</html>




