<?php
// Include config file
include "../db.php";
include "../config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


 
// Define variables and initialize with empty values
$lname = $fname =$username = $email = $password = $cpassword = $phone = "";
$lname_err = $fname_err = $username_err = $email_err = $password_err = $cpassword_err = $phone_err =  "";



if(isset($_GET['ref'])){

    $refcode = $_GET['ref'];

}else {
    $refcode='';
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


      // Validate email
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
       // Validate username
      if(empty(trim($_POST["username"]))){
        $username_err = "Please enter an username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
	 // Validate name
	 if(empty(trim($_POST["fname"]))){
        $fname_err = "Please enter first name.";     
    }else{
        $fname = trim($_POST["fname"]);
    }


	
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
   
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($fname_err) && empty($username_err)){
        
            $mobile= $_POST['mobile'];
            $country = $_POST['country'];
            $referred = $_POST['referred'];
             $zip = $_POST['zip'];
            $account_type = $_POST['account_type'];
             $refcode ='kllcabcdg19etsfjhdshdsh35678gwyjerehuhbdTSGSAWQUJHDCSMNBVCBNRTPZXMCBVN1234567890';
                $refcode = str_shuffle($refcode);
                 $refcode= substr($refcode,0, 10);
                 
                 if($referred!='')
{  
    
  $ref11usrid=$referred;
                        $qryusrref11 = "SELECT * FROM users WHERE refcode='$ref11usrid'";
                        $rslusrref11=mysqli_query($link, $qryusrref11);
                        $arrusrref11 =  mysqli_fetch_assoc($rslusrref11);
                        
                        $referred = $arrusrref11['refcode']."_";
                        
                        if($arrusrref11['referred']!='')
                          {
                            $exp_ref = explode("_", $arrusrref11['referred']);
                        $qryusrref22 = "SELECT * FROM users WHERE refcode='$exp_ref[0]' or refcode='$exp_ref[1]' or refcode='$exp_ref[2]'";
                        
                        $rslusrref22=mysqli_query($link, $qryusrref22);
                        $arrusrref22 =  mysqli_fetch_assoc($rslusrref22);
                        
                        $referred = $referred.$arrusrref22['refcode']."_";
                        
                            if($arrusrref22['referred']!='')
                            {
                                $exp_ref1 = explode("_", $arrusrref22['referred']);      
                        $qryusrref33 = "SELECT * FROM users WHERE refcode='$exp_ref1[0]' or refcode='$exp_ref1[1]' or refcode='$exp_ref1[2]'";
                        $rslusrref33=mysqli_query($link, $qryusrref33);
                        $arrusrref33 =  mysqli_fetch_assoc($rslusrref33);
                        
                        $referred = $referred.$arrusrref33['refcode']."_";
                            }
                          }
}
        // Prepare an insert statement
        $sql = "INSERT INTO users (fname, email, username, password, refcode, referred, country, phone, zip, account ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_fname, $param_email, $param_username, $param_password, $param_refcode, $param_referred, $param_country, $param_phone, $param_zip, $param_account );
			
            // Set parameters
			$param_fname = $fname;
            $param_email = $email;
            $param_username = $username;
            $param_password = $password;
            $param_refcode = $refcode;
            $param_referred = $referred;
            $param_country = $country;
            $param_phone = $mobile;
            $param_zip = $zip;
            $param_account = $account_type;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
              
require_once "../PHPMailer/PHPMailer.php";
require_once '../PHPMailer/Exception.php';


//PHPMailer Object
$mail = new PHPMailer;

    //From email address and name
        $mail->setFrom($emaila);
   $mail->FromName = $name;
              
 
$mail->addAddress("$email"); //Recipient name is optional

//Address to which recipient will reply

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Welcome Message";
$mail->Body = '
            <div style="width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container"> 
 
 <div style="max-width: 600px;margin: 0px auto;padding: 30px;"class="be_inner_containr"> <div class="be_header">
 
 
 
 <div class="be_user" style="float: left"> <p>Dear: '.$username.'</p> </div> 
 
 <div style="clear: both;"></div> 
 
 <div class="be_bluebar" style=" padding: 20px; margin-top: 10px;">
 
 <h1>Welcome Message</h1>
 
 </div> </div> 
 
 <div class="be_body" style="padding: 20px;"> <p style="line-height: 25px; color:#FF6600;"> 
 
 Hello welcome to Beam Traders,
 <br/><br/>
 Beam Traders is the future of investment, invite your family and friends to join, and you will earn bonus.
 <br/><br/>
  Your funds are 100% safe with Beam Traders, we guarantee you a profitable investment.
 <br/><br/>
 Daily withdrawal:  Yes.<br/>
  Deposit withdrawal:  Yes.
 
 </p>
 
 <div class="be_footer">
 <div style="border-bottom: 1px solid #ccc;"></div>
 
 
 <div class="be_bluebar" style=" padding: 20px;margin-top: 10px;">
 
 <p>
 Copyright ©'.$cy.' '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>';
     


if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    $msg =  "We have sent a message to your Email";
}
           echo "<script>
           window.location.href='login.php?success';
           </script>";   
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);

}

?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from trustfxtrading.com/trade/register by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:23 GMT -->
<head>
	<title>Beam Traders | Register</title>
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
				<form action=""  method="POST" class="login100-form validate-form flex-sb flex-w">
					<span class="login100-form-title p-b-51">
						Get Started
					</span>

						<div class="wrap-input100 validate-input m-b-16" data-validate = "Fullname is required">
							 
								<input type="text" name="fname"   class="input100" placeholder="Fullname" required>
							<span class="focus-input100"></span>
							<span style="color: red;"><?php echo $fname_err;?></span>
						</div>
                        
							<div class="wrap-input100 validate-input m-b-16" data-validate = "Email address is required">
						 
								<input type="email" name="email" id="email" class="input100" placeholder="Email address" required>
						<span class="focus-input100"></span>
						 <span style="color: red;"><?php echo $email_err;?></span>
						</div>
							<div class="wrap-input100 validate-input m-b-16" data-validate = "Phone number is required">
						 
								<input type="text" name="mobile" id="phone" class="input100" placeholder="Phone number" required>
						<span class="focus-input100"></span>
						</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
							 
								<select class="input100" name="country" required>
									<option value="">Select Country</option>
									<option value="United States">United States</option>
									<option value="United Kingdom">United Kingdom</option>
									<option value="Afghanistan">Afghanistan</option>
									<option value="Albania">Albania</option>
									<option value="Algeria">Algeria</option>
									<option value="American Samoa">American Samoa</option>
									<option value="Andorra">Andorra</option>
									<option value="Angola">Angola</option>
									<option value="Anguilla">Anguilla</option>
									<option value="Antarctica">Antarctica</option>
									<option value="Antigua and Barbuda">Antigua and Barbuda</option>
									<option value="Argentina">Argentina</option>
									<option value="Armenia">Armenia</option>
									<option value="Aruba">Aruba</option>
									<option value="Australia">Australia</option>
									<option value="Austria">Austria</option>
									<option value="Azerbaijan">Azerbaijan</option>
									<option value="Bahamas">Bahamas</option>
									<option value="Bahrain">Bahrain</option>
									<option value="Bangladesh">Bangladesh</option>
									<option value="Barbados">Barbados</option>
									<option value="Belarus">Belarus</option>
									<option value="Belgium">Belgium</option>
									<option value="Belize">Belize</option>
									<option value="Benin">Benin</option>
									<option value="Bermuda">Bermuda</option>
									<option value="Bhutan">Bhutan</option>
									<option value="Bolivia">Bolivia</option>
									<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
									<option value="Botswana">Botswana</option>
									<option value="Bouvet Island">Bouvet Island</option>
									<option value="Brazil">Brazil</option>
									<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
									<option value="Brunei Darussalam">Brunei Darussalam</option>
									<option value="Bulgaria">Bulgaria</option>
									<option value="Burkina Faso">Burkina Faso</option>
									<option value="Burundi">Burundi</option>
									<option value="Cambodia">Cambodia</option>
									<option value="Cameroon">Cameroon</option>
									<option value="Canada">Canada</option>
									<option value="Cape Verde">Cape Verde</option>
									<option value="Cayman Islands">Cayman Islands</option>
									<option value="Central African Republic">Central African Republic</option>
									<option value="Chad">Chad</option>
									<option value="Chile">Chile</option>
									<option value="China">China</option>
									<option value="Christmas Island">Christmas Island</option>
									<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
									<option value="Colombia">Colombia</option>
									<option value="Comoros">Comoros</option>
									<option value="Congo">Congo</option>
									<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
									<option value="Cook Islands">Cook Islands</option>
									<option value="Costa Rica">Costa Rica</option>
									<option value="Cote D'ivoire">Cote D'ivoire</option>
									<option value="Croatia">Croatia</option>
									<option value="Cuba">Cuba</option>
									<option value="Cyprus">Cyprus</option>
									<option value="Czech Republic">Czech Republic</option>
									<option value="Denmark">Denmark</option>
									<option value="Djibouti">Djibouti</option>
									<option value="Dominica">Dominica</option>
									<option value="Dominican Republic">Dominican Republic</option>
									<option value="Ecuador">Ecuador</option>
									<option value="Egypt">Egypt</option>
									<option value="El Salvador">El Salvador</option>
									<option value="Equatorial Guinea">Equatorial Guinea</option>
									<option value="Eritrea">Eritrea</option>
									<option value="Estonia">Estonia</option>
									<option value="Ethiopia">Ethiopia</option>
									<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
									<option value="Faroe Islands">Faroe Islands</option>
									<option value="Fiji">Fiji</option>
									<option value="Finland">Finland</option>
									<option value="France">France</option>
									<option value="French Guiana">French Guiana</option>
									<option value="French Polynesia">French Polynesia</option>
									<option value="French Southern Territories">French Southern Territories</option>
									<option value="Gabon">Gabon</option>
									<option value="Gambia">Gambia</option>
									<option value="Georgia">Georgia</option>
									<option value="Germany">Germany</option>
									<option value="Ghana">Ghana</option>
									<option value="Gibraltar">Gibraltar</option>
									<option value="Greece">Greece</option>
									<option value="Greenland">Greenland</option>
									<option value="Grenada">Grenada</option>
									<option value="Guadeloupe">Guadeloupe</option>
									<option value="Guam">Guam</option>
									<option value="Guatemala">Guatemala</option>
									<option value="Guinea">Guinea</option>
									<option value="Guinea-bissau">Guinea-bissau</option>
									<option value="Guyana">Guyana</option>
									<option value="Haiti">Haiti</option>
									<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
									<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
									<option value="Honduras">Honduras</option>
									<option value="Hong Kong">Hong Kong</option>
									<option value="Hungary">Hungary</option>
									<option value="Iceland">Iceland</option>
									<option value="India">India</option>
									<option value="Indonesia">Indonesia</option>
									<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
									<option value="Iraq">Iraq</option>
									<option value="Ireland">Ireland</option>
									<option value="Israel">Israel</option>
									<option value="Italy">Italy</option>
									<option value="Jamaica">Jamaica</option>
									<option value="Japan">Japan</option>
									<option value="Jordan">Jordan</option>
									<option value="Kazakhstan">Kazakhstan</option>
									<option value="Kenya">Kenya</option>
									<option value="Kiribati">Kiribati</option>
									<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
									<option value="Korea, Republic of">Korea, Republic of</option>
									<option value="Kuwait">Kuwait</option>
									<option value="Kyrgyzstan">Kyrgyzstan</option>
									<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
									<option value="Latvia">Latvia</option>
									<option value="Lebanon">Lebanon</option>
									<option value="Lesotho">Lesotho</option>
									<option value="Liberia">Liberia</option>
									<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
									<option value="Liechtenstein">Liechtenstein</option>
									<option value="Lithuania">Lithuania</option>
									<option value="Luxembourg">Luxembourg</option>
									<option value="Macao">Macao</option>
									<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
									<option value="Madagascar">Madagascar</option>
									<option value="Malawi">Malawi</option>
									<option value="Malaysia">Malaysia</option>
									<option value="Maldives">Maldives</option>
									<option value="Mali">Mali</option>
									<option value="Malta">Malta</option>
									<option value="Marshall Islands">Marshall Islands</option>
									<option value="Martinique">Martinique</option>
									<option value="Mauritania">Mauritania</option>
									<option value="Mauritius">Mauritius</option>
									<option value="Mayotte">Mayotte</option>
									<option value="Mexico">Mexico</option>
									<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
									<option value="Moldova, Republic of">Moldova, Republic of</option>
									<option value="Monaco">Monaco</option>
									<option value="Mongolia">Mongolia</option>
									<option value="Montserrat">Montserrat</option>
									<option value="Morocco">Morocco</option>
									<option value="Mozambique">Mozambique</option>
									<option value="Myanmar">Myanmar</option>
									<option value="Namibia">Namibia</option>
									<option value="Nauru">Nauru</option>
									<option value="Nepal">Nepal</option>
									<option value="Netherlands">Netherlands</option>
									<option value="Netherlands Antilles">Netherlands Antilles</option>
									<option value="New Caledonia">New Caledonia</option>
									<option value="New Zealand">New Zealand</option>
									<option value="Nicaragua">Nicaragua</option>
									<option value="Niger">Niger</option>
									<option value="Nigeria">Nigeria</option>
									<option value="Niue">Niue</option>
									<option value="Norfolk Island">Norfolk Island</option>
									<option value="Northern Mariana Islands">Northern Mariana Islands</option>
									<option value="Norway">Norway</option>
									<option value="Oman">Oman</option>
									<option value="Pakistan">Pakistan</option>
									<option value="Palau">Palau</option>
									<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
									<option value="Panama">Panama</option>
									<option value="Papua New Guinea">Papua New Guinea</option>
									<option value="Paraguay">Paraguay</option>
									<option value="Peru">Peru</option>
									<option value="Philippines">Philippines</option>
									<option value="Pitcairn">Pitcairn</option>
									<option value="Poland">Poland</option>
									<option value="Portugal">Portugal</option>
									<option value="Puerto Rico">Puerto Rico</option>
									<option value="Qatar">Qatar</option>
									<option value="Reunion">Reunion</option>
									<option value="Romania">Romania</option>
									<option value="Russian Federation">Russian Federation</option>
									<option value="Rwanda">Rwanda</option>
									<option value="Saint Helena">Saint Helena</option>
									<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
									<option value="Saint Lucia">Saint Lucia</option>
									<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
									<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
									<option value="Samoa">Samoa</option>
									<option value="San Marino">San Marino</option>
									<option value="Sao Tome and Principe">Sao Tome and Principe</option>
									<option value="Saudi Arabia">Saudi Arabia</option>
									<option value="Senegal">Senegal</option>
									<option value="Serbia and Montenegro">Serbia and Montenegro</option>
									<option value="Seychelles">Seychelles</option>
									<option value="Sierra Leone">Sierra Leone</option>
									<option value="Singapore">Singapore</option>
									<option value="Slovakia">Slovakia</option>
									<option value="Slovenia">Slovenia</option>
									<option value="Solomon Islands">Solomon Islands</option>
									<option value="Somalia">Somalia</option>
									<option value="South Africa">South Africa</option>
									<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
									<option value="Spain">Spain</option>
									<option value="Sri Lanka">Sri Lanka</option>
									<option value="Sudan">Sudan</option>
									<option value="Suriname">Suriname</option>
									<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
									<option value="Swaziland">Swaziland</option>
									<option value="Sweden">Sweden</option>
									<option value="Switzerland">Switzerland</option>
									<option value="Syrian Arab Republic">Syrian Arab Republic</option>
									<option value="Taiwan, Province of China">Taiwan, Province of China</option>
									<option value="Tajikistan">Tajikistan</option>
									<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
									<option value="Thailand">Thailand</option>
									<option value="Timor-leste">Timor-leste</option>
									<option value="Togo">Togo</option>
									<option value="Tokelau">Tokelau</option>
									<option value="Tonga">Tonga</option>
									<option value="Trinidad and Tobago">Trinidad and Tobago</option>
									<option value="Tunisia">Tunisia</option>
									<option value="Turkey">Turkey</option>
									<option value="Turkmenistan">Turkmenistan</option>
									<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
									<option value="Tuvalu">Tuvalu</option>
									<option value="Uganda">Uganda</option>
									<option value="Ukraine">Ukraine</option>
									<option value="United Arab Emirates">United Arab Emirates</option>
									<option value="United Kingdom">United Kingdom</option>
									<option value="United States">United States</option>
									<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
									<option value="Uruguay">Uruguay</option>
									<option value="Uzbekistan">Uzbekistan</option>
									<option value="Vanuatu">Vanuatu</option>
									<option value="Venezuela">Venezuela</option>
									<option value="Viet Nam">Viet Nam</option>
									<option value="Virgin Islands, British">Virgin Islands, British</option>
									<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
									<option value="Wallis and Futuna">Wallis and Futuna</option>
									<option value="Western Sahara">Western Sahara</option>
									<option value="Yemen">Yemen</option>
									<option value="Zambia">Zambia</option>
									<option value="Zimbabwe">Zimbabwe</option>
								</select>
						 <span class="focus-input100"></span>
						</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Zip is required">
						 
								<input type="text" name="zip" id="zip" class="input100" placeholder="Zip Code" required>
						 
						</div>

							<div class="wrap-input100 validate-input m-b-16" data-validate = "Account Type is required">
						 
								<select class="input100" name="account_type" required>
									<option value="" selected="">Account Type </option>
									<option value="Starter">Starter : $100 - $4,999</option>
									<option value="Advanced">Advanced : $10,000 - $9,999</option>
									<option value="Professional">Professional : $10,000 - $19,999</option>
									<option value="Ultimate">Ultimate : $20,000 - $50,000</option>
								</select>
						 <span class="focus-input100"></span>
						</div>
                             <input type="hidden" name="referred" value="<?php echo $refcode;?>" />
							<div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
						 
								 
								<input type="text" name="username" id="username" class="input100" placeholder="Username" required>
								<span class="focus-input100"></span>
								 <span style="color: red;"><?php echo $username_err;?></span>
						 
						</div>

                        	<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
						 
								<input type="password" name="password" id="password" class="input100" placeholder="Your password" required>
								<span class="focus-input100"></span>
								 <span style="color: red;"><?php echo $password_err;?></span>
							 
							
						</div>
                        
					 

					<div class="container-login100-form-btn m-t-17">
						<button name="register" type="submit" style='background-color:#FF8155' class="login100-form-btn">
							Get Started
						</button>
					</div>

				 
					<center>	Already have an Account? <a href="login.php">Login</a></center>
				 
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
    <p class="text-center">&copy; 2022 - <script>document.write(new Date().getFullYear())</script> | Beam Traders All Rights Reserved</p>
	
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

<!-- Mirrored from trustfxtrading.com/trade/register by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 24 Jan 2022 06:10:23 GMT -->
</html>